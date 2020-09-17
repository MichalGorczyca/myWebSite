<?php include "includes/forumHeader.php"; ?>
<?php if(!isset($_SESSION['username'])) header("Location: login.php") ?>
<?php $current_page = 'index'; ?> 
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/Forum.css" type="text/css">
</head>
<body>

<?php include "includes/forumNav.php"; ?>

    
<?php include "includes/main.php"; ?>
        <div class="important">
            <div class="title p-2 container-fluid">Important</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Author</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Views</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                    $query = "SELECT * FROM important";
                    $get_important_topics = mysqli_query($connection, $query);
                    if(!$get_important_topics){

                        die("Query Failed ".mysqli_error($connection));

                    }

                    while($row = mysqli_fetch_assoc($get_important_topics)){

                        $important_topic_author = $row['important_author'];
                        $important_topic_title = $row['important_title'];
                        $important_topic_views = $row['important_views'];
                        $important_topic_date = $row['important_date'];


                        echo "
                        
                            <tr>
                                <td scope='row'>{$important_topic_author}</td>
                                <td>{$important_topic_title}</td>
                                <td>{$important_topic_views}</td>
                                <td>{$important_topic_date}</td>
                            </tr>

                        ";
                    }

                ?>  
                </tbody>
            </table>
        </div>
        <div class="forums mt-3">
            <div class="title p-2 container-fluid">Forums</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Author</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Views</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    $query = "SELECT * FROM topics";
                    $get_topics = mysqli_query($connection, $query);
                    if(!$get_topics){

                        die("Query Failed ".mysqli_error($connection));

                    }

                    while($row = mysqli_fetch_assoc($get_topics)){

                        $topic_id = $row['topic_id'];
                        $topic_author = $row['topic_author'];
                        $topic_title = $row['topic_title'];
                        $topic_views = $row['topic_views'];
                        $topic_date = $row['topic_date'];


                        echo "
                        
                            <tr>
                                <td scope='row'>{$topic_author}</td>
                                <td><a class='font-weight-bold text-dark text-decoration-none' href='view_topic.php?id={$topic_id}'>{$topic_title}</a></td>
                                <td>{$topic_views}</td>
                                <td>{$topic_date}</td>
                            </tr>

                        ";
                    }

                ?>                                
                </tbody>
            </table>
        </div>
    <?php include "includes/sidebar.php"; ?>
                

<?php include "includes/forumFooter.php"; ?>