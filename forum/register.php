
<?php include "includes/forumHeader.php"; ?>
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/Forum.css" type="text/css">
    <link rel="stylesheet" href="css/login.css" type="text/css">
    <?php include "includes/forumNav.php"; ?>
    <?php $current_page = ""; ?>
    <?php include "includes/main.php"; ?>
        <div class="loginForm">
            <div class="title p-2 container-fluid">Register</div>
            <form action="register.php" method="post" class="form-group p-3">
            <h5 class="pb-3">On this page you can create your acount</h5>
            
            <?php 

                $message = '';
                $email_message = '';
                $pass_message = '';
                $flag = true;
                
                if(isset($_POST['submit'])){

                    $username = mysqli_real_escape_string($connection, $_POST['username']);
                    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
                    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                    $password = mysqli_real_escape_string($connection, $_POST['password']);
                    $date = date('Y-m-d');

                    if(!$username || !$firstname || !$lastname || !$email || !$password){
 
                        $message = "<h6 class='text-danger'>You need to fill all gaps</h6>";
                        $flag = false; 

                    }
                    else{

                        $query = "SELECT * FROM users WHERE username = '$username'";
                        $check_if_username_exist = mysqli_query($connection, $query);
                        if(!$check_if_username_exist) die("Query Failed ".mysqli_error($connection));

                        if(mysqli_fetch_assoc($check_if_username_exist)) {
                            $message = "<h6 class='text-danger'>This username already exists</h6>";
                            $flag = false; 
                        }

                        else if(strlen($username) < 3) {
                            $message = "<h6 class='text-danger'>Your username has to be longer than 3</h6>";
                            $flag = false; 
                        }

                        else if(strlen($username) > 12) {
                            $message = "<h6 class='text-danger'>Your username has to be shorter than 12</h6>";
                            $flag = false; 
                        }

                        $query = "SELECT * FROM users WHERE user_email = '$email'";
                        $email_exist = mysqli_query($connection, $query);
                        if(!$email_exist) die("Query Failed ".mysqli_error($connection));

                        if(mysqli_fetch_assoc($email_exist)) {
                            $email_message = "<h6 class='text-danger'>User with this email already exists</h6>";
                            $flag = false; 
                        }

                        if(strlen($password) < 6) {
                            $pass_message = $message = "<h6 class='text-danger'>Your password has to be longer than 6</h6>";
                            $flag = false; 
                        }

                        if($flag){

                            $message = "<h6 class='text-success'>You've been successfuly registered <a class='login pl-3 text-decoration-none text-dark font-weight-bold' href='login.php'>Log in</a></h6>";

                            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                            $query = "INSERT INTO users(username,user_password,user_firstname,user_lastname,user_email,user_date) VALUES('$username','$password','$firstname','$lastname','$email','$date')";

                            $insert_new_user = mysqli_query($connection, $query);
                            if(!$insert_new_user) die("Quary Failed ".mysqli_error($connection));

                        }

                    }
                }

                
            
            ?>
                <?php echo $message; ?>
                <input type="text" name="username" class="col-lg-6 mt-2 mb-2 form-control" placeholder="Enter username">
                <input type="text" name="firstname" class="col-lg-6 mt-2 mb-2 form-control" placeholder="Enter First Name">
                <input type="text" name="lastname" class="col-lg-6 mt-2 mb-2 form-control" placeholder="Enter Last Name">
                <?php echo $email_message; ?>
                <input type="email" name="email" class="col-lg-6 mt-2 mb-2 form-control" placeholder="example@gmail.com">
                <?php echo $pass_message; ?>
                <input type="password" name="password" class="col-lg-6 form-control" placeholder="Enter password">
                <button type="submit" name="submit" class="my-4 btn btn-primary">Register</button>
            </form>
        </div>
    <?php include "includes/sidebar.php"; ?>
<?php include "includes/forumFooter.php"; ?>