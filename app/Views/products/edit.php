<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Product</h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url("/products/{$product['id']}") ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" value="<?= esc($product['name']) ?>" required>
    <br><br>

    <button type="submit">Update</button>
</form>

<p><a href="<?= site_url('/products') ?>">Back to list</a></p>

<?= $this->endSection() ?>
