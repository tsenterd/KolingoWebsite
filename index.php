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

        while ($class = mysqli_fetch_array($query)) {
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

        ?>

    </div>

</div>

<div id = "main-panel">

    <?php

    include "connect.php";


    if (isset($_GET["class_id"])) {

            $class_id = $_GET["class_id"];

            $query = mysqli_query($conn, 'SELECT class_name FROM classes WHERE class_id = '.$class_id);

            while ($class = mysqli_fetch_array($query)) {
                echo $class[0];
            }
        }

    ?>

    <div id = "top-nav">

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