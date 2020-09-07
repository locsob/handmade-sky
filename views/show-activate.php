<h1>Input your email for account activation</h1>
<?php require ROOT_PATH . 'views/parts/_validation.php' ?>
<form action="/send-activate" method="post">
    <label>
        Email:
        <input type="text" name="email"/>
    </label>
    <br>
    <?php require ROOT_PATH . 'views/parts/_csrf.php' ?>
    <input type="submit">
</form>

<form action="/logout" method="post">
    <?php require ROOT_PATH . 'views/parts/_csrf.php' ?>
    <input type="submit" value="logout">
</form>
