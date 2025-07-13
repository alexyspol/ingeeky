<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit User: <?= esc($user->username) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Edit User: <?= esc($user->username) ?></h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= route_to('admin.user.update', $user->id) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user->username) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user->email) ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm">
        </div>

       <div class="mb-3">
            <label for="group" class="form-label">Assign Group</label>
            <select class="form-select" id="group" name="group" required>
                <option value="">Select a Group</option>
                <?php foreach ($allGroups as $group): ?>
                    <option value="<?= esc($group) ?>"
                        <?= old('group', (isset($userGroups[0]) ? $userGroups[0] : '')) === $group ? 'selected' : '' ?>>
                        <?= esc($group) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="form-text">Select the primary group for this user.</div>
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
        <a href="<?= route_to('admin.users.index') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>
