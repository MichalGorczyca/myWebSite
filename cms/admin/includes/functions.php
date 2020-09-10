<?php 

function escape($string){

    global $connection;

    return mysqli_real_escape_string($connection,trim($string));

}

function query($query){

    global $connection;

    $result =  mysqli_query($connection,$query);
    confirm($result);
    return $result;

}

function getUsername(){

    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

function loggedInUserId(){

    if(isLoggedIn()){

        $result = query("SELECT * FROM users WHERE username = '{$_SESSION['username']}'");
        confirm($result);
        $row = mysqli_fetch_array($result);

        return mysqli_num_rows($result) >= 1 ? $row['user_id'] : false;

    }

}


function users_online()
{
        global $connection;
        
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if ($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
        } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }

        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        return $count_user = mysqli_num_rows($users_online_query);


}





function confirm($result){

    global $connection;
    if(!$result){

        die("QUERY FAILED ".mysqli_error($connection));

    }

}


function insertCategories(){

    global $connection;

    if(isset($_POST['submit'])){

        $cat_title = escape($_POST['cat_title']);
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if($cat_title == '' || empty($cat_title)){
    
            echo "This field cannot be empty";
    
    }
    else{
        
        $stmt = mysqli_prepare($connection,"INSERT INTO categories2(cat_title,user_id) VALUE(?,?)");
        confirm($stmt);
        mysqli_stmt_bind_param($stmt,'si',$cat_title, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
    
        }
    }

}

function findAllCategories(){

    global $connection;

    $query = "SELECT * FROM categories2";
    $select_category = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_category)){

        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo    "<tr>
                    <td>{$cat_id}</td>
                    <td>{$cat_title}</td>
                    <td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>
                    <td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>
                </tr>";
    }

}

function deleteCategory(){

    global $connection;

    if(isset($_GET['delete'])){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            
            
            $get_cat_id = escape($_GET['delete']);
            $query = "DELETE FROM categories2 WHERE cat_id = {$get_cat_id}";
            $delete_category_query = mysqli_query($connection,$query);
            header('Location: categories.php');
            
            
            
            confirm($delete_category_query);
            
        }
    }

}

function recordCount($table){

    global $connection;

    $query = "SELECT * FROM ".$table;
    $select_all_records = mysqli_query($connection,$query);
    $count = mysqli_num_rows($select_all_records);

    confirm($count);

    return $count;

}

function countStatusOrRole($table,$column,$status){

    global $connection;

    $query = "SELECT * FROM {$table} WHERE {$column} = '{$status}'";
    $select_all = mysqli_query($connection,$query);
    return mysqli_num_rows($select_all);

}

function countUserPosts(){

    global $connection;

        $select_all_records = query("SELECT * FROM posts2 WHERE user_id=".loggedInUserId());
        return mysqli_num_rows($select_all_records);

}

function countUserComments(){

    global $connection;

        $select_all_records = query("SELECT * FROM comments WHERE user_id=".loggedInUserId());
        return mysqli_num_rows($select_all_records);

}

function countUserCategories(){

    global $connection;

        $select_all_records = query("SELECT * FROM categories2 WHERE user_id=".loggedInUserId());
        return mysqli_num_rows($select_all_records);

}



function countUserPublishedPosts(){

    global $connection;

    $select_all = query("SELECT * FROM posts2 WHERE post_status = 'published' AND user_id=".loggedInUserId());
    return mysqli_num_rows($select_all);

}

function countUserDraftPosts(){

    global $connection;

    $select_all = query("SELECT * FROM posts2 WHERE post_status = 'draft' AND user_id=".loggedInUserId());
    return mysqli_num_rows($select_all);

}

function countUserUnapproved(){

    global $connection;

    $select_all = query("SELECT * FROM comments WHERE comment_status = 'unapproved' AND user_id=".loggedInUserId());
    return mysqli_num_rows($select_all);

}


function fetchRecords($result){
    return mysqli_fetch_array($result);
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

function checkIfIsLoggedInAndRedirect($redirectLocation){

    if(isLoggedIn()){

        header("Location:".$redirectLocation);
        exit;

    }

}



function is_admin($username = ''){

    if(isLoggedIn()){

        global $connection;
        $result = query("SELECT user_role FROM users WHERE user_id = ".$_SESSION['user_id']);
        $row = fetchRecords($result);
        $user_role = $row['user_role'];
    
        return $user_role == 'Admin' ? true : false;
    }

}

?>