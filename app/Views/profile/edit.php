<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .form-input {
            @apply shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
        }
        .form-label {
            @apply block text-gray-700 text-sm font-bold mb-2;
        }
        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out;
        }
        .alert {
            @apply p-4 mb-4 text-sm rounded-lg;
        }
        .alert-success {
            @apply bg-green-100 text-green-800;
        }
        .alert-error {
            @apply bg-red-100 text-red-800;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Edit Your Profile</h2>

        <!-- Success Message -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-error" role="alert">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= url_to('profile.update') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-input"
                       value="<?= old('first_name', $profile->first_name ?? '') ?>"
                       placeholder="Enter your first name">
            </div>

            <div class="mb-4">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-input"
                       value="<?= old('last_name', $profile->last_name ?? '') ?>"
                       placeholder="Enter your last name">
            </div>

            <div class="mb-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-input"
                       value="<?= old('phone', $profile->phone ?? '') ?>"
                       placeholder="e.g., +1234567890">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="btn-primary w-full">Update Profile</button>
            </div>
        </form>
    </div>
</body>
</html>
