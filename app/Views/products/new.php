<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Add New Product</h2>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('/products') ?>" method="post" class="p-6 space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" id="name" value="<?= old('name') ?>" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" id="category" value="<?= old('category') ?>" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"><?= old('description') ?></textarea>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <div class="mt-1 flex">
        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
            $
        </span>
                        <input type="number" name="price" id="price" value="<?= old('price') ?>" step="0.01" required
                               class="block w-full rounded-none rounded-r-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                    </div>
                </div>

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Assign to Customer</label>
                    <select name="user_id" id="user_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        <option value="">-- Select a Customer --</option>
                        <?php if (!empty($customers) && is_array($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= esc($customer->id) ?>" <?= (old('user_id') == $customer->id) ? 'selected' : '' ?>>
                                    <?= esc($customer->username) ?> (<?= esc($customer->email) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No customers found in 'user' group.</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="<?= site_url('products') ?>"
                       class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>

<?= $this->endSection() ?>