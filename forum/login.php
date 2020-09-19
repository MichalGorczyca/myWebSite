
<?php include "includes/forumHeader.php"; ?>
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/Forum.css" type="text/css">
    <link rel="stylesheet" href="css/login.css" type="text/css">
    <?php include "includes/forumNav.php"; ?>
    <?php $current_page = ""; ?>
    <?php include "includes/main.php"; ?>
        <div class="loginForm">
            <div class="title p-2 container-fluid">Login</div>
            <form action="login.php" method="post" class="form-group p-3">
            <h5 class="pb-3">To use this forum you need to be logged in.</h5>
            <?php 
                
                if(isset($_POST['submit'])){

                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    if(!$username || !$password) {

                        echo "<h6 class='pt-3 text-danger'>You need to fill all gaps</h6>";
                        

                    }
                    else{

                    $query = "SELECT * FROM users WHERE username = '{$username}'";
                        $get_users_query = mysqli_query($connection, $query);

                        if(!$get_users_query){

                            die("Query Failed ".mysqli_error($connection));

                        }

                        $row = mysqli_fetch_assoc($get_users_query);

                        if(!$row){

                            echo "<h6 class='text-danger'>Wrong username! Try again</h6>";

                        }
                        else if(password_verify($password,$row['user_password'])){

                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['password'] = $row['user_password'];
                            $_SESSION['user_firstname'] = $row['user_firstname'];
                            $_SESSION['user_lastname'] = $row['user_lastname'];
                            $_SESSION['user_email'] = $row['user_email'];
                            $_SESSION['user_role'] = $row['user_role'];
                            $_SESSION['user_date'] = $row['user_date'];

                            header("Location: index.php");

                        }
                        else echo "<h6 class='text-danger'>Wrong password! Try again</h6>";

                        

                        }
                        
                }

                
            
            ?>
                <input type="text" name="username" class="col-lg-6 mt-2 mb-2 form-control" placeholder="Enter username">
                <input type="password" name="password" class="col-lg-6 form-control" placeholder="Enter password">
                <small class="pt-2">Don't have account? <a class="login text-decoration-none text-dark font-weight-bold" href="register.php">Register now!</a></small></br>
                <button type="submit" name="submit" class="my-4 btn btn-primary">Log in</button>
            </form>
        </div>
    <?php include "includes/sidebar.php"; ?>
<?php include "includes/forumFooter.php"; ?>