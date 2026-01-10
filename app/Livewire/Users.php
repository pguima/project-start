<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class Users extends Component
{
    use WithPagination;

    public $search = '';

    public $name;

    public $email;

    public $password;

    public $userId;

    public $showForm = false;

    public $confirmingDelete = false;

    public $userIdToDelete;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6'
        ];
    }

    public function render()
    {
        return view('livewire.users', [
            'users' => User::where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->paginate(10),
        ]);
    }

    public function create()
    {
        $this->resetFields();
        $this->showForm = true;
    }

    public function edit(User $user)
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        User::updateOrCreate(
            ['id' => $this->userId],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
                ? Hash::make($this->password)
                : User::find($this->userId)?->password,
            ]
        );

        $this->resetFields();
        $this->showForm = false;
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    private function resetFields()
    {
        $this->reset(['name', 'email', 'password', 'userId']);
    }

    

    public function confirmDelete($id)
    {
        $this->userIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function deleteConfirmed()
    {
        User::findOrFail($this->userIdToDelete)->delete();
        $this->confirmingDelete = false;
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'usuarios.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nome', 'Email']);

            User::where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->chunk(200, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [$user->name, $user->email]);
                }
            });

            fclose($handle);
        }, $fileName);
    }


    public function exportPdf()
    {
        $users = User::where('name', 'like', "%{$this->search}%")
        ->orWhere('email', 'like', "%{$this->search}%")
        ->get();

        $pdf = Pdf::loadView('pdf.users', compact('users'));

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'usuarios.pdf'
        );
    }

}
