<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="container mx-auto px-4 py-6">
        <!-- Header remains the same -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Product</h1>
                <a href="<?= site_url('products') ?>" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <!-- Fixed form action -->
            <form action="<?= url_to('products.update', $product['id']) ?>" method="POST" class="p-6">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name"
                               value="<?= old('name', $product['name'] ?? '') ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        <?php if (session('errors.name')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.name') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Category Field -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option value="">Select Category</option>
                            <option value="service" <?= (old('category', $product['category'] ?? '') == 'service') ? 'selected' : '' ?>>Service</option>
                            <option value="product" <?= (old('category', $product['category'] ?? '') == 'product') ? 'selected' : '' ?>>Product</option>
                        </select>
                        <?php if (session('errors.category')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.category') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"><?= old('description', $product['description'] ?? '') ?></textarea>
                        <?php if (session('errors.description')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.description') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Price Field -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="price" id="price" step="0.01"
                                   value="<?= old('price', $product['price'] ?? '0.00') ?>"
                                   class="block w-full rounded-md border-gray-300 pl-7 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <?php if (session('errors.price')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.price') ?></p>
                        <?php endif ?>
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option value="active" <?= (old('status', $product['status'] ?? '') == 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= (old('status', $product['status'] ?? '') == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                        <?php if (session('errors.status')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                        <?php endif ?>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <a href="<?= site_url('products') ?>"
                       class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>