<h1>Hello world</h1>
<p>Your name: <?= htmlspecialchars($name) ?></p>
<p><a href="/change_credentials">Change Credentials</a></p>
<p>
<?php require ROOT_PATH . 'views/parts/_logout.php' ?>

