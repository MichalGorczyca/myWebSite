<?php

function confirm($result){

    global $connection;
    if(!$result){

        die("QUERY FAILED ".mysqli_error($connection));

    }

}

function escape($string){

global $connection;

return mysqli_real_escape_string($connection,trim($string));

}

function username_exist($username){

    global $connection;
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    confirm($result);

    if(mysqli_num_rows($result) > 0){

        return true;

    }
    else{

        return false;

    }

}

function email_exist($user_email){

    global $connection;
    $query = "SELECT * FROM users WHERE user_email = '$user_email'";
    $result = mysqli_query($connection, $query);

    confirm($result);

    if(mysqli_num_rows($result) > 0){

        return true;

    }
    else{

        return false;

    }

}

function register_user($username, $user_password, $user_email, $user_firstname, $user_lastname){

    global $connection;

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
    
    
    $query = "INSERT INTO users(user_firstname,user_lastname,username,user_password,user_email) VALUES ('{$user_firstname}', '{$user_lastname}', '{$username}', '{$user_password}', '{$user_email}')";
    
    $register_user_query = mysqli_query($connection, $query);
    
    confirm($register_user_query);
    

}

function login_user($username, $password){

    global $connection;

    $username = escape(trim($_POST['username']));
    $password = escape(trim($_POST['password']));

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection,$query);

    if(!$select_user_query){

        die("QUERY FAILED ".mysqli_error($connection));

    }

    while($row = mysqli_fetch_assoc($select_user_query)){

        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_user_email = $row['user_email'];
        
        if(password_verify($password, $db_user_password)){
    
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['password'] = $db_user_password;
            $_SESSION['role'] = $db_user_role;
            $_SESSION['email'] = $db_user_email;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
    
            header("Location: /myWebSite/cms/admin");
    
        }
        else{
    
            return false;
    
        }
    }


}

function is_admin($username = ''){

    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    confirm($result);

    $row = mysqli_fetch_array($result);

    $user_role = $row['user_role'];

    if($user_role == 'Admin'){

        return true;

    }
    else{

        return false;

    }
}

function query($query){

    global $connection;

    $result =  mysqli_query($connection,$query);
    confirm($result);
    return $result;

}

function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

        return true;

    }

    return false;

}

function isLoggedIn(){

    if(isset($_SESSION['role'])){

        return true;

    }

    return false;

}

function loggedInUserId(){

    if(isLoggedIn()){

        $result = query("SELECT * FROM users WHERE username = '{$_SESSION['username']}'");
        confirm($result);
        $row = mysqli_fetch_array($result);

        return mysqli_num_rows($result) >= 1 ? $row['user_id'] : false;

    }

}

function userLikedThisPost($post_id = ''){

    $result = query("SELECT * FROM likes WHERE user_id = ".loggedInUserId()." AND post_id = $post_id");
    confirm($result);

    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostLikes($post_id = ''){

    $result = query("SELECT * FROM likes WHERE post_id = $post_id");
    confirm($result);

    return mysqli_num_rows($result);

}

function checkIfIsLoggedInAndRedirect($redirectLocation){

    if(isLoggedIn()){

        header("Location:".$redirectLocation);
        exit;

    }

}

function imagePlaceholder($image = ''){

    if(!$image){

        return 'red_panda.jpg';

    }
    else{

        return $image;

    }
}

?>