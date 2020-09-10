<?php 
    global $connection;
    if(isset($_POST['submit'])){

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $post_user = escape($_POST['post_user']);
        $post_title= escape($_POST['title']);
        $post_category_id = escape($_POST['post_categories']);
        $post_status = escape($_POST['status']);
        $post_tags = escape($_POST['tags']);
        $post_content = escape($_POST['content']);
        $post_date = date('y-m-d');
        $post_image = escape($_FILES['image']['name']);
        $post_image_temp = escape($_FILES['image']['tmp_name']);

        move_uploaded_file($post_image_temp,"../images/$post_image");
        
        $query = "INSERT INTO posts2(post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status,user_id) ";
        $query .= "VALUES('$post_category_id','$post_title','$post_user','$post_date','$post_image','$post_content','$post_tags','$post_status',$user_id)";
        $add_posts_query = mysqli_query($connection,$query);
        confirm($add_posts_query);

        $post_id = mysqli_insert_id($connection);

        echo "<p class='bg-success'>Post Created : <a href='../post.php?p_id={$post_id}'>View Post</a>"." or "."<a href='posts.php'>Edit More Posts</a></p>"; 

    }

?>


<form action="" method="post" enctype = "multipart/form-data">
    <div class="form-group">
    <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
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

                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_user">Users</label><br>
        <select name="post_user" id="post_user">
            <?php 
        
                $query = "SELECT * FROM users";
                $select_user = mysqli_query($connection,$query);

                confirm($select_user);

                while($users= mysqli_fetch_assoc($select_user)){

                    $username = $users['username'];

                    echo "<option value='{$username}'>{$username}</option>";
                }

            ?>
        </select>
    </div>
    <div class="form-group">
    <label for="status">Post Status</label><br>
    <select name="status" id="">
        <option value="published">published</option>
        <option value="draft">draft</option>
    </select>
    </div>
    <div class="form-group">
    <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
    <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags">
    </div>
    <div class="form-group">
    <label for="content">Post Content</label>
        <textarea type="text" class="form-control" name="content" id="body" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Publish Post">
    </div>
</form>