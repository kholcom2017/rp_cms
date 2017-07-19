<?php require_once('includes/connect.php'); ?>
<?php require_once('includes/login_processor.php'); ?>
<?php
    $errors = [];
    $errors = login_form_validation();
    
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Font -->
        <link href="https://fonts.googleapis.com/css?family=Ranga" rel="stylesheet">
        <!-- CSS -->
        <link href='css/reset.css' rel='stylesheet'>
        <link href='css/media_queries.css' rel='stylesheet'>
    </head>
    <body>
        <div class='content'>
            <div class='row' id='logo_area'>
                <img id='logo' src='images/logo.png' alt='Rising Phoenix CMS'>
                <h1>Rising Phoenix CMS</h1>
            </div>
            <div class='row' id='form_area'>
                <div class='errors'>
                    <?php 
                        if(!empty($errors)){
                            foreach($errors as $e){
                                echo '<p>' . $e . '</p>';
                            }
                        }
                    ?>
                </div>
                <form action='index.php' method='post'>
                    <input type='input' name='username' class='text_input effect' placeholder='Username'>
                    <input type='password' name='password' class='text_input effect' placeholder='Password'>
                    <input type='submit' class='login_button' name='login' value='Login'>
                </form>
                <p><a href='forgot_password.php'>Forgot Password?</a></p>
                <p><a href='new_user.php'>Create New Account</a></p>
            </div>
        </div>
    </body>
</html>