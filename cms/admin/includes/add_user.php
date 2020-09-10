<?php 
    global $connection;
    if(isset($_POST['submit'])){

        $user_firstname = escape($_POST['firstname']);
        $user_lastname = escape($_POST['lastname']);
        $user_role = escape($_POST['role']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['email']);
        $user_password = escape($_POST['password']);

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        
        $query = "INSERT INTO users(user_firstname,user_lastname,user_role,username,user_email,user_password) ";
        $query .= "VALUES('$user_firstname','$user_lastname','$user_role','$username','$user_email','$user_password')";
        $add_users_query = mysqli_query($connection,$query);

        confirm($add_users_query);

        echo "<p class='bg-success'>User Created : <a href='users.php'>View Users</a></p>"; 

    }

?>


<form action="" method="post" enctype = "multipart/form-data">
    <div class="form-group">
    <label for="title">First Name</label>
        <input type="text" class="form-control" name="firstname">
    </div>
    <div class="form-group">
    <label for="author">Last Name</label>
        <input type="text" class="form-control" name="lastname">
    </div>
    <div class="form-group">
        <select name="role" id="role">
            <option value='Admin'>Admin</option>
            <option value='Subscriber'>Subscriber</option>
        </select>
    </div>
    <div class="form-group">
    <label for="status">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
    <label for="post_image">Email</label>
        <input type="text" class="form-control" name="email">
    </div>
    <div class="form-group">
    <label for="tags">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Create User">
    </div>
</form>