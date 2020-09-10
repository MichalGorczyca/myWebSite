<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/nav.php"; ?>

    <?php

        if(isset($_POST['liked'])){

            $post_id = $_POST['post_id'];
            $user_id = $_POST['user_id'];

            $query = "SELECT * FROM posts2 WHERE post_id = $post_id";
            $selectResults = mysqli_query($connection, $query);
            confirm($selectResults);
            $post = mysqli_fetch_array($selectResults);
            $likes = $post['likes'];

            $update_likes = mysqli_query($connection, "UPDATE posts2 SET likes = $likes + 1 WHERE post_id = $post_id");
            confirm($update_likes);

            $insert_likes = mysqli_query($connection, "INSERT INTO likes(post_id, user_id) VALUES($post_id, $user_id)"); 
            confirm($insert_likes);
            exit();
        }

        if(isset($_POST['unliked'])){

            $post_id = $_POST['post_id'];
            $user_id = $_POST['user_id'];

            $query = "SELECT * FROM posts2 WHERE post_id = $post_id";
            $selectResults = mysqli_query($connection, $query);
            confirm($selectResults);
            $post = mysqli_fetch_array($selectResults);
            $likes = $post['likes'];

            $delete_likes = mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id"); 
            confirm($delete_likes);

            $update_likes = mysqli_query($connection, "UPDATE posts2 SET likes = $likes-1 WHERE post_id = $post_id");
            confirm($update_likes);
            exit();
        }

    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                

            <?php
                if(isset($_GET['p_id'])){

                $post_id = escape($_GET['p_id']);


                $query = "UPDATE posts2 SET post_views_count = post_views_count + 1 WHERE post_id=$post_id";
                $update_views = mysqli_query($connection,$query);
                confirm($update_views);


                $query = "SELECT * FROM posts2 WHERE post_id={$post_id}";
                $select_all_posts = mysqli_query($connection,$query);

                if(!$select_all_posts){

                    die("QUERY FAILED ".mysqli_error($connection));

                }

                    while($row = mysqli_fetch_assoc($select_all_posts)){
                        $post_title = $row['post_title'];
                        $post_author = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_views = $row['post_views_count'];
            ?>

                
                <h1 class="page-header">
                    <p class="text-center">Post Page</p>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <br><p class="text-right">Views: <?php echo $post_views; ?></p>
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

                <?php if(!isLoggedIn()){ ?>

                    <div class="row">
                        <p class="pull-right likes">You need to <a href="/cms/login.php">login</a> to like this post</p>    
                    </div>

               <?php }
               else{ ?>

                        
                <div class="row">
                    <p class="pull-right"><a class="<?php echo userLikedThisPost($post_id) ? 'unlike' : 'like'; ?>" href=""><span class= "<?php echo userLikedThisPost($post_id) ? 'glyphicon glyphicon-thumbs-down' : 'glyphicon glyphicon-thumbs-up'; ?>" 
                    data-toggle="tooltip"
                    data-placemente="top"
                    title="<?php echo userLikedThisPost($post_id) ? 'You liked it before' : 'Wanna like this?'?>"><?php echo userLikedThisPost($post_id) ? ' Unlike' : ' Like'; ?></span></a></p>    
                </div>

               <?php } ?>
                <div class="row">
                    <p class="pull-right likes">Like: <?php echo getPostLikes($post_id); ?></p>    
                </div>
                <div class="clearfix"></div>

            <?php

                    }}
                    else{
                        header("Location:index.php");
                    }
            ?>

            
                <?php

                    if(isset($_POST['create_comment'])){

                        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                        $post_id = escape($_GET['p_id']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_author = escape($_POST['comment_author']);
                        $comment_content = escape($_POST['comment_content']);

                        if(!empty($comment_email) && !empty($comment_author) && !empty($comment_content)){

                            $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_date, user_id) "; 
                            $query .= "VALUES ('{$post_id}','{$comment_author}','{$comment_email}','{$comment_content}',now(),$user_id)";
                            $add_comment_query = mysqli_query($connection,$query);
                            
                            if(!$add_comment_query){
                                
                                die("QUERY FAILED ".mysqli_error($connection));
                                
                            }
                            
                            $query2 = "UPDATE posts2 SET post_comment_count = post_comment_count + 1 WHERE post_id = {$post_id}";
                            $increament_comment_count_query = mysqli_query($connection,$query2);
                            
                            if(!$increament_comment_count_query){
                                
                                die("QUERY FAILED ".mysqli_error($connection));
                                
                            }
                            
                        }
                        else

                            echo "<script>alert('Fields cannot be empty!')</script>";
                    }
                        
                ?>
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input class="form-control" type="text" name="comment_author">
                        </div>
                        <div class="form-group">
                        <label for="comment_email">E-mail</label>
                            <input class="form-control" type="text" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Content</label>
                            <textarea type="text" class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                    
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
                    $query .= "AND comment_status = 'approved' ORDER BY comment_id DESC";

                    $show_comments_query = mysqli_query($connection,$query);

                    if(!$show_comments_query){

                        die("QUERY FAILED ".mysqli_error($connection));

                    }

                    while($row = mysqli_fetch_assoc($show_comments_query)){

                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        
                ?>


                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

                    <?php } ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
<?php include "includes/footer.php"; ?>

<script>

    $(document).ready(function(){

        $("[data-toggle='tooltip']").tooltip();

        var post_id = <?php echo $post_id; ?>;
        var user_id = <?php echo loggedInUserId(); ?>;

        $('.like').click(function(){

            $.ajax({

                url: "/cms/post.php?p_id=<?php echo $post_id; ?>",
                type: "post",
                data:{
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }

            });

        });

        $('.unlike').click(function(){

            $.ajax({

                url: "/cms/post.php?p_id=<?php echo $post_id; ?>",
                type: "post",
                data:{
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }

            });

        });

    });

</script>
        
