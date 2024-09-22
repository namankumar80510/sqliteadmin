<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'SQLite Admin') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="/styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">SQLite Admin</a>
            <button id="menu-toggle" class="md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <nav class="hidden md:block">
                <ul class="flex space-x-4">
                    <li><a href="/" class="text-white hover:underline">All Databases</a></li>
                    <li><a href="/query" class="text-white hover:underline">SQL Query</a></li>
                    <?php if (is_logged_in()) : ?>
                        <li><a href="/logout" class="text-white hover:underline">Logout</a></li>
                    <?php else : ?>
                        <li><a href="/login" class="text-white hover:underline">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <nav id="mobile-menu" class="md:hidden bg-blue-500 hidden">
        <ul class="container mx-auto py-2">
            <li><a href="/" class="block py-2 px-4 text-white hover:bg-blue-600">Home</a></li>
            <li><a href="/databases" class="block py-2 px-4 text-white hover:bg-blue-600">Databases</a></li>
            <li><a href="/tables" class="block py-2 px-4 text-white hover:bg-blue-600">Tables</a></li>
            <li><a href="/query" class="block py-2 px-4 text-white hover:bg-blue-600">SQL Query</a></li>
        </ul>
    </nav>
    <div class="container mx-auto mt-8 px-4">
        <main>
            <?= $this->insert('_includes/flash') ?>
            <?= $this->section('content') ?>
        </main>
    </div>
    <footer class="mt-8 py-4 bg-gray-200 text-center">
        <p>&copy; <?= date('Y') ?> SQLite Admin. All rights reserved.</p>
    </footer>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>

</html>