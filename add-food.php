<?php include('partials/menu.php'); ?>

<div class="main-content">
     <div class="wrapper">
          <h1>Add Food</h1>
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
                              <input type="text" name="title" placeholder="Title of the Food"> 
                         </td>
                    </tr>
                    
                    <tr>
                         <td>Description: </td>
                         <td>
                              <textarea name="description" cols="30" rows="5" placeholder="Descripttion of the Food"></textarea>
                         </td>
                    </tr>
                    
                    <tr>
                         <td>Price: </td>
                         <td>
                              <input type="number" name="price">
                         </td>
                    </tr>

                    <tr>
                         <td>Select Image: </td>
                         <td>
                              <input type="file" name="image">
                         </td>
                    </tr>


                    <tr>
                         <td>Category: </td>
                         <td>
                              <select name="category">

                                   <?php
                                        // create php code to display categories from database
                                        // 1. create sql to get all the active categories from database
                                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                        // Executing query
                                        $res = mysqli_query($conn,$sql);

                                        // count to check whether we have categories or not
                                        $count = mysqli_num_rows($res);

                                        // if count > 0 we have categories else don't
                                        if($count>0)
                                        {
                                             // we have categories
                                             while($row=mysqli_fetch_assoc($res))
                                             {
                                                  // Get the details of category
                                                  $id = $row['id'];
                                                  $title= $row['title'];

                                                  ?>

                                                       <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                                  <?php
                                             }
                                        }
                                        else
                                        {
                                             // we do not have category
                                             ?>
                                                  <option value="0">No Category Found.</option>
                                             <?php
                                        }
                                   ?>

                              </select>
                         </td>
                    </tr>

                    <tr>
                         <td>Featured: </td>
                         <td><input type="radio" name="featured" value="Yes">Yes</td>
                         <td><input type="radio" name="featured" value="No">No</td>
                    </tr>

                    <tr>
                         <td>Active: </td>
                         <td><input type="radio" name="active" value="Yes">Yes</td>
                         <td><input type="radio" name="active" value="No">No</td>
                    </tr>

                    <tr>
                         <td colspan="2">
                              <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                         </td>
                    </tr>
               </table>

          </form>

          <?php
          
               // Check whether the button is clicked or not

               if(isset($_POST['submit']))
               {
                    // Add the Food in database
                    // echo "Clicked";

                    // 1.Get the data from Form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    // Check whether radio button for featured and active are checked or not
                    if(isset($_POST['featured']))
                    {
                         $featured = $_POST['featured'];
                    }
                    else
                    {
                         $featured = "No"; //Setting Default value
                    }

                    if(isset($_POST['active']))
                    {
                         $active = $_POST['active'];
                    }
                    else
                    {
                         $active = "No"; //Setting Default value
                    }

                    // 2.Upload the Image if selected
                    // Check whether the select image is clicked or not and upload the image only if the image is selected
                    if(isset($_FILES['image']['name']))
                    {
                         // get the details of the selected image
                         $image_name = $_FILES['image']['name'];

                         // Check whether the image is selected or not and upload image only if selected
                         if($image_name!="")
                         {
                              // Image is selected
                              // Rename the image
                              $ext = end(explode('.',$image_name));

                              // Create new name for image
                              $image_name = "Food-Name-".rand(0000,9999).".".$ext;  //new name as "Food-Name-231"
                              
                              // Upload the image
                              // Get the src path and Destination Path

                              // Source path is the current location of the image
                              $src = $_FILES['image']['tmp_name'];

                              // Destination path for the image to be uploaded
                              $dst = "../images/food/".$image_name;

                              // Finally Upload the food image
                              $upload = move_uploaded_file($src, $dst);

                              // Check whether image is uploaded or not
                              if($upload==false)
                              {
                                   //failed to upload image
                                   // Redirect to Add Food page with Error Message
                                   $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                   header('location:'.SITEURL.'admin/add-food.php');
                                   // Stop the process
                                   die();
                              }
                         }
                    }
                    else
                    {
                         $image_name = ""; //Setting Default value as blank
                    }

                    // 3.Insert into database

                    // Create sql query to save or add food
                    $sql2 = "INSERT INTO tbl_food SET
                         title = '$title',
                         description = '$description',
                         price = $price,
                         image_name = '$image_name',
                         category_id = '$category',
                         featured = '$featured',
                         active = '$active'
                         ";

                         // Execute the query
                         $res2 = mysqli_query($conn, $sql2);
                         // check  whether the data is inserted or not
                         if($res2 == true)
                         {
                              // Data inserted successfully
                              $_SESSION['add'] = "<div class = 'success'>Food Added Sucessfully</div>";
                              header('location:'.SITEURL.'admin/manage-food.php');
                         }
                         else
                         {
                              // failed to insert data
                              $_SESSION['add'] = "<div class = 'error'>Failed to Add Food</div>";
                              header('location:'.SITEURL.'admin/manage-food.php');
                         }

                    // 4.Redirect with message to manage Food Page
               }
          
          ?>
     </div>
</div>

<?php include('partials/footer.php'); ?>