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

<body class="h-full">

    <div x-data="{
        // Estado principal
        sidebarOpen: true,
    
        // Toggle sidebar
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        }
    }" class="h-full">
        <nav>
            <div class="flex h-16 items-center justify-between px-4">
                <div class="flex">
                    <button @click="toggleSidebar()" class="mr-2">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Logo</h1>
                </div>
                <div>
                    <p>Usuário</p>
                </div>
            </div>
        </nav>

        <div class="flex h-[calc(100vh-64px)]">
            <aside :class="{
                'w-64': sidebarOpen,
                'w-20': !sidebarOpen
            }"
                class="h-full">
                <p>menu</p>
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
