<html>
<head>
    <title>EdAppHack Demo</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/main.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
</head>


<body>
<div id ="wrapper">
<div id="sidebar">

    <div id="account">
        <a href="#">
            <span class="avatar">
                <img src="https://gravatar.com/avatar/5936a3fb444dbb59f32ef0d2c8027196?s=96&d=https://dashboard.heroku.com%2Fninja-avatar-48x48.png%3Fssl%3D1" />
            </span>
            <span class="sidebar-user-name">
                <p>Jonathan Galperin</p>
            </span>
        </a>
    </div>

    <div id = "shortcuts">


        <?php

        include "connect.php";

        $query = mysqli_query($conn, 'SELECT class_id, class_name FROM classes');

        $class_id_list = array();

        while ($class = mysqli_fetch_array($query)) {

            $class_id_list[] = $class["class_id"];

            echo '

                <a href=?class_id='.$class["class_id"].'>
                    <div class = "sidebar-class">
                        <span class="sidebar-class-name">
                        <p>'.$class["class_name"].'<p>
                        </span>
                    </div>
                </a>

            ';
        }

        echo '</div>

            </div>
            <div id = "main-panel">

            <div id = "title-container">';


        $class_name = "";

        if (isset($_GET["class_id"])) {

            $class_id = $_GET["class_id"];

            $query = mysqli_query($conn, 'SELECT class_name FROM classes WHERE class_id = '.$class_id);

            while ($class = mysqli_fetch_array($query)) {
                $class_name = $class[0];
            }
        } else {
            $query = mysqli_query($conn, 'SELECT class_name FROM classes WHERE class_id = '.$class_id_list[0]);

            while ($class = mysqli_fetch_array($query)) {
                $class_name = $class[0];
            }

        }

        echo '<div id="class-title">

             <span class = "title">   '.$class_name.' </span> </div>';
    ?>
    </div>

    <div id = "top-nav-container">
        <ul id="top-nav">
            <li id="active"><a href="">Homework</a></li>
            <li><a href="">Announcements</a></li>
            <li><a href="">Marks</a></li>
        </ul>
    </div>
    <div id = "main-content">

    </div>
</div>
</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="scripts/main.js"></script>
</body>

</html>