<?php include "includes/admin_header.php"; ?>

<?php 

    if(isset($_SESSION['username'])){

        $user_id = $_SESSION['id'];
        
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $profile_data_query = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($profile_data_query)){

            
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_role = $row['user_role'];
            $user_email = $row['user_email'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname']; 

        }
        

    }
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_nav.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <?php 

                if(isset($_POST['submit'])){

                    $user_firstname = escape($_POST['firstname']);
                    $user_lastname = escape($_POST['lastname']);
                    $user_role = escape($_POST['role']);
                    $username = escape($_POST['username']);
                    $user_email = escape($_POST['email']);
                    $user_password = escape($_POST['password']);


                    // $user_firstname = mysqli_real_escape_string($connection,$user_firstname);
                    // $user_lastname = mysqli_real_escape_string($connection,$user_lastname);
                    // $username = mysqli_real_escape_string($connection,$username);
                    // $user_password = mysqli_real_escape_string($connection,$user_password);
                    
                    $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_role= '{$user_role}',";
                    $query .= " username = '{$username}',user_email = '{$user_email}', user_password = '{$user_password}' WHERE user_id = $user_id";
                    
                    $update_profile_query = mysqli_query($connection,$query);

                    confirm($update_profile_query);

                    echo "<p class='bg-success'>Profile updated </p>";

                }

            ?>

                <form action="" method="post">
                    <div class="form-group">
                    <label for="title">First Name</label>
                        <input type="text" class="form-control" name="firstname" value="<?php echo $user_firstname; ?>">
                    </div>
                    <div class="form-group">
                    <label for="author">Last Name</label>
                        <input type="text" class="form-control" name="lastname" value="<?php echo $user_lastname; ?>">
                    </div>
                    <div class="form-group">
                        <select name="role" id="role">

                            <option value='<?php echo $user_role; ?>'><?php echo $user_role; ?></option>
                        <?php

                        if($user_role == 'Admin'){

                            echo "<option value='Subscriber'>Subscriber</option>";

                        }
                        else{

                            echo "<option value='Admin'>Admin</option>";

                        }

                        ?>
                            
                            
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="status">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                    <label for="post_image">Email</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $user_email ?>">
                    </div>
                    <div class="form-group">
                    <label for="tags">Password</label>
                        <input type="password" class="form-control" name="password" value="<?php echo $user_password ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="submit" value="Edit Profile">
                    </div>
                </form>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>
