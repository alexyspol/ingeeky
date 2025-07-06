<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Add New Product</h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('/products') ?>" method="post">
    <?= csrf_field() ?>

    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" value="<?= old('name') ?>" required>
    <br><br>

    <label for="user_id">Assign to Customer:</label>
    <select name="user_id" id="user_id">
        <option value="">-- Select a Customer --</option>
        <?php if (! empty($customers) && is_array($customers)): ?>
            <?php foreach ($customers as $customer): ?>
                <option value="<?= esc($customer->id) ?>" <?= (old('user_id') == $customer->id) ? 'selected' : '' ?>>
                    <?= esc($customer->username) ?> (<?= esc($customer->email) ?>)
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="" disabled>No customers found in 'user' group.</option>
        <?php endif; ?>
    </select>
    <br><br>

    <button type="submit">Create Product</button>
</form>

<p><a href="<?= site_url('/products') ?>">Back to Product List</a></p>

<?php if (ENVIRONMENT === 'development'): ?>
    <h3>Fetched Customers (for debugging):</h3>
    <?php if (! empty($customers) && is_array($customers)): ?>
        <ul>
            <?php foreach ($customers as $customer): ?>
                <li>ID: <?= esc($customer->id) ?>, Username: <?= esc($customer->username) ?>, Email: <?= esc($customer->email) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No customers fetched or customers variable is not an array.</p>
    <?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>
