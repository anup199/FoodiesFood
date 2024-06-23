<?php
     // include constant file
     include('../config/constants.php');

     // echo "Delete page";
     // check whether id  and image_name is set or not
     if(isset($_GET['id']) AND isset($_GET['image_name']))
     {
          // get the value and delete
          // echo "Get value and delete";
          $id = $_GET['id'];
          $image_name = $_GET['image_name'];

          // Remove the physical image file is available
          if($image_name != "")
          {
               // Image is available. So remove it
               $path = "../images/category/".$image_name;
               // Remove the image
               $remove = unlink($path);

               // IF failed to remove image then add an error message and stop the process
               if($remove==true)
               {
                    // set the Session message
                    $_SESSION['remove'] = "<div class = 'error'>Failed to Remove Category Image.</div>";
                    // redirect to Manage Category Page
                    header('location:'.SITEURL.'admin/manage-category.php');
                    // stop the process
                    die();
               }
          }
     
     // Delete data from database
     // SQL Query to delete data from databse
     $sql = "DELETE FROM tbl_category WHERE id=$id";

     // Execute the query
     $res = mysqli_query($conn,$sql);

     // check whether the data is delete from database or not
          if($res==true)
          {
               // set Success message and redirect
               $_SESSION['delete'] = "<div class = 'success'>Category Deleted Successfully.</div>";
               // Redirect to manage category
               header('location:'.SITEURL.'admin/manage-category.php');
          }
          else
          {
               // Set fail message and redirect
               $_SESSION['delete'] = "<div class = 'error'>Failed To Delete Category.</div>";
               // Redirect to manage category
               header('location:'.SITEURL.'admin/manage-category.php');

          }

     }
     else
     {
          // redirect to manage category page
          header('location:'.SITEURL.'admin/manage-category.php');
     }
?>