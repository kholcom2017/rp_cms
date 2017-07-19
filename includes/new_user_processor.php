<?php require_once('includes/connect.php'); ?>
<?php
    function new_user_form_validation(){
        global $con;
        if(isset($_POST['submit'])){
            $errors = [];

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $ver_password = $_POST['ver_password'];

            if($first_name == null){
                $errors[] = 'Please enter your first name.';
            }
            
            if($last_name == null){
                $errors[] = 'Please enter your last name.';
            }
            
            if($email == null){
                $errors[] = 'Please enter your email.';
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors[] = 'Please enter a valid email address.';
                }
            }
            
            if($username == null){
                $errors[] = 'Please enter your username.';
            }

            if($password == null || $ver_password == null){
                $errors[] = 'Please enter your password.';
            }
            
            
            if(empty($errors)){
                if($password != $ver_password){
                    $errors[] = 'Your passwords do not match.';
                }else{
                    $pass = md5('salt' . $password);
                    $query = 'INSERT INTO users
                        (first_name, last_name, email, username, password)
                        VALUES
                        (:first_name, :last_name, :email, :username, :password)';
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $pass);
                    if($stmt->execute()){
                        header('Location:index.php');
                        exit;
                    }else{
                        echo '<p>User could not be created.</p>';
                        $pdoerrors = $stmt->errorInfo();
                        foreach($pdoerrors as $e){
                            echo '<p>' . $e . '</p>';
                        }
                    }
                }
            }else{
                return $errors;
            }
        }
    }
?>