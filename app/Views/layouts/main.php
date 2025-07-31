<!DOCTYPE html>
<html class="h-full"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }"
      x-init="
        if (localStorage.getItem('darkMode') === null) {
            darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        $watch('darkMode', val => localStorage.setItem('darkMode', val))
      ">
<head>
    <title><?= esc($title ?? 'Ingeeky Support') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('css/output.css') ?>" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@500;600;700&family=Poppins:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>

        [x-cloak] {
            display: none !important;
        }

        .full-width {
            max-width: none !important;
            padding: 0 !important;
            background: none !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .site-logo {
            font-family: 'Work Sans', sans-serif;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-family: 'Work Sans', sans-serif;
            font-weight: 500;
            letter-spacing: -0.2px;
        }

        .nav-button {
            font-family: 'Work Sans', sans-serif;
            font-weight: 600;
            letter-spacing: -0.2px;
        }
    </style>
</head>

<body class="flex flex-col min-h-full bg-slate-50 dark:bg-gray-900 transition-colors">
<!-- Header -->
<header class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg">
                    <img src="<?= base_url('images/Ingeeky Logo.08.29_2165feb4-removebg-preview.png') ?>"
                         alt="Ingeeky Logo"
                         class="h-10">
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Ingeeky
                </h1>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                <?php
                $currentURL = current_url(true);
                $currentPath = $currentURL->getPath();
                ?>

                <a href="/" class="nav-link group">
                        <span class="relative <?= $currentPath === '/' ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400' ?>">
                            Home
                            <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform <?= $currentPath === '/' ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' ?> transition-transform"></span>
                        </span>
                </a>
                <a href="/about-us" class="nav-link group">
                        <span class="relative <?= $currentPath === '/about-us' ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400' ?>">
                            About
                            <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform <?= $currentPath === '/about-us' ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' ?> transition-transform"></span>
                        </span>
                </a>
                <a href="/services" class="nav-link group">
                        <span class="relative <?= $currentPath === '/services' ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400' ?>">
                            Services
                            <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform <?= $currentPath === '/services' ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' ?> transition-transform"></span>
                        </span>
                </a>

                <?php if (auth()->loggedIn()): ?>
                    <?php if (auth()->user()->inGroup('admin')): ?>
                        <a href="<?= url_to('products.index') ?>" class="nav-link group">
                                <span class="relative <?= str_contains($currentPath, '/products') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400' ?>">
                                    Products
                                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform <?= str_contains($currentPath, '/products') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' ?> transition-transform"></span>
                                </span>
                        </a>
                        <a href="<?= url_to('admin.users.index') ?>" class="nav-link group">
                                <span class="relative <?= str_contains($currentPath, '/admin/users') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400' ?>">
                                    Users
                                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform <?= str_contains($currentPath, '/admin/users') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' ?> transition-transform"></span>
                                </span>
                        </a>
                    <?php endif; ?>

                    <a href="<?= url_to('tickets') ?>" class="px-4 py-2 rounded-lg <?= str_contains($currentPath, '/tickets') ? 'bg-red-700 shadow-lg' : 'bg-red-600 hover:bg-red-700' ?> text-white transition-colors shadow-md hover:shadow-lg">
                        My Tickets
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 flex items-center justify-center hover:border-red-400 transition-colors">
                                <i class="fas fa-user-circle text-xl text-gray-600 dark:text-gray-400"></i>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform"
                               :class="{ 'transform rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-cloak
                        <div x-show="open"
                             x-cloak
                             @click.away="open = false"
                             @keydown.escape.window="open = false"
                             class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-gray-800 shadow-lg border border-gray-100 dark:border-gray-700 py-1"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">


                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white"><?= auth()->user()->username ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?= auth()->user()->email ?></p>
                            </div>

                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-500">
                                <i class="fas fa-user-circle w-5 mr-2"></i>My Profile
                            </a>

                            <a href="/account/settings" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-500">
                                <i class="fas fa-cog w-5 mr-2"></i>Account Settings
                            </a>

                            <?php if (auth()->user()->inGroup('admin')): ?>
                                <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-500">
                                    <i class="fas fa-shield-alt w-5 mr-2"></i>Admin Dashboard
                                </a>
                            <?php endif; ?>

                            <!-- Dark Mode Toggle -->
                            <div class="border-t border-gray-100 dark:border-gray-700">
                                <button @click="darkMode = !darkMode"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-500 flex items-center">
                                    <i class="fas fa-moon w-5 mr-2" :class="darkMode ? 'text-red-500' : ''"></i>
                                    <span>Dark Mode</span>
                                    <div class="ml-auto">
                                        <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-gray-200 dark:bg-gray-700"
                                             :class="{ 'bg-red-500': darkMode }">
                                            <div class="absolute h-4 w-4 transform rounded-full bg-white transition-transform"
                                                 :class="darkMode ? 'translate-x-4' : 'translate-x-1'"></div>
                                        </div>
                                    </div>
                                </button>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700">
                                <form action="/logout" method="get" class="block">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-500">
                                        <i class="fas fa-sign-out-alt w-5 mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= url_to('login') ?>" class="px-4 py-2 rounded-lg <?= $currentPath === '/login' ? 'bg-red-700 shadow-lg' : 'bg-red-600 hover:bg-red-700' ?> text-white transition-colors shadow-md hover:shadow-lg">
                        Login
                    </a>
                    <a href="<?= url_to('register') ?>" class="px-4 py-2 rounded-lg border-2 border-red-600 <?= $currentPath === '/register' ? 'bg-red-600 text-white shadow-lg' : 'text-red-600 dark:text-red-400 hover:bg-red-600 hover:text-white' ?> transition-colors shadow-sm hover:shadow-md">
                        Register
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

<!-- Main content -->
<main class="flex-grow">
    <?= $this->renderSection('content') ?>
</main>



<footer class="bg-gray-900 dark:bg-gray-950 text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg">
                        <img src="<?= base_url('images/Ingeeky Logo.08.29_2165feb4-removebg-preview.png') ?>"
                             alt="Ingeeky Logo"
                             class="h-8">
                    </div>
                    <h3 class="text-xl font-semibold text-white">InGeeky</h3>
                </div>
                <p class="text-red-400 font-medium mb-2">Geekify your business</p>
            </div>

            <!-- Contact & Hours -->
            <div class="grid grid-cols-2 gap-6">
                <!-- Contact Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-800 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-red-500"></i>
                        </div>
                        <span class="text-gray-300 dark:text-gray-400">Ringweg-Noord 124</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-800 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-red-500"></i>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <a href="mailto:info@ingeeky.com" class="text-gray-300 dark:text-gray-400 hover:text-red-400 transition-colors">info@ingeeky.com</a>
                            <a href="mailto:quote@ingeeky.com" class="text-gray-300 dark:text-gray-400 hover:text-red-400 transition-colors">quote@ingeeky.com</a>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-800 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-red-500"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-300 dark:text-gray-400">Ma-Vr: 09:00-18:00</span>
                            <span class="text-gray-300 dark:text-gray-400">Za: 09:00-12:00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="flex justify-end items-start space-x-4">
                <a href="#" class="w-10 h-10 bg-gray-800 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-red-500 transition-colors">
                    <i class="fab fa-facebook-f text-gray-300 dark:text-gray-400 hover:text-white"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-800 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-red-500 transition-colors">
                    <i class="fab fa-instagram text-gray-300 dark:text-gray-400 hover:text-white"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-800 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-red-500 transition-colors">
                    <i class="fab fa-linkedin-in text-gray-300 dark:text-gray-400 hover:text-white"></i>
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 dark:border-gray-700 mt-6 pt-6 text-center text-sm text-gray-400 dark:text-gray-500">
            <p>&copy; <?= date('Y') ?> InGeeky. Alle rechten voorbehouden.</p>
        </div>
    </div>
</footer>

<style>
    .nav-link {
        @apply text-slate-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors flex items-center;
    }
</style>
</body>
</html>