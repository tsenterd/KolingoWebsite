<html>
<head>
    <title>EdAppHack Demo</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/main.css">
    <link href="//cdn.rawgit.com/noelboss/featherlight/master/release/featherlight.min.css" type="text/css" rel="stylesheet" title="Featherlight Styles" />
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

        ob_start();

        function humanTiming ($original)
        {
            $chunks = array(
                array(60 * 60 * 24 * 365 , 'year'),
                array(60 * 60 * 24 * 30 , 'month'),
                array(60 * 60 * 24 * 7, 'week'),
                array(60 * 60 * 24 , 'day'),
                array(60 * 60 , 'hour'),
                array(60 , 'min'),
                array(1 , 'sec'),
            );

            $today = time(); /* Current unix time  */
            $since = $today - $original;

            // $j saves performing the count function each time around the loop
            for ($i = 0, $j = count($chunks); $i < $j; $i++) {

                $seconds = $chunks[$i][0];
                $name = $chunks[$i][1];

                // finding the biggest chunk (if the chunk fits, break)
                if (($count = floor($since / $seconds)) != 0) {
                    break;
                }
            }

            $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

            if ($i + 1 < $j) {
                // now getting the second item
                $seconds2 = $chunks[$i + 1][0];
                $name2 = $chunks[$i + 1][1];

                // add second item if its greater than 0
                if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
                    $print .= ($count2 == 1) ? ', 1 '.$name2 : " $count2 {$name2}s";
                }
            }
            return $print;
        }


        $query = mysqli_query($conn, 'SELECT class_id, class_name FROM classes');

        $class_id_list = array();


        if (isset($_GET["class"])) {
            $menu_id = $_GET["class"];
        } else {
            $menu_id = 1;
        }

        while ($class = mysqli_fetch_array($query)) {

            $class_id_list[] = $class["class_id"];

            if ($class["class_id"] == $menu_id) {
                echo '

                <a href=?class_id='.$class["class_id"].'&class='.$class["class_id"].'>
                    <div class = "sidebar-class active-class">
                        <span class="sidebar-class-name">
                        <p>'.$class["class_name"].'<p>
                        </span>
                    </div>
                </a>

                ';
            } else {
                echo '

                    <a href=?class_id='.$class["class_id"].'&class='.$class["class_id"].'>
                        <div class = "sidebar-class">
                            <span class="sidebar-class-name">
                            <p>'.$class["class_name"].'<p>
                            </span>
                        </div>
                    </a>

                ';
            }
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

            $class_id = $class_id_list[0];

        }

        echo '<div id="class-title">

             <span class = "title">   '.$class_name.' </span> </div>';
        echo '</div>

    <div id = "top-nav-container">
        <ul id="top-nav">';

            $tabs = array("Homework", "Announcements", "Documents");

            $active_tab = 0;

            if (isset($_GET["tab"])) {
                for ($i = 0; $i < count($tabs); $i++) {
                    if ($_GET["tab"] == $i) {
                        echo '<li><a href="?class_id='.$class_id.'&class='.$class_id.'&tab='.$i.'" class="active">'.$tabs[$i].'</a></li>';
                        $active_tab = $i;
                    } else {
                        echo '<li><a href="?class_id='.$class_id.'&class='.$class_id.'&tab='.$i.'">'.$tabs[$i].'</a></li>';
                    }
                }
            } else {
                echo '<li><a href="?class_id='.$class_id.'&class='.$class_id.'&tab=0" class="active">'.$tabs[0].'</a></li>';
                echo '<li><a href="?class_id='.$class_id.'&class='.$class_id.'&tab=1">'.$tabs[1].'</a></li>';
                echo '<li><a href="?class_id='.$class_id.'&class='.$class_id.'&tab=2">'.$tabs[2].'</a></li>';
            }

        echo '
                </ul>
            </div>
        <div id = "main-content">';

        if ($active_tab == 0) {

            echo '

            <div id="new-homework-button-container">
                <a href="#" data-featherlight="#create"><button class="new-homework-button">+ Homework</button></a>
            </div>

        ';

            $query = mysqli_query($conn, 'SELECT * FROM homework WHERE class_id = '.$class_id.' order by created desc');

            while ($homework = mysqli_fetch_array($query)) {

                $date = date("F j Y, g:i a", strtotime($homework["created"]));

                echo '


                <div id="list-element">
                    <div class="options">
                        <a href="#" data-featherlight="#edit"><img src="resources/images/pencil-2x.png" class="edit"></a>
                        <a href="#" data-featherlight="#delete"><img src="resources/images/delete-2x.png" class="delete"></a>
                    </div>
                    <div class="list-element-data">
                        <span class="homework-title">'.$homework["homework_title"].'</span>
                        <span class="date-assigned">'.$date.'</span></br>
                        <span class="homework-text">'.$homework["homework_data"].'</span>
                    </div>
                </div>



                ';
            }


        }


        if ($active_tab == 1) {
            echo '

            <div id="new-homework-button-container">
                <a href="#" data-featherlight="#create"><button class="new-homework-button">+ Announcement</button></a>
            </div>

        ';

            $query = mysqli_query($conn, 'SELECT * FROM announcements WHERE class_id = '.$class_id.' order by created desc');

            while ($announcement = mysqli_fetch_array($query)) {

                $date = date("F j Y, g:i a", strtotime($announcement["created"]));

                echo '



                <div id="list-element">
                    <div class="options">
                        <a href="#" data-featherlight="#edit"><img src="resources/images/pencil-2x.png" class="edit"></a>
                        <a href="#" data-featherlight="#delete"><img src="resources/images/delete-2x.png" class="delete"></a>
                    </div>
                    <div class="list-element-data">
                        <span class="homework-title">'.$announcement["announcement_title"].'</span>
                        <span class="date-assigned">'.$date.'</span></br>
                        <span class="homework-text">'.$announcement["announcement_data"].'</span>
                    </div>
                </div>



                ';
            }

        }

        if ($active_tab == 2) {
            echo '

            <div id="new-homework-button-container">
                <a href="#" data-featherlight="#create"><button class="new-homework-button">+ Document</button></a>
            </div>

        ';

            $query = mysqli_query($conn, 'SELECT * FROM documents WHERE class_id = '.$class_id.' order by created desc');

            while ($document = mysqli_fetch_array($query)) {

                $date = date("F j Y, g:i a", strtotime($document["created"]));

                $link = filter_var($document["link"], FILTER_SANITIZE_URL);

                echo '



                <div id="list-element">
                    <div class="options">
                        <a href="#" data-featherlight="#edit"><img src="resources/images/pencil-2x.png" class="edit"></a>
                        <a href="#" data-featherlight="#delete"><img src="resources/images/delete-2x.png" class="delete"></a>
                    </div>
                    <div class="list-element-data">
                        <span class="homework-title">'.$document["title"].'</span>
                        <span class="date-assigned">'.$date.'</span></br>
                        <span class="homework-text"><a href="'.$link.'">'.$link.'</a></span>
                    </div>
                </div>



                ';
            }
        }


        echo '</div>';

        if (isset($_POST["title"]))  {

            if (isset($_GET["action"]) && $_GET["action"] == "create")
            if (isset($_GET["class_id"])) {
                $class_id = $_GET["class_id"];
            } else {
                $query = mysqli_query($conn, 'SELECT class_name FROM classes WHERE class_id = '.$class_id_list[0]);

                while ($class = mysqli_fetch_array($query)) {
                    $class_name = $class[0];
                }

                $class_id = $class_id_list[0];

            }


            $title = $_POST["title"];
            $details = $_POST["details"];

            $current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if ($active_tab == 0) {
                $query = mysqli_query($conn, 'INSERT INTO homework (class_id, homework_data, homework_title, created) VALUES ("'.$class_id.'", "'.$details.'", "'.$title.'", NOW())');
                header("Location: ".$current_link);
            } else if ($active_tab == 1) {
                $query = mysqli_query($conn, 'INSERT INTO announcements (class_id, announcement_data, announcement_title, created) VALUES ("'.$class_id.'", "'.$details.'", "'.$title.'", NOW())');
                header("Location: ".$current_link);
            } else if ($active_tab == 2){
                $query = mysqli_query($conn, 'INSERT INTO documents (class_id, link, title, created) VALUES ("'.$class_id.'", "'.$details.'", "'.$title.'", NOW())');
                header("Location: ".$current_link);
            }

        }

        ?>
        <div class="lightbox" id="create">

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?class_id='.$class_id.'&tab='.$active_tab.'&action=create'?>">
                <?php
                    if ($active_tab == 2) {
                    echo '
                        <h1>Add Document</h1>
                        <label>Title</label>
                        <input type="text" name="title">
                        <label>Link</label>
                        <input type="url" name="details">
                    ';
                    } else if ($active_tab == 0) {
                        echo '

                        <h1>Add Homework</h1>
                        <label>Title</label>
                        <input type="text" name="title">
                        <label>Details</label>
                        <textarea rows="10" cols="100" name="details"></textarea>

                        ';
                    } else {
                        echo '
                        <h1>Add Announcement</h1>
                        <label>Title</label>
                        <input type="text" name="title">
                        <label>Details</label>
                        <textarea rows="10" cols="100" name="details"></textarea>
                        ';
                    }
                ?>
                <input type="submit" class="submit-button" name="submit" value="Submit">
            </form>

        </div>

        <div class="lightbox" id="edit">

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?class_id='.$class_id.'&tab='.$active_tab?>">
                <label>Title</label> <input type="text" name="title">
                <label>Details</label>
                <textarea rows="10" cols="100" name="details"></textarea>
                <input type="submit" class="submit-button" name="submit" value="Submit">
            </form>

        </div>

        <div class="lightbox" id="delete">

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?class_id='.$class_id.'&tab='.$active_tab?>">
                <label>Title</label> <input type="text" name="title">
                <label>Details</label>
                <textarea rows="10" cols="100" name="details"></textarea>
                <input type="submit" class="submit-button" name="submit" value="Submit">
            </form>

        </div>
</div>
</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//cdn.rawgit.com/noelboss/featherlight/master/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/main.js"></script>
</body>

</html>