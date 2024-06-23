<?php
     // include constant file
     include('../config/constants.php');
     // echo "Delete food";
     if(isset($_GET['id']) AND isset($_GET['image_name']))
     {
          // process to delete
          // echo "Delete";
          // 1.Get id and image
          $id = $_GET['id'];
          $image_name = $_GET['image_name'];

          // Remove the image if available
          // Check whether the image is available or not remove if available
          if($image_name != "")
          {
               // it has image and need to remove from the folder
               // get the image path
               $path = "../images/food/".$image_name;

               // Remove image file from folder
               $remove = unlink($path);

               // echo $remove;
               // die();

               // check whether the image is remove or not
               if($remove==false)
               {
                    // Failed to remove
                    $_SESSION['upload'] = "<div class='error'>Failed To Remove Image File</div>";
                    // Redirect 
                    header('location:'.SITEURL.'admin/manage-food.php');
                    // stop process
                    die();
               }
          }

          // Delete Food from database
          $sql = "DELETE FROM tbl_food WHERE id=$id";

          // Execute the query
          $res = mysqli_query($conn,$sql);

          // Check whether the query is execute or not and set session message respectively
          if($res==true)
          {
               // Food Delete
               $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
               header('location:'.SITEURL.'admin/manage-food.php');
          }
          else
          {
               // Failed To Food Delete
               $_SESSION['delete'] = "<div class='error'>Failed To Delete Food</div>";
               header('location:'.SITEURL.'admin/manage-food.php');
          }
     }
     else
     {
          // Redirect to manage page
          // echo "redirect";
          $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
          header('location:'.SITEURL.'admin/manage-food.php');
     }
?>