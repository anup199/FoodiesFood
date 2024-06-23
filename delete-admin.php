<?php

     // include constant.php file here
     include('../config/constants.php');
     // 1. get the id of admin to be deleted

     $id = $_GET['id'];

     // 2. create sql query to delete admin
     $sql = "DELETE FROM tbl_admin WHERE id=$id";

     // execute the query
     $res = mysqli_query($conn, $sql);

     // check whether the query executed successfully or not

     if($res==true)
     {
          // query execute successfully
          // echo "Admin deleted";
          // create session variable to display message
          $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
          // Redirect to Manage Admin page

          header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else
     {
          // failed to delete admin
          // echo "Failed to delete admin";
          $_SESSION['delete'] = "<div class='error'>Failed to Deleted Admin. Try again later.</div>";
          // Redirect to Manage Admin page

          header('location:'.SITEURL.'admin/manage-admin.php');
     }
     // 3. redirect to manage adming page with message(success/not successs)


?>