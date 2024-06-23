<?php include('partials/menu.php'); ?>

<?php

                    // check whether the id is set or not
                    if(isset($_GET['id']))
                    {
                         // get the id and all details
                         // echo "Getting Details";
                         $id = $_GET['id'];

                         // Create sql query to get all other details
                         $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

                         // Execute the query
                         $res2 = mysqli_query($conn,$sql2);

                         
                         // get the values based on query execute
                         $row2 = mysqli_fetch_assoc($res2);

                         // get all the details of selected food
                         $title = $row2['title'];
                         $description = $row2['description'];
                         $price = $row2['price'];
                         $current_image = $row2['image_name'];
                         $current_category = $row2['category_id'];
                         $featured = $row2['featured'];
                         $active = $row2['active'];

                    }
                    else
                    {
                         // Redirect to manage food
                         header('location:'.SITEURL.'admin/manage-food.php');
                    }
    


?>

<div class="main-content">
     <div class="wrapper">
          <h1>Update Food</h1>
          <br><br>

          <?php
               if(isset($_SESSION['upload']))
               {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
               }
          ?>

          <form action="" method="POST" enctype="multipart/form-data">

               <table class="tbl-30">
                    <tr>
                         <td>Title: </td>
                         <td>
                              <input type="text" name="title" value="<?php echo $title; ?>"> 
                         </td>
                    </tr>
                    
                    <tr>
                         <td>Description: </td>
                         <td>
                              <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                         </td>
                    </tr>
                    
                    <tr>
                         <td>Price: </td>
                         <td>
                              <input type="number" name="price" value="<?php echo $price; ?>">
                         </td>
                    </tr>

                    <tr>
                         <td>Current Image: </td>
                         <td>
                              <?php

                                   if($current_image == "")
                                   {
                                        // immage not available
                                        echo "<div class='error'>Image Not Available</div>";
                                   }
                                   else
                                   {
                                        // Image available
                                        ?>
                                             <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                                        <?php
                                   }
                              ?>
                         </td>
                    </tr>

                    <tr>
                         <td>Select New Image:</td>
                         <td>
                              <input type="file" name='image'>
                         </td>
                    </tr>


                    <tr>
                         <td>Category: </td>
                         <td>
                              <select name="category">

                              <?php
                                   // Query to get active categories
                                   $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                   // Execute the query
                                   $res = mysqli_query($conn,$sql);
                                   // Count rows
                                   $count = mysqli_num_rows($res);
                                   // check whether category available or not
                                   if($count>0)
                                   {
                                        // categorry available
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                             $category_title = $row['title'];
                                             $category_id = $row['id'];

                                             // echo "<option value='$category_id'>$category_title</option>";
                                             ?>
                                                  <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                             <?php
                                        }
                                   }
                                   else
                                   {
                                        // category not available
                                        echo "<option value='0'>Category Not Available.</option>";
                                   }
                              ?>


                                   <option value="0">Test Category</option>
                              </select>
                         </td>
                    </tr>

                    <tr>
                         <td>Featured: </td>
                         <td><input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes</td>
                         <td><input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No">No</td>
                    </tr>

                    <tr>
                         <td>Active: </td>
                         <td><input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes</td>
                         <td><input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No">No</td>
                    </tr>

                    <tr>
                         <td colspan="2">
                              <input type="hidden" name='id' value="<?php echo $id; ?>">
                              <input type="hidden" name='current_image' value="<?php echo $current_image; ?>">
                              <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                         </td>
                    </tr>
               </table>

          </form>

          <?php
               if(isset($_POST['submit']))
               {
                    // echo "Button Clicked";
                    // 1. Get all the details from the form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price  = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];



                    // 2. Upload the image if selected
                    // Uploading New Image

                    if(isset($_FILES['image']['name']))
                    {
                         // get the details of the selected image
                         $image_name = $_FILES['image']['name']; //new image
                         // $image_name = $_GET['image'];

                         // Check whether the image is selected or not and upload image only if selected
                         if($image_name!="")
                         {
                              // Image is selected
                              // Rename the image
                              $ext = explode('.',$image_name);

                              $ex1 = end($ext);
                              // $ext = end(explode('.',$image_name));

                              // Create new name for image
                              $image_name = "Food-Name-".rand(0000,9999).'.'.$ex1;  //new name as "Food-Name-231"
                              
                              // Upload the image
                              // Get the src path and Destination Path

                              // Source path is the current location of the image
                              $src_path = $_FILES['image']['tmp_name'];

                              // Destination path for the image to be uploaded
                              $dest_path = "../images/food/".$image_name;

                              // Finally Upload the food image
                              $upload = move_uploaded_file($src_path, $dest_path);

                              // Check whether image is uploaded or not
                              if($upload==false)
                              {
                                   //failed to upload image
                                   // Redirect to Add Food page with Error Message
                                   $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                                   header('location:'.SITEURL.'admin/manage-food.php');
                                   // Stop the process
                                   die();
                              }
                                   // 3. Remove the image if new image is uploaded and current image is exists
                                   // Remove current image if available
                              if($current_image!="")
                              {
                                   // Current Image is available
                                   // Remove the image
                                   $remove_path = "../images/food/".$current_image;

                                   $remove = unlink($remove_path);

                                  // Check whether the image is removed or not
                                   if($remove==false)
                                   {
                                        // Failed to remove current image
                                        $_SESSION['remove-failed'] = "<div class='error'>Failed To Remove Current Image.</div>";
                                        // Redirect to manage food
                                        header('location:'.SITEURL.'admin/manage-food.php');
                                        // stop the process
                                        die();
                                   }
                              }
                         }
                    }
                    else
                    {
                         $image_name = $current_image;
                    }

                    // 4. Update the food in DB.
                    $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active',
                    WHERE id=$id
                    ";

                    // Execute the query
                    $res3 = mysqli_query($conn,$sql3);

                    // Check whether the query executed or not
                    if($res3==true)
                    {
                         // Query Executed and food updated
                          $_SESSION['update'] = "<div class = 'success'>Food Updated Sucessfully</div>";
                         header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                          $_SESSION['update'] = "<div class = 'error'>Failed To Update</div>";
                         header('location:'.SITEURL.'admin/manage-food.php');
                    }
               }
          ?>
     </div>
</div>
<?php include('partials/footer.php'); ?>