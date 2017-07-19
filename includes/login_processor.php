<?php require_once('includes/connect.php'); ?>
<?php
    function login_form_validation(){
        global $con;
        if(isset($_POST['login'])){
            $errors = [];

            $username = $_POST['username'];
            $password = $_POST['password'];

            if($username == null){
                $errors[] = 'Please enter your username.';
            }

            if($password == null){
                $errors[] = 'Please enter your password.';
            }

            if(empty($errors)){
                $pass = md5('salt' . $password);
                $query = "SELECT * FROM users WHERE username = :username";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if($result['password'] == $pass){
                    header('Location: /rp_cms/home.php');
                }else{
                    $errors[] = 'You have entered the wrong username or password.';
                    return $errors;
                }
            }else{
                return $errors;
            }
        }
    }
?>