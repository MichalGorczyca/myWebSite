<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/nav.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                <?php

                    if(isset($_GET['category'])){

                        $post_category_id = escape($_GET['category']);

                    }
                    else{

                        $post_category_id = "";

                    }

                    $query = "SELECT * FROM categories2 WHERE cat_id = '{$post_category_id}'";
                    $selectAllCategories = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($selectAllCategories)){

                        $cat_title = $row['cat_title'];
                        echo "<p class='text-center'>Category: ".$cat_title."</p>";

                    }

                ?>
                </h1>

                

            <?php

                if(isset($_SESSION['role']) && is_admin($_SESSION['username'])){

                    $stmt1 = mysqli_prepare($connection,"SELECT post_id, post_title, post_user, post_date, post_image, post_content, post_views_count FROM posts2 WHERE post_category_id = ? ORDER BY post_id DESC");

                    confirm($stmt1);

                }
                else{

                    $stmt2 = mysqli_prepare($connection ,"SELECT post_id, post_title, post_user, post_date, post_image, post_content, post_views_count FROM posts2 WHERE post_category_id = ? AND post_status = ? ORDER BY post_id DESC");
                    $published = 'published';

                    confirm($stmt2);

                }

                if(isset($stmt1)){

                    mysqli_stmt_bind_param($stmt1,'i',$post_category_id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content, $post_views_count);

                    $stmt = $stmt1;
                    mysqli_stmt_store_result($stmt);
                }
                else{

                    mysqli_stmt_bind_param($stmt2,'is',$post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content, $post_views_count);

                    $stmt = $stmt2;
                    mysqli_stmt_store_result($stmt);

                }
                
                
                

                if(mysqli_stmt_num_rows($stmt) === 0){

                    echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";

                }
                else{

                    
                    while(mysqli_stmt_fetch($stmt)):
                        
                        ?>

                
                        
                        <!-- First Blog Post -->
                        <h2>
                            <a href="/cms/post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="/cms/author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                        <hr>
                        <a href="/cms/post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt=""></a>
                        <br><p class="text-right">Views: <?php echo $post_views_count; ?></p>
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>

            <?php

                    endwhile; mysqli_stmt_close($stmt);
                }
            ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
<?php include "includes/footer.php"; ?>
        
