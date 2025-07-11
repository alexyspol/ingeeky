<?= $this->extend('layouts/main') ?> // Assuming you have an admin layout

<?= $this->section('title') ?>
User Management
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>User Management</h2>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success mt-3">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mt-3">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <p>
        <a href="<?= route_to('admin.user.new') ?>" class="btn btn-primary">Create New User</a>
    </p>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Groups</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user->id) ?></td>
                        <td><?= esc($user->username) ?></td>
                        <td><?= esc($user->email) ?></td>
                        <td>
                            <?php foreach ($user->getGroups() as $group): ?>
                                <span class="badge bg-secondary"><?= esc($group) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <a href="<?= route_to('admin.user.edit', $user->id) ?>" class="btn btn-sm btn-info">Edit</a>
                            <form action="<?= route_to('admin.user.delete', $user->id) ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
