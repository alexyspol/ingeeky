<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div >
    <div >
        <h2 ><?= esc($ticket['title']) ?></h2>
        <p ><strong >Status:</strong> <span ><?= esc($ticket['status']) ?></span></p>
    </div>

    <div >
        <h3 >Conversation</h3>

        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div >
                    <div >
                        <?php
                        // Check if sender data is available and if profile exists
                        if (isset($msg['sender']) && $msg['sender'] !== null && $msg['sender']->getProfile() !== null) {
                            $profile = $msg['sender']->getProfile();
                            // Display first name and last name, or fallback to User ID if not available
                            echo esc($profile->first_name ?: 'User') . ' ' . esc($profile->last_name ?: '#' . $msg['user_id']);
                        } else {
                            echo 'User #' . esc($msg['user_id']); // Fallback if sender or profile is missing
                        }
                        ?>:
                    </div>
                    <p ><?= esc($msg['message']) ?></p>
                    <small ><em ><?= esc($msg['created_at']) ?></em></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p >No messages yet.</p>
        <?php endif; ?>
    </div>

    <div >
        <h4 >Post a Reply</h4>

        <form method="post" action="/ticket-messages">
            <?= csrf_field() ?>
            <input type="hidden" name="ticket_id" value="<?= esc($ticket['id']) ?>">

            <div >
                <label for="message" ></label>
                <textarea name="message" id="message" rows="4" required
                          placeholder="Type your message here..."></textarea>
            </div>

            <button type="submit"
                    >
                Send Reply
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
