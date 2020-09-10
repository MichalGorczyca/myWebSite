<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/myWebSite/cms">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php

                        $query = "SELECT * FROM categories2";
                        $selectAllCategories = mysqli_query($connection,$query);

                        while($row = mysqli_fetch_assoc($selectAllCategories)){

                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];

                            $category_class = '';
                            $registration_class = '';

                            $currentPage = basename($_SERVER['PHP_SELF']);
                            $registration = "registration";
                            $contact = "contact";
                            
                            if(isset($_GET['category']) && $_GET['category'] == $cat_id){

                                $category_class = "active";

                            }
                            else if($currentPage == $registration){

                                $registration_class = "active";

                            }
                            else if($currentPage == $contact){

                                $contact_class = "active";

                            }

                            echo "<li class = '$category_class'><a href='/myWebSite/cms/category/{$cat_id}'>{$cat_title}</a></li>";

                        }

                    ?>

                    <li class = "<?php echo $registration_class; ?>">
                        <a href='/myWebSite/cms/registration?lang=en'>Registration</a>
                    </li>
                    <li class = "<?php echo $contact_class; ?>">
                        <a href='/myWebSite/cms/contact'>Contact</a>
                    </li>

                    <?php

                        if(!isLoggedIn()){
                                                
                            echo    "<li>
                                        <a href='/myWebSite/cms/login.php'>Login</a>
                                    </li>";
                                
                        }
                        else{

                            echo    "<li>
                                        <a href='/myWebSite/cms/includes/logout.php'>Logout</a>
                                    </li>";

                        }

                    ?>

                    
                    <?php

                    if(isset($_SESSION['role'])){
                        
                        $user_role = $_SESSION['role'];
                        
                        if($user_role == 'Admin'){
                            
                            echo "<li>
                            <a href='/myWebSite/cms/admin'>Admin</a>
                            </li>";
                            
                            if(isset($_GET['p_id'])){
                                
                                $post_id = $_GET['p_id'];
                                
                                
                                
                                echo"
                                
                                <li>
                                <a href='/myWebSite/cms/admin/posts.php?source=edit_post&p_id=$post_id'>Edit Post</a>
                                </li>";
                            }
                        }
                    }
                        
                    ?>

                    <li>
                        <a href="/myWebSite/mainContent.php">Go back to MGCoding</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>