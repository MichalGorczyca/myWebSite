<?php include "includes/db.php"; ?>
<?php include "includes/forumHeader.php"; ?>
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/forum.css" type="text/css">
    <link rel="stylesheet" href="css/viewTopic.css" type="text/css">
</head>
<body>
<?php include "includes/forumNav.php"; ?>

<div class="container-fluid">
    <div class="row">
        <?php include "includes/main.php"; ?>
        <div class="box container-fluid mt-3 mx-5">
            <div class="row">
                <div class="content col-8 p-0">
                    <div class="post p-3">
                    <?php if(isset($_GET['id'])){

                        $topic_id = $_GET['id'];

                        $query = "SELECT * FROM topics WHERE topic_id = $topic_id";

                        $get_topic_query = mysqli_query($connection, $query);
                        if(!$get_topic_query){

                            die("Query Failed ".mysqli_error($connection));

                        } 

                        while($row = mysqli_fetch_assoc($get_topic_query)){

                            $title = $row['topic_title'];
                            $author = $row['topic_author'];
                            $content = $row['topic_content'];
                            $date = $row['topic_date'];
                            $views = $row['topic_views'];

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
                    
                    
                    
                    
                    <div class="pt-4 text-right">Add Comment</div>
                    </div>
                </div>
                <?php include "includes/sidebar.php"; ?>
            </div>
        </div>
    </div>
</div>

<?php include "includes/forumFooter.php"; ?>