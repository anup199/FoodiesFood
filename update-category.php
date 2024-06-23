<?php include('partials/menu.php'); ?>

     <div class="main-content">
          <div class="wrapper">
               <h1>Update Category</h1>
               <br><br>

               <?php

                    // check whether the id is set or not
                    if(isset($_GET['id']))
                    {
                         // get the id and all details
                         // echo "Getting Details";
                         $id = $_GET['id'];

                         // Create sql query to get all other details
                         $sql = "SELECT * FROM tbl_category WHERE id=$id";

                         // Execute the query
                         $res = mysqli_query($conn,$sql);

                         
                         // count the rows to check whether the id valid or not
                         $count = mysqli_num_rows($res);

                         
                         if($count==1)
                         {
                              // get all the data
                              $row = mysqli_fetch_assoc($res);
                              $title = $row['title'];
                              $current_image = $row['image_name'];
                              $featured = $row['featured'];
                              $active = $row['active'];
                         }
                         else
                         {
                              // Redirect to manage category with session message
                              $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                              header('location:'.SITEURL.'admin/manage-category.php');
                         }

                    }
                    else
                    {
                         // Redirect to manage category
                         header('location:'.SITEURL.'admin/manage-category.php');
                    }

               ?>

               <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                         <tr>
                              <td>Title:</td>
                              <td>
                                   <input type="text" name="title" value="<?php echo $title; ?>">
                              </td>
                         </tr>

                         <tr>
                              <td>Current Image:</td>
                              <td>
                                   <?php
                                   
                                        if($current_image != "")
                                        {
                                             // Display the image
                                             ?>

                                             <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                             
                                             <?php
                                        }
                                        else
                                        {
                                             // Display message
                                             echo "<div class='erro'>Image Not Added</div>";
                                        }
                                   
                                   ?>
                              </td>
                         </tr>

                         <tr>
                              <td>New Image:</td>
                              <td>
                                   <input type="file" name="image">
                              </td>
                         </tr>

                         <tr>
                              <td>Featured: </td>
                              <td>
                                   <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                                   <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                              </td>
                         </tr>

                         <tr>
                              <td>Active: </td>
                              <td>
                                   <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                                   <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                              </td>
                         </tr>

                         <tr>
                              <td>
                                   <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                   <input type="hidden" name="id" value="<?php echo $id; ?>">
                                   <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                              </td>
                         </tr>
                    </table>
               </form>

               <?php
               
                    if(isset($_POST['submit']))
                    {
                         // echo "Clicked";
                         //1. Get all the values from the form
                         $id = $_POST['id'];
                         $title = $_POST['title'];
                         $current_image = $_POST['current_image'];
                         $featured = $_POST['featured'];
                         $active = $_POST['active'];

                         //2. Update New image if selected
                         if(isset($_FILES['image']['name']))
                         {
                              // Get the image Details
                              $image_name = $_FILES['image']['name'];

                              if($image_name != "")
                              {
                                   //A. Image Available
                                   // Upload the Image
                                    // auto rename our image
                                   // get the extension of the image- jpg, png, gif, etc. eg. food.jpg
                                   $ext = end(explode('.', $image_name));

                                   // rename the image
                                   $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //Food_Category342.jpg

                                   $source_path = $_FILES['image']['tmp_name'];

                                   $destination_path = "../images/category/".$image_name;
                                   // finally upload the image
                                   $upload = move_uploaded_file($source_path, $destination_path);

                                   // check whether the image is uploaded or not
                                   // and if the image is not uploaded then we will stop the process and redirect the error message

                                   if($upload==false)
                                   {
                                        // set message
                                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                                        // redirect to add category page
                                        header('location:'.SITEURL.'admin/manage-category.php');
                                        // stop the process
                                        die();
                                   }

                                        //B. Remove the current image if Available
                                        if($current_image != "")
                                        {
                                             $remove_path = "../images/category/".$current_image;

                                             $remove = unlink($remove_path);
                                             // Check whether the image is remove or not
                                             // If fail to remove then display the message and stop the process
                                             if($remove==false)
                                             {
                                                  // Failed to remove the Image
                                                  $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image.</div>";
                                                  header('location:'.SITEURL.'admin/manage-category.php');
                                                  die();    //stop the process
                                             }
                                        }
                              }
                              else
                              {
                                   $image_name = $current_image;
                              }
                         }
                         else
                         {
                              $image_name = $current_image;
                         }

                         // 3.Update Database
                         $sql2 = "UPDATE tbl_category SET
                              title = '$title',
                              image_name = '$image_name',
                              featured = '$featured',
                              active = '$active'
                              WHERE id = '$id'
                         ";

                         //Execute the query
                         $res2 = mysqli_query($conn,$sql2);

                         // Redirect to manage category with message
                         // Check whether execute or not

                         if($res2==true)
                         {
                              // Category Updated
                              $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                              header('location:'.SITEURL.'admin/category.php');
                         }
                         else
                         {
                              // Failed to Update Category
                              $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                              header('location:'.SITEURL.'admin/category.php');
                         }



                    }

               ?>
          </div>
     </div>

<?php include('partials/footer.php'); ?>