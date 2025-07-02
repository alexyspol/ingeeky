<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Create New Ticket</h2>

<form method="post" action="/tickets">
    <label for="title">Title</label><br>
    <input type="text" name="title" required><br><br>

    <label for="status">Status</label><br>
    <select name="status">
        <option value="open">Open</option>
        <option value="pending">Pending</option>
        <option value="closed">Closed</option>
    </select><br><br>

    <label for="message">Initial Message</label><br>
    <textarea name="message" rows="5" required></textarea><br><br>

    <button type="submit">Create Ticket</button>
</form>

<?= $this->endSection() ?>
