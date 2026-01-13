<div>
    <div class="p-8" x-data="{ open: @entangle('showForm') }">

        <!-- Content Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 capitalize" x-text="activeSection"></h1>
                    <p class="text-gray-600">Bem-vindo ao seu painel de controle</p>
                </div>

            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total de Visitas</p>
                            <p class="text-2xl font-bold text-gray-800">12,847</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i> 12% desde o mês passado
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Taxa de Conversão</p>
                            <p class="text-2xl font-bold text-gray-800">3.24%</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-percentage text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i> 5% desde o mês passado
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Tempo no Site</p>
                            <p class="text-2xl font-bold text-gray-800">4m 32s</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-red-600">
                        <i class="fas fa-arrow-down mr-1"></i> 2% desde o mês passado
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Usuários Ativos</p>
                            <p class="text-2xl font-bold text-gray-800">1,248</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i> 8% desde o mês passado
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex justify-between mb-4">
                <input type="text" wire:model.blur="search"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Pesquisar usuário...">


                <div>
                    <button wire:click="exportCsv" class="border border-gray-300 rounded px-4 py-2">
                        <i class="fa fa-file-excel"></i> CSV
                    </button>
                    <button wire:click="exportPdf" class="border border-gray-300 rounded px-4 py-2">
                        <i class="fa fa-file-pdf"></i> PDF
                    </button>
                    <button @click="open = true" wire:click="create"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded">
                        Novo Usuário
                    </button>
                </div>
            </div>
            <table class="table-auto w-full mt-4 border-collapse border">
                <thead>
                    <tr>
                        <th class="p-2">Nome</th>
                        <th class="p-2">Email</th>
                        <th class="p-2 w-24">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t">
                            <td class="p-2">{{ $user->name }}</td>
                            <td class="p-2">{{ $user->email }}</td>
                            <td class="p-2 gap-2">
                                <button wire:click="edit({{ $user->id }})"
                                    class="p-1 border border-gray-300 rounded text-gray-600 hover:text-blue-800"><i class="fa fa-pencil"></i></button>


                                <button wire:click="confirmDelete({{ $user->id }})"
                                    class="p-1 border border-gray-300 rounded text-gray-600 hover:text-red-800">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}

        </div>

        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 flex justify-end z-50">
            <div x-show="open" x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="bg-white w-96 p-6 h-full shadow-xl">

                <div class="mb-6 border-b border-gray-200 pb-4">
                    <h2 class="text-xl font-bold">Usuário</h2>
                </div>
                

                <input wire:model.defer="name"
                    class="border border-gray-300 rounded-md w-full mb-2 p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Nome">
                <input wire:model.defer="email"
                    class="border border-gray-300 rounded-md w-full mb-2 p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Email">
                <input wire:model.defer="password" type="password"
                    class="border border-gray-300 rounded-md w-full mb-4 p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Senha">

                <div class="flex justify-end gap-2">
                    <button @click="open = false" class="px-4 py-2 border border-gray-300 rounded">
                        Cancelar
                    </button>
                    <button wire:click="save" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded">
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
                <button @click="open = false" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                    Cancelar
                </button>

                <button wire:click="deleteConfirmed" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Excluir
                </button>
            </div>
        </div>
    </div>

</div>
