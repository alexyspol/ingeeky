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
                        Over InGeeky 🚀
                    </span>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                        Passie voor
                        <span class="relative">
                            <span class="bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                                Technologie
                            </span>
                            <svg class="absolute -bottom-2 left-0 w-full h-2 text-red-200" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path fill="currentColor" d="M0 5 Q 25 0, 50 5 Q 75 10, 100 5 L 100 10 L 0 10 Z"/>
                            </svg>
                        </span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 space-y-24 pb-24">
            <!-- About Section -->
            <div class="slide-up max-w-4xl mx-auto">
                <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-10 shadow-2xl border border-gray-100">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg flex items-center justify-center transform rotate-3 hover:rotate-6 transition-transform">
                                <i class="fas fa-laptop-code text-3xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Wie zijn wij?</h2>
                            <p class="text-lg text-gray-700 leading-relaxed">
                                InGeeky is een innovatief technologiebedrijf dat zich richt op het leveren van hoogwaardige digitale oplossingen.
                                Met onze passie voor technologie en creativiteit helpen we bedrijven hun digitale ambities waar te maken.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto slide-up-delay">
                <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-gray-100">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovatie</h3>
                    <p class="text-gray-600">Wij omarmen nieuwe technologieën en denken vooruit om de beste oplossingen te bieden.</p>
                </div>

                <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-gray-100">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Betrouwbaarheid</h3>
                    <p class="text-gray-600">We staan voor kwaliteit en bouwen langdurige relaties met onze klanten.</p>
                </div>

                <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-gray-100">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Klantgericht</h3>
                    <p class="text-gray-600">Uw succes staat centraal in alles wat we doen.</p>
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
    </style>
<?= $this->endSection() ?>