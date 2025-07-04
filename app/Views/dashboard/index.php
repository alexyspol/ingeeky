<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Welcome to the Employee Dashboard!</h2>
    <p>Here you will find important information and tools for employees.</p>

    <?php /*
    <h3>Recent Tickets:</h3>
    <?php if (! empty($recentTickets)): ?>
        <ul>
            <?php foreach ($recentTickets as $ticket): ?>
                <li><a href="<?= url_to('tickets', 'show', $ticket->id) ?>">Ticket #<?= $ticket->id ?>: <?= esc($ticket->subject) ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No recent tickets to display.</p>
    <?php endif; ?>
    */ ?>

<?= $this->endSection() ?>
