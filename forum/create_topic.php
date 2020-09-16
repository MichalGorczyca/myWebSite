<?php include "includes/db.php"; ?>
<?php include "includes/forumHeader.php"; ?>
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/forum.css" type="text/css">
    <link rel="stylesheet" href="css/createTopic.css" type="text/css">
</head>
<body>
<?php include "includes/forumNav.php"; ?>



<div class="container-fluid">
    <div class="row">
        <div class="main mt-3 mx-5 p-3">
            <div class="h3 text-left float-left text-uppercase">Welcome in forum</div> 
            <div class="py-2 h6 text-right"><span class="px-2">Login</span> <span>Register</span></div>
            <div class="back"><a class="text-decoration-none text-dark" href="index.php">Home</a></div>
        </div>
        <div class="box container-fluid mt-3 mx-5">
            <div class="row">
                <div class="content col-8 p-0">
                    <div class="create">
                    <div class="title p-2 container-fluid">Create new topic</div>
                    <?php 

                        if(isset($_POST['submit'])){

                            echo "";

                            if(!$_POST['author'] || !$_POST['title'] || !$_POST['content']){

                                echo "<h5 class='text-danger pl-3 pt-3'>Please fill all gaps before you submit</h5>";

                            }
                            else{

                                $author = $_POST['author'];
                                $title = $_POST['title'];
                                $content = $_POST['content'];
                                $date = date('Y-m-d');

                                $query = "INSERT INTO topics(topic_author,topic_title,topic_content,topic_date) VALUES('$author', '$title', '$content', '$date')";

                                $insert_query = mysqli_query($connection, $query);
                                if(!$insert_query){

                                    die("Query Failed ".mysqli_error($connection));

                                }
                                else{

                                    echo "<h5 class='text-success pl-3 pt-3'>New topic has been submited</h5>";

                                }

                            }

                        }

                    ?>
                        <form class="form-group p-3" action="create_topic.php" method="post">
                            <label class="font-weight-bold" for="author">Author</label>
                            <input type="text" class="form-control" name="author" placeholder="Enter author">
                            <label class="pt-3 font-weight-bold" for="title">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title">
                            <label class="pt-3 font-weight-bold" for="content">Content</label>
                            <textarea class="form-control" name="content" placeholder="Enter content" rows="3"></textarea>
                            <input type="submit" class="btn mt-3" name="submit" value="Submit">
                        </form>
                    </div>
                </div>
                <div class="sidebar col-3 ml-auto">
                    <div class="title p-2 container-fluid">Sidebar</div>
                    <ul class="list-group">
                        <a class="list-group-item list-group-item-action" href="index.php">Home</a>
                        <li class="list-group-item active">Create new topic</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include "includes/forumFooter.php"; ?>  
