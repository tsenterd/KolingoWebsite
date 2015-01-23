<?php
/**
 * Created by PhpStorm.
 * User: sudo
 * Date: 15-01-22
 * Time: 9:02 PM
 */


session_start();
if(!session_is_registered(myusername)){
    header("location:index.php");
}
?>

<html>
<body>
Login Successful
</body>
</html>