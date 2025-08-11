<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">System overview and management</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="totalUsers"><?= count($users ?? []) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Active Tickets -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                            <i class="fas fa-ticket-alt text-red-600 dark:text-red-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Tickets</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="activeTickets"><?= $activeTickets ?? 0 ?></p>
                        </div>
                    </div>
                </div>

                <!-- Online Users -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <i class="fas fa-circle text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Online Now</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="onlineUsers"><?= $onlineUsers ?? 0 ?></p>
                        </div>
                    </div>
                </div>

                <!-- Pending Tickets -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                            <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Tickets</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white" data-stat="pendingTickets"><?= $pendingTickets ?? 0 ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Activity Log</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Activity</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="userActivityTable">
                        <?php foreach ($users ?? [] as $user): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700" data-user-id="<?= $user->id ?>">

                            <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-600 dark:text-gray-400"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($user->username) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?= $user->is_admin ? 'Administrator' : 'User' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($user->is_online): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        Online
                                    </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        Offline
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?= $user->last_activity ? date('d M H:i', strtotime($user->last_activity)) : 'Never' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent System Activity</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8" id="activityFeed">
                            <?php foreach ($recentActivity ?? [] as $index => $activity): ?>
                                <li>
                                    <div class="relative pb-8">
                                        <?php if (count($recentActivity) > 1 && $index < count($recentActivity) - 1): ?>
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"></span>
                                        <?php endif; ?>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                    <i class="fas fa-history text-gray-600 dark:text-gray-400"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400" data-activity-action>
                                                        <strong><?= $activity['display_name'] ?></strong>
                                                        <?= $activity['action'] ?>
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    <?= date('d M H:i', strtotime($activity['created_at'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <style>
            [data-activity-action] a {
                color: #2563eb; /* Tailwind blue-600 */
                text-decoration: underline;
                transition: color 0.2s ease;
            }

            [data-activity-action] a:hover,
            [data-activity-action] a:focus {
                color: #1e40af; /* Tailwind blue-800 */
                outline: none;
            }
        </style>

        <script>
            function updateDashboard() {
            fetch('/admin/dashboard/stats', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update stats
                        document.querySelector('[data-stat="onlineUsers"]').textContent = data.stats.onlineUsers;
                        document.querySelector('[data-stat="activeTickets"]').textContent = data.stats.ticketStats.open;
                        document.querySelector('[data-stat="pendingTickets"]').textContent = data.stats.ticketStats.awaiting;
                        document.querySelector('[data-stat="totalUsers"]').textContent = data.stats.userStatuses.length;

                        // Update user activity table
                        const tableBody = document.getElementById('userActivityTable');
                        if (tableBody && data.stats.userStatuses) {
                            data.stats.userStatuses.forEach(user => {
                                const row = tableBody.querySelector(`tr[data-user-id="${user.id}"]`);
                                if (row) {
                                    // Update status
                                    const statusCell = row.querySelector('td:nth-child(3)');
                                    statusCell.innerHTML = user.is_online ?
                                        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Online</span>` :
                                        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">Offline</span>`;

                                    // Update last activity
                                    const activityCell = row.querySelector('td:nth-child(4)');
                                    activityCell.textContent = user.last_activity ?
                                        new Date(user.last_activity).toLocaleDateString('nl-NL', {
                                            day: '2-digit',
                                            month: 'short',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        }) : 'Never';
                                }
                            });
                        }
                    }
                })
                .catch(console.error);
        }

            // Initial update
            updateDashboard();

            // Update every 5 seconds
            setInterval(updateDashboard, 5000);
    </script>

<?= $this->endSection() ?>