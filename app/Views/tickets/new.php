<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Create New Ticket</h2>
                </div>

                <div class="p-6">
                    <form method="post" action="/tickets" class="space-y-6" id="ticketForm">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Initial Message</label>
                            <textarea
                                    name="message"
                                    id="message"
                                    rows="5"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            ></textarea>
                        </div>

                        <button
                                type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors w-full"
                        >
                            Create Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('ticketForm');
            const inputs = form.querySelectorAll('input, textarea, button');

            inputs.forEach(input => {
                input.addEventListener('blur', function(e) {
                    // Prevent losing focus when clicking outside
                    if (!form.contains(e.relatedTarget)) {
                        input.focus();
                    }
                });
            });
        });
    </script>

<?= $this->endSection() ?>