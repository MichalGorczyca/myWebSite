<div class="container-fluid">
    <div class="row">
        <div class="main mt-3 mx-5 p-3">
            <div class="h3 text-left float-left text-uppercase">Welcome in forum</div> 
            <div class="py-2 h6 text-right">
            
            <?php

                if(isset($_SESSION['username'])){

                    $username = $_SESSION['username'];

                    echo "<span class='px-5'>Logged in as ".$username."</span>";
                    echo "<a href='logout.php' class='register text-dark text-decoration-none font-weight-bold'>Log out</a>";

                }
                else if(!isset($_SESSION['username'])){

                    echo "<a href='login.php' class='px-5 login text-dark text-decoration-none font-weight-bold'>Login</a> <a href='#'  class='register text-dark text-decoration-none font-weight-bold'>Register</a>";

                }
            
            ?>
            </div>
            <div class="back"><a class="text-decoration-none text-dark" href="index.php">Home</a></div>
        </div>
        <div class="box container-fluid mt-3 mx-5">
            <div class="row">
                <div class="content col-8 p-0">