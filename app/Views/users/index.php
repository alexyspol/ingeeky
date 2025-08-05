<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">User Management</h1>
                <div class="flex items-center gap-4">
                    <input type="text"
                           id="userSearch"
                           class="w-64 py-2 px-4 border border-gray-200 rounded-lg bg-gray-50 text-sm
                          placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-200
                          focus:border-red-500 transition-colors duration-200"
                           placeholder="Search users...">
                    <a href="<?= url_to('users.new') ?>" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Add User
                    </a>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Groups</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-6xl text-gray-300 mb-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">No Users Available</h3>
                                <p class="text-gray-600">Start by adding your first user</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= esc($user->id) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= esc($user->username) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= esc($user->email) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        <?php foreach ($user->getGroups() as $group): ?>
                                            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                                                <?= $group === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                                <?= esc($group) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="<?= url_to('users.edit', $user->id) ?>" class="text-slate-600 hover:text-slate-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= url_to('users.delete', $user->id) ?>" method="post" class="inline-block">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="mt-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= session()->getFlashdata('message') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mt-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <style>
        /* Prevent cursor and selection on the entire container */
        .container {
            user-select: none;
            cursor: default;
        }

        /* Enable text selection and cursor only for search input */
        #userSearch {
            user-select: text;
            cursor: text;
        }

        /* Remove focus outline from table elements */
        table:focus,
        td:focus,
        tr:focus,
        th:focus {
            outline: none !important;
        }

        /* Disable pointer events on table cells */
        td, th {
            pointer-events: none;
        }

        /* Re-enable pointer events and cursor for interactive elements */
        td a,
        td button,
        td form,
        .container a,
        .container button {
            pointer-events: auto;
            cursor: pointer;
        }

        /* Search input focus styles */
        #userSearch:focus {
            outline: none;
            --tw-ring-color: rgba(239, 68, 68, 0.2);
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
            border-color: rgb(239, 68, 68);
        }
    </style>

    <script>
        document.getElementById('userSearch').addEventListener('keyup', function() {
            const searchQuery = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr:not([colspan])');

            tableRows.forEach(row => {
                const username = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const groups = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (username.includes(searchQuery) ||
                    email.includes(searchQuery) ||
                    groups.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

<?= $this->endSection() ?>
