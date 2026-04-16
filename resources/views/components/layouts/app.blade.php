<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BotsLMS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                    colors: {
                        'brand': {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                                </div>
                                <span class="text-xl font-bold tracking-tight text-slate-800">Bots<span class="text-indigo-600">LMS</span></span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex h-full">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i>
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            
                            @can('viewAny', App\Models\Loan::class)
                                <x-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')">
                                    <i data-lucide="banknote" class="w-4 h-4 mr-2"></i>
                                    {{ __('Loans') }}
                                </x-nav-link>
                            @endcan

                            @can('viewAny', App\Models\Customer::class)
                                <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                    {{ __('Customers') }}
                                </x-nav-link>
                            @endcan

                            <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                                <i data-lucide="bar-chart-3" class="w-4 h-4 mr-2"></i>
                                {{ __('Reports') }}
                            </x-nav-link>

                            @can('viewAny', App\Models\LoanAgreementTemplate::class)
                                <x-nav-link :href="route('templates.index')" :active="request()->routeIs('templates.*')">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    {{ __('Templates') }}
                                </x-nav-link>
                            @endcan

                            @can('viewAny', App\Models\Subscription::class)
                                <x-nav-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')">
                                    <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i>
                                    {{ __('Subscriptions') }}
                                </x-nav-link>
                            @endcan
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="flex items-center space-x-4 bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100">
                            <div class="flex flex-col items-end">
                                <span class="text-sm font-bold text-slate-700">{{ Auth::user()?->name }}</span>
                                <span class="text-[10px] uppercase tracking-wider font-semibold text-slate-400">{{ Auth::user()?->user_type }}</span>
                            </div>
                            <div class="w-8 h-8 bg-white rounded-xl border border-slate-200 flex items-center justify-center">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="border-l border-slate-200 pl-4">
                                @csrf
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-8 flex items-center p-4 text-emerald-800 bg-emerald-50 border border-emerald-100 rounded-2xl shadow-sm">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-emerald-500"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mb-8 flex items-center p-4 text-rose-800 bg-rose-50 border border-rose-100 rounded-2xl shadow-sm">
                        <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-rose-500"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>