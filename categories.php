<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

           <?php

                // Display all the category that are active
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                // Execute query
                $res = mysqli_query($conn,$sql);

                // Count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    // Category Available
                    while($rows = mysqli_fetch_assoc($res))
                    {
                        // Get the value like id,details etc
                        $id = $rows['id'];
                        $title = $rows['title'];
                        $image_name = $rows['image_name'];
                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php

                                    if($image_name=="")
                                    {
                                        // Display message image not available
                                        echo "<div class='error'>Image Not Found.</div>";
                                    }
                                    else
                                    {
                                        // Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>


                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                            </a>

                        <?php
                    }
                }
                else
                {
                    // Category Not available
                    echo "<div class='error'>Category Not Found.</div>";
                }

            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


   <?php include('partials-front/footer.php'); ?>