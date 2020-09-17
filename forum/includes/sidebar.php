
                </div>
                    <div class="sidebar col-3 ml-auto">
                        <div class="title p-2 container-fluid">Sidebar</div>
                        <ul class="list-group">
                            <a class="list-group-item list-group-item-action <?php echo $current_page == 'index' ? 'active' : '';?>" href="index.php">Home</a>
                            <?php 
                            
                                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){

                                    echo "
                                    
                                        <a class='list-group-item list-group-item-action ".($current_page == 'important' ? 'active' : '')."' href='create_important_topic.php'>Create important topic</a>
                                    
                                    ";

                                }

                            ?>
                            <a class="list-group-item list-group-item-action <?php echo $current_page == 'create' ? 'active' : '';?>" href="create_topic.php">Create new topic</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>