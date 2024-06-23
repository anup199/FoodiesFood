<?php include('partials/menu.php') ?>

<div class="main-content">
     <div class="wrapper">
          <h1>Add Admin</h1>
          <br>
          <form action="" method="POST">
               <table class="tbl-30">
                    <tr>
                         <td>Full Name:</td>
                         <td><input type="text" name="full_name" placeholder="E.g Anup Singh"></td>
                    </tr>

                    <tr>
                         <td>Username:</td>
                         <td><input type="text" name="username" placeholder="Your Username"></td>
                    </tr>

                    <tr>
                         <td>Password:</td>
                         <td><input type="password" name="password" placeholder="Your Password"></td>
                    </tr>

                    <tr>
                         <td colspan="2">
                              <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                         </td>
                    </tr>
               </table>
          </form>
     </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
     //check whether the click button is working or not
     if(isset($_POST['submit']))
     {
          //value set and working
          //echo "working";

          // get the data from form
          $full_name = $_POST['full_name'];
          $username = $_POST['username'];
          $password = md5($_POST['password']);    //md5 for password encryption

          //sql query to save the data into database

          $sql = "INSERT INTO tbl_admin SET
          full_name='$full_name',
          username='$username',
          password='$password'
          ";

          //3.execute query and save data in database
// instead of this constants.php add in menu.php file
         // $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error()); //database connection
         // $db_select = mysqli_select_db($conn, 'food_order') or die(mysqli_error()); //selecting database
         //3.executing query and saving data into database
         $res = mysqli_query($conn, $sql) or die(mysqli_error());
     
         //4.check whether the query is executed data is inserted or not and display message

         if($res==TRUE)
         {
               //data inserted
              // echo "data inserted";
              //create a session variable to display message
              $_SESSION['add'] = "Admin Added Successfully";
              //Redirec page to manage admin
              header("location:".SITEURL.'admin/manage-admin.php');
         }
         else{
               //failed to insert data
               //create a session variable to display message
              $_SESSION['add'] = "Failed to Add Admin";
              //Redirec page to add admin
              header("location:".SITEURL.'admin/add-admin.php');
         }
     }

?>