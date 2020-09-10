<?php

    if(isset($_GET['p_id'])){

        $get_user_id = escape($_GET['p_id']);

        $query = "SELECT * FROM users WHERE user_id = {$get_user_id}";
        $edit_user_query = mysqli_query($connection,$query);
        
        confirm($edit_user_query);

        $row = mysqli_fetch_assoc($edit_user_query);

        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];


    }

?>
<?php 

    if(isset($_POST['submit'])){

        $user_firstname = escape($_POST['firstname']);
        $user_lastname = escape($_POST['lastname']);
        $user_role = escape($_POST['role']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['email']);
        $user_password = escape($_POST['password']);

        // $query = "SELECT randSalt FROM users";
        // $select_salt_query = mysqli_query($connection,$query);
        
        // if(!$select_salt_query){
            
        //     die("QUERY FAILED ".mysqli_error($connection));
            
        // }
        
        // $randSalt = mysqli_fetch_assoc($select_salt_query);
        
        // $hashed_password = crypt($user_password, $randSalt['randSalt']);

        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));


        $get_user_id = $_GET['p_id'];
        // $user_firstname = mysqli_real_escape_string($connection,$user_firstname);
        // $user_lastname = mysqli_real_escape_string($connection,$user_lastname);
        // $username = mysqli_real_escape_string($connection,$username);
        // $user_password = mysqli_real_escape_string($connection,$user_password);
        
        $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_role= '{$user_role}',";
        $query .= " username = '{$username}',user_email = '{$user_email}', user_password = '{$hashed_password}' WHERE user_id = $get_user_id";
         
        $update_users_query = mysqli_query($connection,$query);

        confirm($update_users_query);

        echo "<p class='bg-success'>User updated. "."<a href='users.php'>Edit Other Users</a></p>";

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
        <input type="submit" class="btn btn-primary" name="submit" value="Edit User">
    </div>
</form>