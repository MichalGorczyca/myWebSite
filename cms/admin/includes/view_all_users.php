<table class = "table table-bordered table-hover">
    <thead>
        <th>Id</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>E-mail</th>
        <th>Role</th>
        <th>Edit</th>
        <th>Delete</th>
    </thead>
    <tbody>
        
    <?php
        $query = "SELECT * FROM users";
        $users_query = mysqli_query($connection,$query);
        
        confirm($users_query);

        while($row = mysqli_fetch_assoc($users_query)){

            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            
            

            echo    
                "<tr>
                    <td>{$user_id}</td>
                    <td>{$username}</td>
                    <td>{$user_firstname}</td>
                    <td>{$user_lastname}</td>
                    <td>{$user_email}</td>
                    <td>{$user_role}</td>
                    <td><a class='btn btn-info' href='users.php?source=edit_user&p_id={$user_id}'>EDIT</a></td>";?>

            <form action="" method="post">
            
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <?php echo "<td><input type='submit' name='delete' class='btn btn-danger' value='DELETE'></td>"; ?>
            </form>

    <?php        
        }
    ?>
    <?php

        if(isset($_POST['delete'])){
            if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){

                $get_user_id = escape($_POST['user_id']);
                $query = "DELETE FROM users WHERE user_id = {$get_user_id}";
                $delete_user_query = mysqli_query($connection,$query);
                header('Location: users.php');
                
                
                
                confirm($delete_user_query);
            }

        }

    ?>

  
    </tbody>
</table>