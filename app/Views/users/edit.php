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
                <a href="<?= url_to('users.index') ?>" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <form action="<?= url_to('users.update', $user->id) ?>" method="POST" class="p-6">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PATCH">

                <div class="space-y-6">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input
                                type="text"
                                name="username"
                                id="username"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                value="<?= old('username', $user->username) ?>"
                                required
                        >
                        <?php if (session('errors.username')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.username') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                                type="email"
                                name="email"
                                id="email"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                value="<?= old('email', $user->email) ?>"
                                required
                        >
                        <?php if (session('errors.email')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        >
                        <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
                        <?php if (session('errors.password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input
                                type="password"
                                name="password_confirm"
                                id="password_confirm"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        >
                        <?php if (session('errors.password_confirm')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password_confirm') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Group Field -->
                    <div>
                        <label for="group" class="block text-sm font-medium text-gray-700 mb-1">Assigned to Customer</label>
                        <select
                            name="group"
                            id="group"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            required
                        >
                            <?php foreach($allGroups as $group): ?>
                                <option
                                    value="<?= esc($group) ?>"
                                    <?= set_select('group', $group, $user->inGroup($group)) ?>>
                                    <?= esc($group) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.group')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.group') ?></p>
                        <?php endif ?>
                    </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <a href="<?= url_to('users.index') ?>"
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
<?= $this->endSection() ?>