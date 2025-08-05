<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Create New User<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Create New User</h2>
                <p class="text-gray-500 mt-2">Fill in the details below to create a new user account</p>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <ul class="list-disc pl-4 text-sm text-red-700">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= url_to('users.create') ?>" method="post">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" value="<?= old('username') ?>"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-150 ease-in-out"
                               placeholder="Enter username" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= old('email') ?>"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-150 ease-in-out"
                               placeholder="user@example.com" required>
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-150 ease-in-out"
                               placeholder="••••••••" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" id="password_confirm" name="password_confirm"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-150 ease-in-out"
                               placeholder="••••••••" required>
                    </div>

                    <!-- Group Selection -->
                    <div>
                        <label for="group" class="block text-sm font-medium text-gray-700 mb-1">Assign Group</label>
                        <select id="group" name="group"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 transition duration-150 ease-in-out"
                                required>
                            <option value="">Select a Group</option>
                            <?php foreach ($allGroups as $group): ?>
                                <option value="<?= esc($group) ?>" <?= old('group', $defaultGroup) === $group ? 'selected' : '' ?>>
                                    <?= esc($group) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="mt-8 flex flex-col md:flex-row gap-3">
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg
                               transition duration-150 ease-in-out shadow-sm hover:shadow-md focus:outline-none
                               focus:ring-2 focus:ring-red-400 focus:ring-offset-2 md:flex-1">
                        Create User
                    </button>
                    <a href="<?= url_to('users.index') ?>"
                       class="inline-flex justify-center items-center py-3 px-6 border border-gray-300 shadow-sm text-base
                          font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none
                          focus:ring-2 focus:ring-offset-2 focus:ring-red-400 md:flex-1">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>
