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
                    <p class="text-center">Search Results</p>
                </h1>

            <?php



                if(isset($_POST['submit'])){

                    $search = escape($_POST['search']);
                    if(isset($_SESSION['role']) && $_SESSION['role'] == "Admin"){

                        $query = "SELECT * FROM posts2 WHERE post_tags LIKE '%$search%' ORDER BY post_id DESC";
    
                    }
                    else{
    
                        $query = "SELECT * FROM posts2 WHERE post_tags LIKE '%$search%' AND post_status = 'published' ORDER BY post_id DESC";
    
                    }
                    
                    $search_query = mysqli_query($connection,$query);
                    $count = mysqli_num_rows($search_query);

                    if($count < 1){

                        echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";

                    }
                    else{

                        
                        if(!$search_query){

                            echo "QUERY FAILED".mysqli_error($connection);
                            
                        }
                        else{
                        
                            while($row = mysqli_fetch_assoc($search_query)){
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_author = $row['post_user'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];
                                $post_views = $row['post_views_count'];
                                
                                ?>

                

                                <!-- First Blog Post -->
                                <h2>
                                <a href="/myWebSite/cms/post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="/myWebSite/cms/author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>
                                <a href="/myWebSite/cms/post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="/myWebSite/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt=""></a>
                                <br><p class="text-right">Views: <?php echo $post_views; ?></p>
                                <hr>
                                <p><?php echo $post_content; ?></p>
                                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                <hr>

                <?php

                            }


                        }

                    }
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
        
