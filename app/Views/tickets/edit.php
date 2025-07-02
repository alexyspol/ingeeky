<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Ticket</h2>

<form method="post" action="/tickets/<?= esc($ticket['id']) ?>">
    <input type="hidden" name="_method" value="PUT">

    <label for="title">Title</label><br>
    <input type="text" name="title" value="<?= esc($ticket['title']) ?>" required><br><br>

    <label for="status">Status</label><br>
    <select name="status">
        <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
        <option value="pending" <?= $ticket['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<?= $this->endSection() ?>
