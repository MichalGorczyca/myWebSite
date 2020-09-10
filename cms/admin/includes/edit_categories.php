<form action="" method="post">
    <div class="form-group">
    <label for="cat-title">Edit Category</label>
    <?php

        if(isset($_GET['edit'])){

            $cat_id = escape($_GET['edit']);
            $stmt = mysqli_prepare($connection,"SELECT cat_id, cat_title FROM categories2 WHERE cat_id = ?");
            confirm($stmt);
            mysqli_stmt_bind_param($stmt, 'i', $cat_id);
            mysqli_stmt_execute($stmt);

            while(mysqli_stmt_fetch($stmt)){

            

    ?>
        <input value = "<?php if(isset($cat_title)) echo $cat_title; ?>" type="text" name="cat_title" class="form-control">

    <?php }} ?>

    <!-- UPDATE -->
    <?php 

        if(isset($_POST['update'])){
            $cat_title_update = escape($_POST['cat_title']);
            
            $stmt = mysqli_prepare($connection,"UPDATE categories2 SET cat_title = ? WHERE cat_id = ?");
            confirm($stmt);
            mysqli_stmt_bind_param($stmt,'si', $cat_title_update, $cat_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header('Location: categories.php');
        }

    ?>

    </div>
    <div class="form-group">
        <input class=" btn btn-primary" type="submit" name="update" value="Update Category">
    </div>
</form>