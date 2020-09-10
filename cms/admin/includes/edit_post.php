<?php

    global $connection;

    if(isset($_GET['p_id'])){

        $get_post_id = escape($_GET['p_id']);

        $query = "SELECT * FROM posts2 WHERE post_id = {$get_post_id}";
        $edit_post_query = mysqli_query($connection,$query);
        
        confirm($edit_post_query);

        $row = mysqli_fetch_assoc($edit_post_query);

        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_content = $row['post_content'];
        $post_date = $row['post_date'];


    }

?>
<?php 

    if(isset($_POST['submit'])){

        global $connection;

        $post_user = escape($_POST['post_user']);
        $post_title= escape($_POST['title']);
        $post_category_id = escape($_POST['post_categories']);
        $post_status = escape($_POST['post_status']);
        if($post_status != 'published') $post_status = 'draft';
        $post_tags = escape($_POST['tags']);
        $post_content = escape($_POST['content']);
    
        $post_image = escape($_FILES['image']['name']);
        $post_image_temp = escape($_FILES['image']['tmp_name']);
        move_uploaded_file($post_image_temp,"../images/$post_image");

        if(empty($post_image)){

            $get_post_id = escape($_GET['p_id']);

            $query = "SELECT * FROM posts2 WHERE post_id = {$get_post_id}";
            $select_image = mysqli_query($connection,$query);
        
            confirm($edit_post_query);

            while($row = mysqli_fetch_assoc($select_image)){

                $post_image = $row['post_image'];

            }

        }
        
        $query = "UPDATE posts2 SET post_category_id = '$post_category_id', post_title = '$post_title', post_user = '$post_user',";
        $query .= " post_date = now() ,post_image = '$post_image',post_content = '$post_content', post_tags = '$post_tags',";
        $query .= " post_status = '$post_status' WHERE post_id = $get_post_id";
        $update_posts_query = mysqli_query($connection,$query);

        confirm($update_posts_query);

        echo "<p class='bg-success'>Post updated. "."<a href='../post.php?p_id=$post_id'>View Post</a>"." or "."<a href='posts.php'>Edit Other Post</a></p>";

    }

?>

<form action="" method="post" enctype = "multipart/form-data">
    <div class="form-group">
    <label for="title">Post Title</label>
        <input value="<?php if($post_title) echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="post_categories">Post Categories</label><br>
        <select name="post_categories" id="post_categories">
            <?php 
        
                $query = "SELECT * FROM categories2";
                $select_category = mysqli_query($connection,$query);

                confirm($select_category);

                while($cats= mysqli_fetch_assoc($select_category)){

                    $cat_id = $cats['cat_id'];
                    $cat_title = $cats['cat_title'];

                    if($cat_id == $post_category_id){

                        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";

                    }
                    else{

                        echo "<option value='{$cat_id}'>{$cat_title}</option>";

                    }

                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_user">Users</label><br>
        <select name="post_user" id="post_user">
            <?php 

            echo "<option value='{$post_user}'>{$post_user}</option>";
        
                $query = "SELECT * FROM users";
                $select_user = mysqli_query($connection,$query);

                confirm($select_user);

                while($users= mysqli_fetch_assoc($select_user)){

                    $user_id = $users['user_id'];
                    $username = $users['username'];

                    echo "<option value='{$username}'>{$username}</option>";
                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Post Status</label><br>
        <select name="post_status" id="post_status">
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
            <?php

            if($post_status == 'draft'){

                echo "<option value='published'>published</option>";

            }
            else{

                echo "<option value='draft'>draft</option>";

            }

            ?>
        </select>
    </div>
    <div class="form-group">
    <label for="image">Post Image</label><br>
    <img width='100' src="../images/<?php echo $post_image; ?> ">
    <input type="file" name="image">
        
    </div>
    <div class="form-group">
    <label for="tags">Post Tags</label>
        <input value="<?php if($post_tags) echo $post_tags; ?>" type="text" class="form-control" name="tags">
    </div>
    <div class="form-group">
    <label for="content">Post Content</label>
        <textarea class="form-control" name="content" id="body" cols="30" rows="10"><?php 
                if($post_content) echo $post_content; 
            ?>
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Edit Post">
    </div>
</form>