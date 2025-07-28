<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Ticket</h1>
                <p class="mt-2 text-gray-600">Update ticket information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form method="post" action="/tickets/<?= esc($ticket['id']) ?>">
                    <input type="hidden" name="_method" value="PUT">
                    <?= csrf_field() ?>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="<?= trim(esc($ticket['title'])) ?>"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 px-3 py-2">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                    id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="Open" <?= $ticket['status'] === 'Open' ? 'selected' : '' ?>>Open</option>
                                <option value="In Progress" <?= $ticket['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Closed" <?= $ticket['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority"
                                    id="priority"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="Low" <?= ($ticket['priority'] ?? '') === 'Low' ? 'selected' : '' ?>>Low</option>
                                <option value="Normal" <?= ($ticket['priority'] ?? '') === 'Normal' ? 'selected' : '' ?>>Normal</option>
                                <option value="High" <?= ($ticket['priority'] ?? '') === 'High' ? 'selected' : '' ?>>High</option>
                                <option value="Urgent" <?= ($ticket['priority'] ?? '') === 'Urgent' ? 'selected' : '' ?>>Urgent</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 resize-none px-3 py-2"
                                    style="white-space: pre-wrap;"
                            ><?= trim(esc($ticket['description'] ?? '')) ?></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="/tickets"
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