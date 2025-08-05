<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Ticket</h1>
                <p class="mt-2 text-gray-600">Update ticket information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form method="post" action="<?= url_to('tickets.update', $ticket['id']) ?>">
                    <input type="hidden" name="_method" value="PATCH">
                    <?= csrf_field() ?>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    value="<?= trim(esc($ticket['title'])) ?>"
                                    required
                            >
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select
                                name="status"
                                id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                required
                            >
                                <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                                <option value="customer replied" <?= $ticket['status'] === 'customer replied' ? 'selected' : '' ?>>Customer Replied</option>
                                <option value="awaiting customer" <?= $ticket['status'] === 'awaiting customer' ? 'selected' : '' ?>>Awaiting Customer</option>
                                <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                            <select
                                name="priority"
                                id="priority"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                required
                            >
                                <option value="low" <?= set_select('priority', 'low', $ticket['priority'] === 'low') ?>>Low</option>
                                <option value="normal" <?= set_select('priority', 'normal', $ticket['priority'] === 'normal') ?>>Normal</option>
                                <option value="high" <?= set_select('priority', 'high', $ticket['priority'] === 'high') ?>>High</option>
                            </select>
                        </div>

                        <!-- Customer -->
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Assigned to Customer</label>
                            <select
                                name="customer_id"
                                id="customer_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                required
                            >
                                <?php foreach($customers as $customer): ?>
                                    <option
                                        value="<?= esc($customer->id) ?>"
                                        <?= set_select('customer_id', $customer->id, $customer->id === $ticket['customer_id']) ?>>
                                        <?= esc($customer->username) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="<?= url_to('tickets.index') ?>"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Update Ticket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>