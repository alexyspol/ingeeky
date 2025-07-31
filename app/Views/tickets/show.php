<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-800"><?= esc($ticket['title']) ?></h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $ticket['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= esc($ticket['status']) ?>
            </span>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Conversation</h3>

                <?php if (!empty($messages)): ?>
                    <div class="space-y-4">
                        <?php foreach ($messages as $msg): ?>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <div class="font-medium text-gray-700">
                                        User #<?= esc($msg['user_id']) ?>
                                    </div>
                                    <span class="text-gray-400 text-sm ml-4">
                                    <?= esc($msg['created_at']) ?>
                                </span>
                                </div>
                                <p class="text-gray-600"><?= esc($msg['message']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 italic">No messages yet.</p>
                <?php endif; ?>
            </div>

            <div>
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Post a Reply</h4>

                <form method="post" action="/ticket-messages" class="space-y-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ticket_id" value="<?= esc($ticket['id']) ?>">

                    <div>
                    <textarea
                            name="message"
                            id="message"
                            rows="4"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Type your message here..."
                    ></textarea>
                    </div>

                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        Send Reply
                    </button>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>