<!DOCTYPE html>
<html>
<head>
    <title><?= esc($title ?? 'Page') ?></title>
</head>
<body>
    <header>
        <h1>Ingeeky</h1>
        <nav>
            <a href="/">Home</a> |
            <a href="/about-us">About</a> |
            <a href="/services">Services</a> |
            <a href="/contact-us">Contact</a>
        </nav>
        <hr>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer><hr>&copy; <?= date('Y') ?> Ingeeky</footer>
</body>
</html>
