<?php require_once('includes/connect.php'); ?>
<?php
    function email_validation(){
        global $con;
        if(isset($_POST['submit'])){
            $errors = [];

            $email = $_POST['email'];

            if($email == null){
                $errors[] = 'Please enter your email.';
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors[] = 'Please enter a valid email address.';
                }
            }
            
            if(empty($errors)){
                $query = 'SELECT * FROM users WHERE email = :email';
                $stmt = $con->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(count($result) === 7){
                    $location = 'Location:new_password.php?u=' . $result['id'];
                    header($location);
                }else{
                    $errors[] = 'This is not a registered email address.';
                    return $errors;
                }
            }else{
                return $errors;
            }
        }
    }

    function new_password_validation(){
        global $con;
        $u_id = $_GET['u'];
        if(isset($_POST['submit'])){    
        $errors = [];
        
        $password = $_POST['password'];
        $ver_password = $_POST['ver_password'];

        if($password == null || $ver_password == null){
            $errors[] = 'Please enter your password.';
        }

        if(empty($errors)){
            if($password != $ver_password){
                $errors[] = 'Your passwords do not match.';
                return $errors;
            }else{
                $pass = md5('salt' . $password);
                $query = 'UPDATE users
                    SET password = :password
                    WHERE id = :id';
                $stmt = $con->prepare($query);
                $stmt->bindParam(':password', $pass);
                $stmt->bindParam(':id', $u_id);
                if($stmt->execute()){
                    header('Location:index.php');
                    exit;
                }else{
                    $errors[] = 'It did not update. Please try again or contact the administrator.';
                    return $errors;
                }
            }
        }else{
            return $errors;
        }
    }
    }
?>