<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="h-full bg-gray-50">

    <div x-data="{
        // Estado principal
        sidebarOpen: true,
    
        // Toggle sidebar
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        activeSection: 'dashboard',
        // Menu items
        menuItems: [
            { id: 'dashboard', label: 'Dashboard', icon: 'fa-tachometer-alt', badge: null },
            { id: 'projects', label: 'Projetos', icon: 'fa-folder', badge: '3' },
            { id: 'tasks', label: 'Tarefas', icon: 'fa-tasks', badge: '12' },
            { id: 'calendar', label: 'Calendário', icon: 'fa-calendar', badge: null },
            { id: 'messages', label: 'Mensagens', icon: 'fa-envelope', badge: '5' },
            { id: 'team', label: 'Equipe', icon: 'fa-users', badge: null },
            { id: 'settings', label: 'Configurações', icon: 'fa-cog', badge: null },
            { id: 'reports', label: 'Relatórios', icon: 'fa-chart-bar', badge: 'new' },
            { id: 'help', label: 'Ajuda', icon: 'fa-question-circle', badge: null }
        ],
        // Set active section
        setActiveSection(section) {
            this.activeSection = section;
        },
    }" class="h-full">
        <nav class="bg-white px-4 py-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex space-x-4 ml-4">
                    <button @click="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cube text-white"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-800">DashboardPro</h1>
                    </div>
                </div>
                <!-- User menu -->
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium text-gray-800">João Silva</p>
                        <p class="text-xs text-gray-500">Administrador</p>
                    </div>
                    <div
                        class="w-9 h-9 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full flex items-center justify-center text-white font-semibold">
                        JS
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex h-[calc(100vh-64px)]">

            <!-- Sidebar Content -->
            <aside :class="{
                'w-64': sidebarOpen,
                'w-20': !sidebarOpen
            }"
                class="h-full">

                <!-- Sidebar Header -->
                <div class="p-4 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div x-show="sidebarOpen === true">
                            <h2 class="font-bold">Navegação</h2>
                            <p class="text-xs text-gray-300">Menu principal</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <nav class="flex-1 p-4">
                    <ul class="space-y-1">
                        <template x-for="item in menuItems" :key="item.id">
                            <li>
                                <a href="#" @click="setActiveSection(item.id)"
                                    :class="{
                                        'bg-blue-600/20 border-l-4 border-blue-500': activeSection === item.id,
                                        'hover:bg-gray-800/50': activeSection !== item.id,
                                        'justify-center': sidebarOpen !== true,
                                        'px-4 py-3 rounded-lg': sidebarOpen === true,
                                        'px-3 py-3 rounded-lg': sidebarOpen === false,
                                        'p-3 rounded-lg': sidebarOpen === false
                                    }"
                                    class="flex items-center sidebar-transition group">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <i :class="item.icon" class="fas text-lg"
                                            :class="{
                                                'text-blue-400': activeSection === item.id,
                                                'text-gray-400 group-hover:text-gray-300': activeSection !== item.id
                                            }"></i>
                                    </div>

                                    <!-- Label (visível apenas no modo full) -->
                                    <div class="ml-3 flex-1 flex items-center justify-between overflow-hidden"
                                        x-show="sidebarType === 'full'">
                                        <span class="font-medium" x-text="item.label"></span>

                                        <!-- Badge -->
                                        <span x-show="item.badge" class="text-xs px-2 py-1 rounded-full"
                                            :class="{
                                                'bg-blue-500': item.badge !== 'new',
                                                'bg-green-500': item.badge === 'new'
                                            }"
                                            x-text="item.badge === 'new' ? 'Novo' : item.badge">
                                        </span>
                                    </div>

                                    <!-- Tooltip para modos mini e icons -->
                                    <div x-show="sidebarType !== 'full'"
                                        class="absolute left-full ml-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap">
                                        <span x-text="item.label"></span>
                                        <span x-show="item.badge"
                                            class="ml-2 text-xs px-1.5 py-0.5 rounded-full bg-blue-500"
                                            x-text="item.badge === 'new' ? 'N' : item.badge">
                                        </span>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </ul>
                </nav>
            </aside>

            <main
                :class="{
                    'w-[calc(100vw-16rem)]': sidebarOpen,
                    'w-[calc(100vw-5rem)]': !sidebarOpen
                }">

                {{ $slot }}

            </main>
        </div>

    </div>
    @livewireScripts
</body>

</html>
