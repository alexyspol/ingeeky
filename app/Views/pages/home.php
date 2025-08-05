<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="full-width">
        <div class="bg-pattern">
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-white/80 via-transparent to-white/80"></div>
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
                    <div class="text-center space-y-8 fade-in">
                    <span class="inline-block px-4 py-2 text-sm font-medium text-red-500 bg-red-50 rounded-full shadow-md hover:shadow-lg transition-all">
                        Tech Support Reimagined 🚀
                    </span>
                        <h1 class="text-5xl font-bold text-gray-900 sm:text-6xl leading-tight drop-shadow-sm">
                            Expert Tech Support<br>
                            <span class="text-red-500">When You Need It</span>
                        </h1>
                        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                            Get instant access to professional tech support for all your digital needs. No waiting, no hassle.
                        </p>
                        <div class="flex justify-center gap-4 pt-4">
                            <a href="<?= url_to('tickets.index') ?>" class="button-hover inline-flex items-center px-8 py-4 bg-red-500 text-white text-lg font-medium rounded-xl hover:bg-red-600 shadow-lg">
                                Get Started
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="/about-us" class="button-hover inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 text-lg font-medium rounded-xl hover:border-red-500 hover:text-red-500 shadow-md">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-24 relative">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/50 to-transparent"></div>
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="p-8 rounded-2xl bg-white/80 backdrop-blur-sm border border-gray-100 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-6 shadow-inner">
                                <i class="fas fa-headset text-xl text-red-500"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">24/7 Support</h3>
                            <p class="text-gray-600">Round-the-clock assistance for your tech emergencies and questions.</p>
                        </div>

                        <div class="p-8 rounded-2xl bg-white/80 backdrop-blur-sm border border-gray-100 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-6 shadow-inner">
                                <i class="fas fa-bolt text-xl text-red-500"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Quick Response</h3>
                            <p class="text-gray-600">Get answers within minutes, not hours. Our experts are always ready.</p>
                        </div>

                        <div class="p-8 rounded-2xl bg-white/80 backdrop-blur-sm border border-gray-100 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-6 shadow-inner">
                                <i class="fas fa-shield-alt text-xl text-red-500"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Secure Solutions</h3>
                            <p class="text-gray-600">Advanced security protocols to protect your data and privacy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        .slide-up {
            animation: slideUp 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .button-hover {
            transition: all 0.3s ease;
        }
        .button-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(239, 68, 68, 0.4);
        }
        .bg-pattern {
            background-image:
                    radial-gradient(circle at 1px 1px, rgba(0,0,0,0.05) 1px, transparent 0),
                    linear-gradient(to right, rgba(255,0,0,0.02), rgba(0,0,255,0.02));
            background-size: 20px 20px, 100% 100%;
        }
    </style>
<?= $this->endSection() ?>
