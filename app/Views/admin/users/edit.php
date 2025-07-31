<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <style>
        /* Prevent cursor and selection on the entire page */
        body {
            user-select: none;
            cursor: default;
        }

        /* Enable text input only on form elements */
        input, select, textarea {
            user-select: text;
            cursor: text !important;
        }

        /* Set pointer cursor for interactive elements */
        button, a, .password-toggle {
            cursor: pointer !important;
        }
    </style>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Edit User</h1>
                <a href="<?= route_to('admin.users.index') ?>" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <form action="<?= route_to('admin.user.update', $user->id) ?>" method="POST" class="p-6">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="space-y-6">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" id="username"
                               value="<?= old('username', $user->username) ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                               required>
                        <?php if (session('errors.username')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.username') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                               value="<?= old('email', $user->email) ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                               required>
                        <?php if (session('errors.email')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 pr-12">
                            <button type="button" id="passwordToggle" style="display: none;"
                                    class="password-toggle absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 p-1"
                                    onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
                        <?php if (session('errors.password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirm" id="password_confirm"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 pr-12">
                            <button type="button" id="passwordConfirmToggle" style="display: none;"
                                    class="password-toggle absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 p-1"
                                    onclick="togglePassword('password_confirm')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if (session('errors.password_confirm')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password_confirm') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Group Field -->
                    <div>
                        <label for="group" class="block text-sm font-medium text-gray-700">Group</label>
                        <select name="group" id="group"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                required>
                            <option value="">Select a Group</option>
                            <?php foreach ($allGroups ?? [] as $group): ?>
                                <option value="<?= esc($group) ?>"
                                    <?= old('group', (isset($userGroups[0]) ? $userGroups[0] : '')) === $group ? 'selected' : '' ?>>
                                    <?= esc($group) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Select the primary group for this user.</p>
                        <?php if (session('errors.group')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.group') ?></p>
                        <?php endif ?>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <a href="<?= route_to('admin.users.index') ?>"
                       class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Show/hide password toggles based on input
        document.getElementById('password').addEventListener('input', function() {
            const toggle = document.getElementById('passwordToggle');
            toggle.style.display = this.value ? 'block' : 'none';
        });

        document.getElementById('password_confirm').addEventListener('input', function() {
            const toggle = document.getElementById('passwordConfirmToggle');
            toggle.style.display = this.value ? 'block' : 'none';
        });
    </script>
<?= $this->endSection() ?>