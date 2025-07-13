<!DOCTYPE html>
<html class="h-full">
<head>
    <title><?= esc($title ?? 'Ingeeky Support') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('css/output.css') ?>" rel="stylesheet">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="flex flex-col min-h-full bg-slate-50">
<!-- Navbar with glass effect -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="<?= base_url('images/Ingeeky Logo.08.29_2165feb4-removebg-preview.png') ?>"
                     alt="Ingeeky Logo"
                     class="h-10">
                <h1 class="text-2xl font-bold text-gray-900">
                    Ingeeky
                </h1>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                <a href="/" class="nav-link group">
                    <span class="relative text-gray-700 hover:text-red-600">
                        Home
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform"></span>
                    </span>
                </a>
                <a href="/about-us" class="nav-link group">
                    <span class="relative text-gray-700 hover:text-red-600">
                        About
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform"></span>
                    </span>
                </a>
                <a href="/services" class="nav-link group">
                    <span class="relative text-gray-700 hover:text-red-600">
                        Services
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform"></span>
                    </span>
                </a>

                <?php if (auth()->loggedIn()): ?>
                    <a href="<?= url_to('tickets') ?>" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                        My Tickets
                    </a>
                <?php else: ?>
                    <a href="<?= url_to('login') ?>" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                        Login
                    </a>
                    <a href="<?= url_to('register') ?>" class="px-4 py-2 rounded-lg border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                        Register
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

<!-- Main content -->
<main class="flex-grow container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <?= $this->renderSection('content') ?>
    </div>
</main>

<!-- Footer -->
<footer class="bg-white border-t border-slate-200 mt-8">
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-slate-600 mb-4 md:mb-0">
                <i class="fas fa-ticket-alt text-red-600 mr-2"></i>
                &copy; <?= date('Y') ?> Ingeeky - Professional Ticketing System
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-slate-500 hover:text-blue-600 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-slate-500 hover:text-blue-600 transition-colors">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="text-slate-500 hover:text-blue-600 transition-colors">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<style>
    .nav-link {
        @apply text-slate-600 hover:text-blue-600 transition-colors flex items-center;
    }
</style>
</body>
</html>