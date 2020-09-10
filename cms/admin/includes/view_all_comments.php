<table class = "table table-bordered table-hover">
    <thead>
        <th>Id</th>
        <th>Author</th>
        <th>Content</th>
        <th>E-mail</th>
        <th>Status</th>
        <th>In Response of</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete</th>
    </thead>
    <tbody>
        
    <?php
        $query = "SELECT * FROM comments";
        $comments_query = mysqli_query($connection,$query);
        
        confirm($comments_query);

        while($row = mysqli_fetch_assoc($comments_query)){

            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo    
                "<tr>
                    <td>{$comment_id}</td>
                    <td>{$comment_author}</td>
                    <td>{$comment_content}</td>
                    <td>{$comment_email}</td>
                    <td>{$comment_status}</td>";

                    $query = "SELECT * FROM posts2 WHERE post_id='{$comment_post_id}'";
                    $comments_post_query = mysqli_query($connection,$query);
                    
                    confirm($comments_post_query);

                    while($row = mysqli_fetch_assoc($comments_post_query)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];

                        echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                    }

            echo   "<td>{$comment_date}</td>
                    <td><a href='comments.php?approve={$comment_id}'>APPROVE</a></td>
                    <td><a href='comments.php?unapprove={$comment_id}'>UNAPPROVE</a></td>
                    <td><a href='comments.php?delete_comment={$comment_id}'>DELETE</a></td>
                </tr>";
        }
    ?>
    <?php

        if(isset($_GET['delete_comment'])){
            if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
                
                $get_comment_id = escape($_GET['delete_comment']);
                $query = "DELETE FROM comments WHERE comment_id = {$get_comment_id}";
                $delete_comment_query = mysqli_query($connection,$query);
                header('Location: comments.php');
                
                
                
                confirm($delete_comment_query);
                
            }
        }

    ?>

    <?php

    if(isset($_GET['approve'])){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){

            
            $get_comment_id = escape($_GET['approve']);
            $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$get_comment_id}";
            $approve_comment_query = mysqli_query($connection,$query);
            header('Location: comments.php');
            
            
            
            confirm($approve_comment_query);
            
        }
    }

    ?>
    <?php

    if(isset($_GET['unapprove'])){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            
            $get_comment_id = escape($_GET['unapprove']);
            $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$get_comment_id}";
            $unapprove_comment_query = mysqli_query($connection,$query);
            header('Location: comments.php');
            
            
            
            confirm($approve_comment_query);
            
        }
    }

?>

  
    </tbody>
</table>