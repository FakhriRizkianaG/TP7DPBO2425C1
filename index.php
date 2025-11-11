<?php
require_once 'class/Game.php';
require_once 'class/Developer.php';
require_once 'class/User.php';

$game = new Game();
$developer = new Developer();
$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GameDB System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <nav>
            <a href="?page=games">Games</a> |
            <a href="?page=developers">Publisher</a> |
            <a href="?page=users">User</a>
        </nav>
        <hr>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'games') include 'view/games.php';
            elseif ($page == 'developers') include 'view/developers.php';
            elseif ($page == 'users') include 'view/users.php';
        } else {
            include 'view/games.php';
        }
        ?>
    </main>
    <?php include 'view/footer.php'; ?>
</body>
</html>
