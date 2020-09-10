<?php

    include "delete_modal.php";

    if(isset($_POST['checkBoxArray'])){

        foreach($_POST['checkBoxArray'] as $checkBoxValue){

            $bulkOptions = escape($_POST['bulk_options']);

            switch($bulkOptions){

                case 'published':

                    $query = "UPDATE posts2 SET post_status = 'published' WHERE post_id = $checkBoxValue";
                    $publish_post_query = mysqli_query($connection,$query);

                    confirm($publish_post_query);

                break;

                case 'draft':

                    $query = "UPDATE posts2 SET post_status = 'draft' WHERE post_id = $checkBoxValue";
                    $draft_post_query = mysqli_query($connection,$query);

                    confirm($draft_post_query);

                break;

                case 'delete':

                    $query = "DELETE FROM posts2 WHERE post_id = '{$checkBoxValue}'";
                    $delete_post_query = mysqli_query($connection,$query);

                    confirm($delete_post_query);

                break;

                case 'reset':

                    $query = "UPDATE posts2 SET post_views_count = 0 WHERE post_id = '{$checkBoxValue}'";
                    $reset_views_query = mysqli_query($connection,$query);

                    confirm($reset_views_query);

                break;

                case 'clone':

                    $query = "SELECT * FROM posts2 WHERE post_id = '{$checkBoxValue}'";
                    $select_post_query = mysqli_query($connection,$query);

                    confirm($select_post_query);

                    while($row = mysqli_fetch_assoc($select_post_query)){

                        $post_author = $row['post_user'];
                        $post_title= $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];

                        if(empty($post_tags)){

                            $post_tags = "No tags";

                        }

                    }

                    $query = "INSERT INTO posts2(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_status) ";
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}','{$post_date}','{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
                    $clone_post_query = mysqli_query($connection,$query);

                    confirm($clone_post_query);

                break;

            }

        }

    }

?>


<form action="" method="post">

    <table class = "table table-bordered table-hover">

        <div style="padding: 20px 0px; " id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options">
                <option value="">Select options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
                <option value="reset">Reset views</option>
            </select>
        </div>

        <div style="padding: 20px 0px; class="col-xs-4">
            <input type="submit" value="Apply" name="submit" class="btn btn-success">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add Post</a> 
        </div>
        

        <thead>
            <th><input type='checkbox' id='SelectAllBoxes' ></th>
            <th>Id</th>
            <th>User</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Views</th>
            <th>View Post</th>
            <th>Edit</>
            <th>Delete</th>
        </thead>
        <tbody>
            
        <?php
            $query = "SELECT posts2.post_id, posts2.post_category_id, posts2.post_title, posts2.post_author, posts2.post_user, ";
            $query .= "posts2.post_date, posts2.post_image, posts2.post_content, posts2.post_comment_count, posts2.post_tags, ";
            $query .= "posts2.post_status, posts2.post_views_count, categories2.cat_id, categories2.cat_title ";
            $query .= "FROM posts2 LEFT JOIN categories2 ON posts2.post_category_id = categories2.cat_id ORDER BY posts2.post_id DESC";
            $posts_query = mysqli_query($connection,$query);
            
            confirm($posts_query);
            
            while($row = mysqli_fetch_assoc($posts_query)){
                
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_user = $row['post_user'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comments = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views = $row['post_views_count'];
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                echo "<tr>";

                ?>

                    <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>  

                <?php

                echo    "<td>{$post_id}</td>";

                    if(isset($post_author) && !empty($post_author)){

                        echo "<td>{$post_author}</td>";

                    }
                    else if(isset($post_user) && !empty($post_user)){

                        echo "<td>{$post_user}</td>";

                    }

                echo   "<td>{$post_title}</td>";
                
                // $query = "SELECT * FROM categories2 WHERE cat_id = $post_category_id";
                // $select_category_id = mysqli_query($connection,$query);
                
                //     while($row = mysqli_fetch_assoc($select_category_id)){
                        
                        
                        
                        echo "<td>{$cat_title}</td>";
                        
                    // }
                    
                    
                    
                echo   "<td>{$post_status}</td>
                    <td><img width='100' src='../images/$post_image' alt='image'</td>
                    <td>{$post_tags}</td>";

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $comment_count_query = mysqli_query($connection, $query);
                    $comment_count = mysqli_num_rows($comment_count_query);

                echo    "<td><a href='post_comments.php?id={$post_id}'>{$comment_count}</a></td>
                    <td>{$post_date}</td>
                    <td>{$post_views}</td>
                    <td><a href='../post.php?p_id=$post_id'>VIEW POST</a></td>
                    <td><a href='posts.php?source=edit_post&p_id={$post_id}'>EDIT</a></td>
                    <td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>DELETE</a></td>";
                    // <td><a onClick=\" javascript: return confirm('Are you sure you want to delete this?'); \" href='posts.php?delete_post=$post_id'>DELETE</a></td>
                echo "</tr>";
            }
            ?>
     <?php

    global $connection;

    if(isset($_GET['delete_post'])){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            
            $get_post_id = escape($_GET['delete_post']);
            $query = "DELETE FROM posts2 WHERE post_id = {$get_post_id}";
            $delete_post_query = mysqli_query($connection,$query);
            confirm($delete_post_query);
            
            
            header('Location: posts.php');
            
        }
    }

    ?>

    
        </tbody>
    </table>
</form>

<script>

    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");

            var delete_url = "posts.php?delete_post="+id;

            $(".modal_delete_link").attr("href",delete_url);

            $("#myModal").modal('show');

        })

    });

</script>