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
            if( $result ){
                $row = mysqli_fetch_array( $result );
                $settings['cover'] = $row['cover'];
                $settings['paper'] = $row['paper'];
                $settings['rings'] = $row['rings'];
                $settings['text'] = $row['text'];
                $settings['user'] = $_SESSION['username'];
                $settings['scrap'] = $_SESSION['scrapbook'];
            }
            $query = "select * from " . $_SESSION['username'] . "_" . $_SESSION['scrapbook'];
            $result = mysqli_query($db,$query);
            if( $result ){
                while( $row = mysqli_fetch_array( $result ) )
                    $pics[] = array( 
                        'title' => $row['title'],
                        'path' => $row['image_path'],
                        'cap' => $row['caption']
                    );
            }
        }
        mysqli_close($db);
    ?>
    <head>
        <title>DigiScrap: Display</title>
        <script src="assets/js/create.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
    </head>
    <body style="overflow-x:hidden">
        <header><a class="home" href="home.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><button><a href="login.php">Logout</a></button></li>
            <li><button><a href="home.php">Home</a></button></li>
            <li><button onclick="openTab(event, 'About')" class="tablinks">About</button></li>
            <li><button onclick="openTab(event, 'Help')" class="tablinks">Help</button></li>
        </ul>        
        <canvas id="test"></canvas>
        <script type="text/javascript">
            setDisplay( "test", 
                        1400,
                        700,
                        <?php echo json_encode( $settings ) ?>,
                        <?php echo json_encode( $pics ) ?>);
            makePage(0);
            document.onkeydown = function(event) {
                switch (event.keyCode) {
                case 37: // left
                    alert( "left");
                    // handleArrows( "left" );
                    break;
                case 39: // right
                    alert("right");
                    // handleArrows( "right" );
                    break;
                }
            };
        </script>
    </body>
</html>