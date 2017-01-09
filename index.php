<?php
require_once 'app/start.php';

if (Session::exists('ok')) {
    echo Session::flash('ok');  
}

$user = new User();
?>

<?php if($user->loggedIn()):?>

    <p>witaj <a href=""><?php echo esc($user->data()->username);?></a></p>
    <a href="logout.php">wyloguj sie</a>

<?php else:?>

    <p> <a href="register.php">rejestracja</a>
        <br>
    <a href="login.php">zaloguj</a><p>
        
<?php endif;?>