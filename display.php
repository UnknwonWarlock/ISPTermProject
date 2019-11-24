<!DOCTYPE html>
<html>
    <?php
        session_start();

        $MySQL_db = "db1.cs.uakron.edu:3306"; 
        $MySQL_username = "mcr66";
        $MySQL_password = "ohl5eiB0";

        $db = mysqli_connect($MySQL_db, $MySQL_username, $MySQL_password);
        if(!$db) {

            print "Error - Could not connect to MySQL";
            exit;
        }

        // Select schema from database
        $error = mysqli_select_db($db, "ISP_" . $MySQL_username);
        if (!$error) {

            print "Error - Could not select the database";
            exit;
        }

        $settings;
        $pics;
        if( isset( $_SESSION['scrapbook'] ) ){
            $query = 'select * from ' . $_SESSION['username'] . ' where scrapbook="' . $_SESSION['scrapbook'] . '"';
            $result = mysqli_query($db, $query);
            $pics['text'] = 
            
            $query = "select * from " . $_SESSION['username'] . "_" . $_SESSION['scrapbook'];
            $pics = mysqli_query($db,$query);
        }
    ?>
    <head>
        <title>DigiScrap: Display</title>
        <script src="assets/js/create.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
    </head>
    <body onload="setDisplay('test', 1200, 700, <?php echo json_encode( $settings ) ?>, <?php echo json_encode( $pics ) ?>, '<?php echo $_SESSION['username']?>', '<?php echo $_SESSION['scrap']?>')">
        <header><a class="home" href="home.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><button><a href="login.php">Logout</a></button></li>
            <li><button><a href="home.php">Home</a></button></li>
            <li><button onclick="openTab(event, 'About')" class="tablinks">About</button></li>
            <li><button onclick="openTab(event, 'Help')" class="tablinks">Help</button></li>
        </ul>        
        <canvas id="test"></canvas>
        <script>
            set(1200, 600, "test");
            create("test", "cover", "paper", "rings", "textColor");
        </script>
    </body>
</html>