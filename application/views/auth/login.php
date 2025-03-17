<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/') ;?>src/output.css">
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center mb-4">Login Admin</h2>
        
        <?php if ($this->session->flashdata('error')): ?>
            <p class="text-red-500 text-sm text-center"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form action="<?= base_url('auth/login'); ?>" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Login</button>
        </form>
    </div>
</body>
</html>
