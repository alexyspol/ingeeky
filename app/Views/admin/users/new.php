<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Create New User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Create New User</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= route_to('admin.user.create') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
        </div>

        <div class="mb-3">
            <label for="group" class="form-label">Assign Group</label>
            <select class="form-select" id="group" name="group" required>
                <option value="">Select a Group</option>
                <?php foreach ($allGroups as $group): ?>
                    <option value="<?= esc($group) ?>"
                        <?= old('group', $defaultGroup) === $group ? 'selected' : '' ?>>
                        <?= esc($group) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create User</button>
        <a href="<?= route_to('admin.users.index') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>
