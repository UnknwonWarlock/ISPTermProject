<?php
    session_start();

    $MySQL_db = "db1.cs.uakron.edu:3306"; 
    $MySQL_username = "mcr66";
    $MySQL_password = "ohl5eiB0";

    if($_POST["submit"] == "Create Scrapbook!")
    {
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

        $query = 'SELECT COUNT(1) FROM ' . $_SESSION["username"] . 'WHERE scrapbook="' . $_POST['scrapbook'] . '"';
        trim($query);
        $result = mysqli_query($db, $query);
        if($result == 0)
        {
            $settings = $_POST['backColor'] . "/" . $_POST['captColor'] . "/" . $_POST['bordType'] . "/" . $_POST['bordColor'];
            $query2 = "INSERT INTO " . $_SESSION['username'] . " VALUES('" . $_POST['scrapbook'] . "', '" . $settings . "');";
            trim($query2);
            mysqli_query($db,$query2);
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
    </head>
    <body>
        <header>
            <a class = "home" href = "home.php">DigiScrap</a>: A Place for Scrap Bookers! Welcome <?php echo $_SESSION['username'] ?>! 
        </header>
        <ul>
            <li><a href="login.php"><button>Login</button></a></li>
            <li><a href="about.html"><button>About</button></a></li>
            <li><a href="insert.php"><button>Add to Existing Scrapbook</button></a></li>
            <li><button onclick="openCity(event, 'DEScrap')" class="tablinks">Delete from Existing Scrapbook</button></li>
            <li><button onclick="openCity(event, 'CScrap')" class="tablinks">Create Scrapbook</button></li>
            <li><button onclick="openCity(event, 'DScrap')" class="tablinks">Delete Scrapbook</button></li>
        </ul>
        <div id="CScrap" class="tabcontent">
            <h3>Create Scrapbook</h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <input type="text" name="scrapbook" placeholder="scrapbook name" required><br>
                Scrapbook Background Color: 
                <input type="text" name="backColor" value="rosybrown" required>
                Scrapbook Caption Color:
                <input type="text" name="captColor" value="lightyellow" required><br>
                Border Type:
                <input type="text" name="bordType" value="dashed" required>
                Border Color:
                <input type="text" name="bordColor" value="black" required><br>
                <input type="submit" name="submit" value="Create Scrapbook!">
            </form>
        </div>
        <div id="DScrap" class="tabcontent">
            <h3>Delete Scrapbook</h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <input type="text" name="scrapbook" placeholder="scrapbook name" required><br>
                <input type="submit" name="submit" value="Delete Scrapbook!">
            </form>
        </div>
        <div id="DEScrap" class="tabcontent">
            <h3>Delete from Existing Scrapbook</h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <input type="text" name="scrapbook" placeholder="scrapbook name" required><br>
                Picture Title: <br>
                <input type="text" name="title" placeholder="Picture Title" required><br>
                <input type="submit" name="submit" value="Delete Picture!">   
            </form>
        </div>
        <script>
            function openCity(evt, tabName) {
                // Declare all variables
                var i, tabcontent, tablinks;

                // Get all elements with class="tabcontent" and hide them
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Get all elements with class="tablinks" and remove the class "active"
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Show the current tab, and add an "active" class to the button that opened the tab
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";
            } 
        </script>
    </body>
</html>