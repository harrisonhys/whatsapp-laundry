<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laundry Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-white text-xl font-bold">
                        Laundry System
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard*') ? 'bg-blue-700' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pesanan.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pesanan*') ? 'bg-blue-700' : '' }}">
                        Pesanan
                    </a>
                    <a href="{{ route('pelanggan.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pelanggan*') ? 'bg-blue-700' : '' }}">
                        Pelanggan
                    </a>
                    <a href="{{ route('admin.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin*') ? 'bg-blue-700' : '' }}">
                        Admin
                    </a>
                    <a href="{{ route('dashboard.report') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard.report') ? 'bg-blue-700' : '' }}">
                        Laporan
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Setup CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Auto-refresh CSRF token if needed
        setInterval(function() {
            fetch('/sanctum/csrf-cookie')
                .then(() => {
                    // Token refreshed
                })
                .catch(() => {
                    // Ignore errors
                });
        }, 300000); // Refresh every 5 minutes
    </script>
</body>
</html>
