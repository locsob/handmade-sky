<h1>Change Credentials</h1>
<?php require ROOT_PATH . 'views/parts/_validation.php' ?>
<p><a href="/home">Home</a></p>
<form method="post">
    <label>
        New name:
        <input type="text" name="name">
    </label>
    <br>
    <label>
        New password:
        <input type="password" name="password">
    </label>
    <br>
    <?php require ROOT_PATH . 'views/parts/_csrf.php' ?>
    <input type="submit" value="submit">
</form>
