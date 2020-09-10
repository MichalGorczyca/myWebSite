<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

 <?php

    if(isset($_GET['lang'])){

        $_SESSION['lang'] = $_GET['lang'];

        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){

            echo "<script type='text/javascript'>location.reload();</script>";

        }
        
        if(isset($_SESSION['lang'])){

            include "includes/languages/".$_SESSION['lang'].".php";

        }
        else{

            include "includes/languages/en.php";

        }
    }

?>


    <!-- Navigation -->
    
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">

    <form method="get" action="" class="navbar-form navbar-right" id="language_form">
        <div class="form-group">
            <select name="lang" class="form-control" onchange="changeLanguage()">
                <option value="en" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') ? 'selected' : ''; ?>>English</option>
                <option value="pl" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'pl') ? 'selected' : ''; ?>>Polish</option>
            </select>
        </div>
    </form>
    
    <?php

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $user_firstname = escape(trim($_POST['firstname']));
            $user_lastname = escape(trim($_POST['lastname']));
            $username = escape(trim($_POST['username']));
            $user_email = escape(trim($_POST['email']));
            $user_password = escape(trim($_POST['password']));

            
            $error = [
                
                'username' => '',
                'email' => '',
                'password' => '',
                'firstname' => '',
                'lastname' => ''
                
            ];
            
            if(strlen($username) < 4){
                
                $error['username'] = 'Username needs to be longer';
                
            }
            if(strlen($username) > 12){
                
                $error['username'] = 'Username is too long';
                
            }
            if(username_exist($username)){
                
                $error['username'] = 'This username already exists';
                
            }
            if(email_exist($user_email)){
                
                $error['email'] = 'This email is already used';
                
            }
            if($username == ''){
                
                $error['username'] = 'Username cannot be empty';
            }
            if($user_password == ''){
                
                $error['password'] = 'Password cannot be empty';
            }
            if($user_email == ''){
                
                $error['email'] = 'Email cannot be empty';
            }
            if($user_firstname == ''){
                
                $error['firstname'] = 'Firstname cannot be empty';
            }
            if($user_lastname == ''){
                
                $error['lastname'] = 'Lastname cannot be empty';
            }
            
            foreach($error as $key => $value){
                
                if(empty($value)){
                    
                    unset($error[$key]);
                    // login_user($username, $password);
                    
                }
                
            }
            
            if(empty($error)){
                
                register_user($username, $user_password, $user_email, $user_firstname, $user_lastname);

                header("Location: index.php");

            }
        }
            

    ?>
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete = "on">
                    <div class="form-group">
                            <label for="username" class="sr-only"><?php echo _FIRSTNAME; ?></label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="<?php echo _FIRSTNAME; ?>" autocomplete = "on" value="<?php echo isset($user_firstname) ? $user_firstname : '' ?>">
                            <p class= "text-danger"><?php echo isset($error['firstname']) ? $error['firstname'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only"><?php echo _LASTNAME; ?></label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="<?php echo _LASTNAME; ?>" autocomplete = "on" value="<?php echo isset($user_lastname) ? $user_lastname : '' ?>">
                            <p class= "text-danger"><?php echo isset($error['lastname']) ? $error['lastname'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only"><?php echo _USERNAME; ?></label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" autocomplete = "on" value="<?php echo isset($username) ? $username : '' ?>">
                            <p class= "text-danger"><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only"><?php echo _EMAIL; ?></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>" autocomplete = "on" value="<?php echo isset($user_email) ? $user_email : '' ?>">
                            <p class= "text-danger"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only"><?php echo _PASSWORD; ?></label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                            <p class= "text-danger"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="<?php echo _SUBMIT; ?>">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>


<script>

    function changeLanguage(){

        document.getElementById('language_form').submit();

    }

</script>

<?php include "includes/footer.php";?>
