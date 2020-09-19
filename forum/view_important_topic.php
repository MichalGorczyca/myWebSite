<?php include "includes/forumHeader.php"; ?>
<?php if(!isset($_SESSION['username'])) header("Location: login.php") ?>
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/forum.css" type="text/css">
    <link rel="stylesheet" href="css/viewTopic.css" type="text/css">
</head>
<body>
<?php include "includes/forumNav.php"; ?>
<?php $current_page = ""; ?>


<?php include "includes/main.php"; ?>
        <div class="post p-3">
        <?php if(isset($_GET['id'])){

            $important_topic_id = $_GET['id'];

            $query = "SELECT * FROM important WHERE important_id = $important_topic_id";

            $get_topic_query = mysqli_query($connection, $query);
            if(!$get_topic_query){

                die("Query Failed ".mysqli_error($connection));

            } 

            while($row = mysqli_fetch_assoc($get_topic_query)){

                $title = $row['important_title'];
                $author = $row['important_author'];
                $content = $row['important_content'];
                $date = $row['important_date'];
                $views = $row['important_views'];

                echo "
                
                    <div class='h2 float-left'>{$title}</div>
                    <div class='text-right'>Created in: {$date}</div>
                    <div class='text-right'>Views: {$views}</div>
                    <div class='h6 pb-3'>Written by {$author}</div>
                    <div>{$content}</div>
                
                ";

            }

            }

        ?>
        <a href="#" class="addComment"><div class="pt-4 text-right text-decoration-none font-weight-bold text-dark">Add Comment</div></a>
            <form action="view_important_topic.php?id=<?php echo $important_topic_id; ?>" method="post" class="commentForm form-group d-none">
                <textarea name="content" class="col-12 mt-3" rows="2"></textarea>
                <input type="submit" name="submit" class="btn" style="background-color: #4169E1; color: #fff;" value="Submit">
            </form>
        </div>
        <?php

        if(isset($_POST['submit'])){

            $comment_important_id = $important_topic_id;
            $user_id = $_SESSION['user_id'];
            $content = $_POST['content'];
            $date = date('Y-m-d');

            $query = "INSERT INTO comments(comment_important_id,comment_user_id,comment_content,comment_date) VALUES($comment_important_id,$user_id,'$content','$date')";
            $insert_comment = mysqli_query($connection, $query);
            if(!$insert_comment){

                die("Query Failed ".mysqli_error($connection));

            }
        }
            
            $query = "SELECT * FROM comments WHERE comment_important_id = '$important_topic_id'";
            $get_comments_query = mysqli_query($connection, $query);
            if(!$get_comments_query){
                
                die("Query Failed ".mysqli_error($connection));
                
            }
            
            while($comment = mysqli_fetch_assoc($get_comments_query)){
                
                $comment_user_id = $comment['comment_user_id'];
                $comment_content = $comment['comment_content'];
                $comment_date = $comment['comment_date'];
                
                $query = "SELECT * FROM users WHERE user_id = {$comment_user_id}";
                $get_comment_creator = mysqli_query($connection, $query);
                if(!$get_comment_creator){
                    
                    die("Query Failed ".mysqli_error($connection));
                    
                }

                while($row = mysqli_fetch_assoc($get_comment_creator)){

                    $comment_author = $row['username'];

                    echo "
                    
                    <div class='comment p-3 my-3'>
                        <div class='h2 float-left'>Re: {$title}</div>
                        <div class='text-right pb-4'>Created in: {$comment_date}</div>
                        <div class='h6 pb-3'>Written by {$comment_author}</div>
                        <div>{$comment_content}</div>
                    </div>
                    
                    ";

                }
                
                
            }





        ?>        
    
    <?php include "includes/sidebar.php"; ?>
            

<?php include "includes/forumFooter.php"; ?>