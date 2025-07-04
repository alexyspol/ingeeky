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
            <a href="/contact-us">Contact</a> |

            <?php if (auth()->loggedIn()): ?>
                <a href="<?= url_to('tickets') ?>">Tickets</a> |
                <?php if (! auth()->user()->inGroup('user')): ?>
                    <a href="<?= url_to('dashboard') ?>">Dashboard</a> |
                <?php endif; ?>
                <a href="<?= url_to('logout') ?>">Logout</a>
            <?php else: ?>
                <a href="<?= url_to('login') ?>">Login</a> |
                <a href="<?= url_to('register') ?>">Register</a>
            <?php endif; ?>
        </nav>
        <hr>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer><hr>&copy; <?= date('Y') ?> Ingeeky</footer>
</body>
</html>
