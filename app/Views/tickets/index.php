<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Support Tickets</h1>
                    <p class="text-gray-600">Manage and track all your support requests</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                    <input type="text"
                           id="ticketSearch"
                           class="flex-1 py-2 px-4 border border-gray-200 rounded-lg bg-gray-50 text-sm
                      placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-200
                      focus:border-red-500 transition-colors"
                           placeholder="Search tickets...">
                    <a href="<?= url_to('tickets.new') ?>" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Ticket
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-md">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Tickets</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                <?= isset($tickets) ? count(array_filter($tickets, function($ticket) { return $ticket['status'] !== 'closed'; })) : 0 ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-md">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Open Tickets</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                <?= isset($tickets) ? count(array_filter($tickets, function($ticket) { return $ticket['status'] === 'open'; })) : 0 ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-md">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Resolved</h3>
                            <p class="text-2xl font-bold text-gray-900">
                                <?= isset($tickets) ? count(array_filter($tickets, function($ticket) { return $ticket['status'] === 'closed'; })) : 0 ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Table -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Tickets</h3>
                </div>

                <?php if (!empty($tickets)): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($tickets as $ticket): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= esc($ticket['title']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    #<?= esc($ticket['id']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $statusClass = match($ticket['status']) {
                                            'open' => 'bg-red-100 text-red-800',
                                            'customer replied' => 'bg-yellow-100 text-yellow-800',
                                            'awaiting customer' => 'bg-blue-100 text-blue-800',
                                            'awaiting response' => 'bg-blue-100 text-blue-800',
                                            'closed' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full capitalize <?= $statusClass ?>">
                                            <?= esc($ticket['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 capitalize">
                                        <?= esc($ticket['priority']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?= date('M j, Y', strtotime($ticket['created_at'] ?? 'now')) ?>
                                    </td>
                                    <!-- Actions column with view/edit icons - located in the last column of the tickets table -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                        <!-- View Button -->
                                        <a href="<?= url_to('tickets.show', $ticket['id']) ?>"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors"
                                           title="View Ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <?php if($ticket['status'] !== 'closed'): ?>
                                            <!-- Close Button -->
                                            <form action="<?= url_to('tickets.close', $ticket['id']) ?>" method="post" class="inline-flex" onsubmit="return confirm('Are you sure you want to close this ticket?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="PATCH">
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 transition-colors"
                                                        title="Close Ticket">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (auth()->user()->can('admin.access')) : ?>

                                            <!-- Edit Button -->
                                            <a href="<?= url_to('tickets.edit', $ticket['id']) ?>"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 transition-colors"
                                               title="Edit Ticket">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="<?= url_to('tickets.delete', $ticket['id']) ?>" method="post" class="inline-flex" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors"
                                                        title="Delete Ticket">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1H9a1 1 0 00-1 1v3m0 0h8" />
                                                    </svg>
                                                </button>
                                            </form>

                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No tickets found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first support ticket.</p>
                        <div class="mt-6">
                            <a href="<?= url_to('tickets.new') ?>" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create New Ticket
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('ticketSearch')?.addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr:not([colspan])');
            let totalVisible = 0, openCount = 0, closedCount = 0;

            tableRows.forEach(row => {
                const title = row.querySelector('td:nth-child(1) .text-gray-900')?.textContent.toLowerCase() || '';
                const ticketId = row.querySelector('td:nth-child(1) .text-gray-500')?.textContent.toLowerCase() || '';
                const status = row.querySelector('td:nth-child(2) span')?.textContent.toLowerCase() || '';
                const priority = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                const date = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';

                const matchesSearch = title.includes(searchQuery) ||
                    ticketId.includes(searchQuery) ||
                    status.includes(searchQuery) ||
                    priority.includes(searchQuery) ||
                    date.includes(searchQuery);

                row.style.display = matchesSearch ? '' : 'none';

                if (matchesSearch) {
                    totalVisible++;
                    if (status.includes('open')) openCount++;
                    if (status.includes('closed')) closedCount++;
                }
            });

            // Update the stats cards
            const statsElements = document.querySelectorAll('.text-2xl.font-bold.text-gray-900');
            if (statsElements.length >= 3) {
                statsElements[0].textContent = totalVisible;  // Total tickets
                statsElements[1].textContent = openCount;     // Open tickets
                statsElements[2].textContent = closedCount;   // Resolved tickets
            }
        });
    </script>

    <style>
        .container { user-select: none; cursor: default; }
        table:focus, td:focus, tr:focus, th:focus { outline: none !important; }
        td, th { pointer-events: none; }
        td a, td button, td form, .container a, .container button {
            pointer-events: auto;
            cursor: pointer;
        }
        #ticketSearch { user-select: text; cursor: text; }
    </style>

<?= $this->endSection() ?>