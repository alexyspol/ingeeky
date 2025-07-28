<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section with Search -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Product Management</h1>

            <div class="flex items-center gap-4">
                <!-- Search Bar -->
                <div class="relative w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text"
                           id="productSearch"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm
                              placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-200
                              focus:border-red-500 transition-colors duration-200"
                           placeholder="Search products...">
                </div>

                <a href="<?= url_to('products.new') ?>" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i>
                    Add Product
                </a>
            </div>
        </div>

        <!-- Products List -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= esc($product['name'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= esc($product['category'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    <?= esc($product['description'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    $<?= number_format($product['price'] ?? 0, 2) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs <?= ($product['status'] ?? '') === 'active'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800' ?>">
                                        <?= esc($product['status'] ?? 'inactive') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="<?= url_to('products.edit', $product['id']) ?>" class="text-slate-600 hover:text-slate-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= url_to('products.delete', $product['id']) ?>" method="post" class="inline-block">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-6xl text-gray-300 mb-4">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">No Products Available</h3>
                                <p class="text-gray-600">Start by adding your first product</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Prevent text selection and set default cursor */
        .container {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* Enable text selection and text cursor only for search input */
        #productSearch {
            user-select: text;
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            cursor: text;
        }

        /* Set default cursor for table elements */
        table, th, td {
            cursor: default;
        }

        /* Enable pointer cursor only for interactive elements */
        a, button,
        td a,
        td button,
        .fa-edit,
        .fa-trash-alt {
            cursor: pointer;
        }

        /* Prevent focus outline on table elements */
        table:focus,
        tr:focus,
        td:focus,
        th:focus {
            outline: none;
        }
    </style>

    <script>
        document.getElementById('productSearch').addEventListener('keyup', function() {
            const searchQuery = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                if (row.querySelector('td[colspan]')) {
                    row.style.display = searchQuery ? 'none' : '';
                    return;
                }

                const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const category = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const description = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (name.includes(searchQuery) ||
                    category.includes(searchQuery) ||
                    description.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
<?= $this->endSection() ?>