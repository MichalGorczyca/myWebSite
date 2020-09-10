<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

    if(!isset($_GET['email']) || !isset($_GET['token'])){

        header("Location: index");

    }

    $token = escape(trim($_GET['token']));

    $stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE token = ?");
    confirm($stmt);
    mysqli_stmt_bind_param($stmt,'s', $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if($_GET['token'] !== $token && $_GET['email'] !== $email){

        header("Location: index");

    }

    $alert = '';

    if(isset($_POST['password']) && isset($_POST['confirmPassword'])){

        $password = escape(trim($_POST['password']));
        $confirmPassword = escape(trim($_POST['confirmPassword']));

        if($password === $confirmPassword && !empty($password) && !empty($confirmPassword)){

            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
            
            $stmt = mysqli_prepare($connection, "UPDATE users SET user_password = ? WHERE token = ?");
            confirm($stmt);
            mysqli_stmt_bind_param($stmt, 'ss', $password, $token);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $alert = "Password changed successfully. <br><a href='index'>Go to main site</a>";

        }
        else if($password !== $confirmPassword){

            $alert = "Passwords are not the same";

        }
        else{

            $alert = "Both fields have to be filled";

        }

    }

?>

<!-- Navigation -->
<?php include "includes/nav.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                            <p><?php echo $alert; ?></p>

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div><!-- Body-->                           

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

