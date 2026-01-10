<div>
    <div class="p-6" x-data="{ open: @entangle('showForm') }">
        <div class="flex justify-between mb-4">
            <input type="text" wire:model.blur="search" class="border rounded px-3 py-2"
                placeholder="Pesquisar usuário...">


            <button @click="open = true" wire:click="create" class="bg-blue-600 text-white px-4 py-2 rounded">
                Novo Usuário
            </button>
        </div>

        <div class="flex gap-2">
            <button wire:click="exportCsv" class="bg-gray-700 text-white px-4 py-2 rounded">
                Exportar CSV
            </button>


            <button wire:click="exportPdf" class="bg-red-600 text-white px-4 py-2 rounded">
                Exportar PDF
            </button>
        </div>

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Nome</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2 flex gap-2">
                            <button wire:click="edit({{ $user->id }})" class="text-blue-600">Editar</button>


                            <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600">
                                Excluir
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{ $users->links() }}


        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 flex justify-end z-50">
            <div x-show="open" x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full" class="bg-white w-96 p-6 h-full shadow-xl">
                <h2 class="text-xl font-bold mb-4">Usuário</h2>

                <input wire:model.defer="name" class="border w-full mb-2 p-2" placeholder="Nome">
                <input wire:model.defer="email" class="border w-full mb-2 p-2" placeholder="Email">
                <input wire:model.defer="password" type="password" class="border w-full mb-4 p-2" placeholder="Senha">

                <div class="flex justify-end gap-2">
                    <button @click="open = false" class="px-4 py-2 border rounded">
                        Cancelar
                    </button>
                    <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ open: @entangle('confirmingDelete') }" x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        @keydown.escape.window="open = false">
        <div x-show="open" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="bg-white w-full max-w-md rounded-lg shadow-xl p-6">
            <h3 class="text-lg font-semibold mb-4">
                Confirmar exclusão
            </h3>

            <p class="text-gray-600 mb-6">
                Tem certeza que deseja excluir este usuário?
                Esta ação não poderá ser desfeita.
            </p>

            <div class="flex justify-end gap-2">
                <button @click="open = false" class="px-4 py-2 border rounded hover:bg-gray-100">
                    Cancelar
                </button>

                <button wire:click="deleteConfirmed" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Excluir
                </button>
            </div>
        </div>
    </div>

</div>
