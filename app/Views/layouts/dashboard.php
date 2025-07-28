<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>New Ticket
            </button>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-medium">Open Tickets</p>
                    <i class="fas fa-ticket-alt text-2xl opacity-80"></i>
                </div>
                <p class="text-3xl font-bold mt-2">24</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-medium">Resolved</p>
                    <i class="fas fa-check-circle text-2xl opacity-80"></i>
                </div>
                <p class="text-3xl font-bold mt-2">156</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-medium">Response Time</p>
                    <i class="fas fa-clock text-2xl opacity-80"></i>
                </div>
                <p class="text-3xl font-bold mt-2">2.4h</p>
            </div>
        </div>

        <!-- Recent Tickets Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Recent Tickets</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Example row -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#1234</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Server Down Issue</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-20</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>