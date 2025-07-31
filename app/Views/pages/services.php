<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="relative overflow-hidden min-h-screen">
        <!-- Enhanced Animated Background -->
        <div class="absolute inset-0 bg-gradient-circles opacity-5"></div>
        <div class="absolute inset-0 bg-pattern opacity-5"></div>

        <!-- Hero Section -->
        <div class="relative py-20 overflow-hidden">
            <div class="container mx-auto px-4">
                <div class="text-center space-y-6 fade-in">
                    <span class="inline-block px-6 py-2 text-sm font-medium text-red-500 bg-red-50 rounded-full shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
                        Onze Diensten 🚀
                    </span>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                        Wat kunnen wij
                        <span class="relative">
                            <span class="bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                                voor u betekenen?
                            </span>
                            <svg class="absolute -bottom-2 left-0 w-full h-2 text-red-200" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path fill="currentColor" d="M0 5 Q 25 0, 50 5 Q 75 10, 100 5 L 100 10 L 0 10 Z"/>
                            </svg>
                        </span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="container mx-auto px-4 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto slide-up-delay">
                <div class="group hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl border border-gray-100 shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <div class="h-64 overflow-hidden relative">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="/Videos/Web Development.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Websiteontwikkeling</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">Of u nu kiest voor een template of een unieke ontwikkeling, wij bouwen schaalbare websites die presteren.</p>
                        </div>
                    </div>
                </div>

                <div class="group hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl border border-gray-100 shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <div class="h-64 overflow-hidden relative">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="/Videos/Custom Software Solutions.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Custom Software Solutions</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">Oplossingen op maat voor interne bedrijfsprocessen, dashboards, API-integraties, en administratieve workflows.</p>
                        </div>
                    </div>
                </div>

                <div class="group hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl border border-gray-100 shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <div class="h-64 overflow-hidden relative">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="/Videos/Drones.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Drone Cinematics</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">Professionele luchtopnames in 4K-kwaliteit voor promotievideo's, vastgoedpresentaties en bedrijfsevenementen.</p>
                        </div>
                    </div>
                </div>

                <div class="group hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl border border-gray-100 shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <div class="h-64 overflow-hidden relative">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="/Videos/Networking.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Netwerkinfrastructuur</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">Ontwerp, aanleg en onderhoud van netwerken voor kantoren en bedrijfspanden met focus op veiligheid, automatisering en toekomstbestendigheid.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-circles {
            background-image:
                    radial-gradient(circle at 20% 20%, rgba(239, 68, 68, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(0, 0, 0, 0.05) 0%, transparent 50%);
        }
        .bg-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(239, 68, 68, 0.07) 1px, transparent 0);
            background-size: 20px 20px;
        }
        .fade-in {
            animation: fadeIn 1s ease-out;
        }
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        .slide-up-delay {
            animation: slideUp 0.8s ease-out 0.3s backwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        video {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .group:hover video {
            transform: scale(1.05);
            transition: transform 0.5s ease;
        }
    </style>
<?= $this->endSection() ?>