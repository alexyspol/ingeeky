<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<!-- This needs styling -->

<?php if (session('errors')) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>





    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Create New Ticket</h2>
                </div>

                <div class="p-6">
                    <form method="post" action="<?= url_to('tickets.create') ?>" class="space-y-6" id="ticketForm">

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    value="<?= old('title') ?>"
                                    required
                            >
                        </div>

                        <?php if(!empty($customers)): ?>
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                            <select
                                name="customer_id"
                                id="customer_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                required
                            >
                                <option value="">-- Select Customer --</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer->id ?>" <?= set_select('customer_id', $customer->id) ?>>
                                        <?= esc($customer->username ?? $customer->email) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select
                                name="department"
                                id="department"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                required
                            >
                                <option value="">-- Select Department --</option>
                                <?php foreach ($departments as $groupName => $departmentName): ?>
                                    <option value="<?= esc($groupName) ?>" <?= set_select('department', $groupName) ?>>
                                        <?= esc($departmentName) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                            <select
                                name="priority"
                                id="priority"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="low" <?= set_select('priority', 'low') ?>>Low</option>
                                <option value="normal" <?= set_select('priority', 'normal', true) ?>>Normal</option>
                                <option value="high" <?= set_select('priority', 'high') ?>>High</option>
                            </select>
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
