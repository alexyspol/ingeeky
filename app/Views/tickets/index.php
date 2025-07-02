<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>All Tickets</h2>

<a href="/tickets/new">+ New Ticket</a>

<ul>
    <?php if (!empty($tickets)): ?>
        <?php foreach ($tickets as $ticket): ?>
            <li>
                <a href="/tickets/<?= esc($ticket['id']) ?>">
                    <?= esc($ticket['title']) ?> (<?= esc($ticket['status']) ?>)
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No tickets found.</li>
    <?php endif; ?>
</ul>

<?= $this->endSection() ?>
