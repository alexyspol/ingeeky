<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2><?= esc($ticket['title']) ?></h2>
<p><strong>Status:</strong> <?= esc($ticket['status']) ?></p>

<hr>

<h3>Conversation</h3>

<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $msg): ?>
        <div style="margin-bottom: 1.5em;">
            <strong>User #<?= esc($msg['user_id']) ?>:</strong>
            <p><?= esc($msg['message']) ?></p>
            <small><em><?= esc($msg['created_at']) ?></em></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No messages yet.</p>
<?php endif; ?>

<hr>

<h4>Post a Reply</h4>

<form method="post" action="/ticket-messages">
    <input type="hidden" name="ticket_id" value="<?= esc($ticket['id']) ?>">

    <textarea name="message" rows="4" required></textarea><br><br>
    <button type="submit">Send</button>
</form>

<?= $this->endSection() ?>
