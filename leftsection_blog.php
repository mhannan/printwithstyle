   <div class="body_left">


                <!--left_navigation-->
                <div class="left_navigation_blog">


                         <div class="left_nav_heading">Popular Posts</div>

                        <ul id="left_menu_blog">

                            <?php
                                $popularSet = getPopularPosts('5');
                                while($pRow = mysql_fetch_array($popularSet))
                                    echo "<li><a href='index.php?p=article&id=".$pRow['id']."'>".$pRow['title']."</a></li>";
                            ?>


                        </ul>

                </div><!--left_navigation-->

                <!--left_navigation-->
                <div class="left_navigation_blog">


                        <div class="left_nav_heading">Latest Posts</div>

                        <ul id="left_menu_blog">

                            <?php
                                $latestSet = getLatestPosts('25');
                                while($lRow = mysql_fetch_array($latestSet))
                                    echo "<li><a href='index.php?p=article&id=".$lRow['id']."'>".$lRow['title']."</a></li>";
                            ?>
                              
                        </ul>

                </div><!--left_navigation-->



                


               



</div><!--body_left-->