<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Your Products</h2>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<?php if (!auth()->user()->inGroup('user')): // Only employees can add new products ?>
    <p><a href="<?= site_url('/products/new') ?>">Add New Product</a></p>
<?php endif; ?>

<?php if (! empty($products) && is_array($products)): ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= esc($product['name']) ?>

                <?php if (!auth()->user()->inGroup('user')): // If current user is an employee (admin, support, etc.) ?>
                    <?php if (isset($product['user_id']) && !empty($product['user_id'])): ?>
                        <?php
                            // Dynamic lookup for customer username for employees
                            // This assumes 'user_id' in your 'products' table links to 'users.id'
                            $userModel = auth()->getProvider();
                            $customer  = $userModel->findById($product['user_id']);
                        ?>
                        <?php if ($customer): ?>
                            <small> (Customer: <?= esc($customer->username) ?>)</small>
                        <?php else: ?>
                            <small> (Customer ID: <?= esc($product['user_id']) ?> - Not found)</small>
                        <?php endif; ?>
                    <?php else: ?>
                        <small> (Unassigned)</small>
                    <?php endif; ?>

                    <a href="<?= site_url("/products/{$product['id']}/edit") ?>">Edit</a>
                    <form action="<?= site_url("/products/{$product['id']}") ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?= $this->endSection() ?>
