<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('assets/') ;?>src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>
<body class="h-screen">
    <!-- Header -->
    <header class="bg-green-800 flex justify-between items-center p-5 h-20 fixed w-full shadow-lg z-10">
        <h1 class="text-2xl font-extrabold text-white tracking-wide">HijauLoka</h1>
        <nav>
            <a href="<?= base_url('auth/logout'); ?>" class="text-xl font-semibold text-white px-4 py-2 rounded-lg shadow-md">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </nav>
    </header>

    <div class="flex pt-20"> 
