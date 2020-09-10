<?php
    if(ifItIsMethod('post')){

        if(isset($_POST['login'])){

            if(isset($_POST['username']) && isset($_POST['password'])){
    
                login_user($_POST['username'],$_POST['password']);
    
            }
            else{
    
                header("Location: index");
    
            }


        }

    }

?>

<div class="col-md-4">

                

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search" method="post">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control">
                            <span class="input-group-btn">
                            <button name = "submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>

                <?php

                    if(isset($_SESSION['role'])){

                        $username = $_SESSION['username'];

                        ?>

                        <!-- Login Form -->
                            <div class='well'>
                                <h4>You are logged in as <?php echo $username; ?>.</h4>
                                <span class='input-group'>
                                <a href='/myWebSite/cms/includes/logout.php'><button name = 'logout' class='btn btn-primary' type='submit'><i class='fa fa-fw fa-power-off'></i></button></a> 
                                </span>
                                <!-- /.input-group -->
                            </div>
                        <?php
                    }
                    else{

                        ?>

                        <!-- Login Form -->
                            <div class='well'>
                                <h4>Login</h4>
                                <form action='/myWebSite/cms/index' method='post'>
                                    <div class='form-group'>
                                        <input type='text' name='username' class='form-control' placeholder='Enter Username'>
                                    </div>
                                    <div class='input-group'>
                                        <input type='password' name='password' class='form-control' placeholder='Enter Password'>
                                        <span class='input-group-btn'>
                                            <button name = 'login' class='btn btn-primary' type='submit'>Submit  
                                            </button>
                                        </span>
                                    </div><br>
                                    <div class='form-group'>
                                        <a href = 'forgot.php?forgot=<?php echo uniqid(true); ?>'>Forgot password</a>
                                    </div>
                                </form>
                                <!-- /.input-group -->
                            </div>
                        <?php

                    }

                ?>



                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">

                            <?php

                                $query = "SELECT * FROM categories2";
                                $select_categories_sidebar = mysqli_query($connection,$query);

                                while($row = mysqli_fetch_assoc($select_categories_sidebar)){

                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<li><a href='/myWebSite/cms/category/{$cat_id}'>{$cat_title}</a></li>";

                                }

                            ?>
                                
                            </ul>
                        </div>
                        
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "includes/widget.php"; ?>

            </div>