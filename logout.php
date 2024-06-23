<?php
     // include constant.php for SITEURL
     include('../config/constants.php');

     // 1. Destroy the session
     session_destroy();  //unset the session['user']

     // 2.redirect to login page
     header('location:'.SITEURL.'admin/login.php')

?>