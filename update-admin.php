<?php include('partials/menu.php'); ?>

     <div class="main-content">
          <div class="wrapper">
               <h1>Update Admin</h1>
               
               <br><br>
               
               <?php
                    // 1.get the id from the selected admin
                    $id = $_GET['id'];

                    // 2. create sql query to get the details
                    $sql = "SELECT * FROM tbl_admin WHERE id=$id";

                    // 3.execute the query
                    $res = mysqli_query($conn, $sql);
                    
                    // check whether the query is executed
                    if($res==true)
                    {
                         // whether the data is available or not
                         $count = mysqli_num_rows($res);
                         // check whether we have admin or not
                         if($count==1)
                         {
                              // get the details
                              // echo "Admin Available";
                              $row = mysqli_fetch_assoc($res);

                              $full_name = $row['full_name'];
                              $username = $row['username'];
                         }
                         else
                         {
                              // redirect to manage admin page
                              header('location:'.SITEURL.'admin/manage-admin.php');
                         }
                    }
                    ?>
               <form action="" method="POST">

                    <table>
                         <tr>
                              <td>Full Name: </td>
                              <td>
                                   <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                              </td>
                         </tr>

                         <tr>
                              <td>Username: </td>
                              <td>
                                   <input type="text" name="username" value="<?php echo $username; ?>">
                              </td>
                         </tr>

                         <tr>
                              <td colspan="2">
                                   <input type="hidden" name="id" value="<?php echo $id; ?>">
                                   <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                              </td>
                         </tr>
                    </table>

               </form>
          </div>
     </div>

     <?php
          // checkt whether the submit button is clicked or not

          if(isset($_POST['submit']))
          {
               // echo "Button Clicked";
               // get all the values from form to update

               $id = $_POST['id'];
               $full_name = $_POST['full_name'];
               $username = $_POST['username'];

               // create sql query to update admin

               $sql = "UPDATE tbl_admin SET
               full_name = '$full_name',
               username = '$username' 
               WHERE id=$id
               ";

               // execute the query
               $res=mysqli_query($conn, $sql);

               if($res==TRUE)
               {
                    // query executed and admin updated
                    $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
                    // Redirect the manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
               }
               else
               {
                    // failed to update admin
                    $_SESSION['update'] = "<div class='success'>Failed to Update Admin</div>";
                    // Redirect the manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');

               }
          }
     ?>


<?php include('partials/footer.php'); ?>