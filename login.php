<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/homeStyle.css">
    </head>
    <body>
        <header><a class="home" href="login.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><a class="active" href="#">Login</a></li>
            <li><a href="about.html">About</a></li>
        </ul>        
        <?php
            session_start();
            if( isset( $_POST["submit"] ))
            {
                
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
                
                switch( $_POST["submit"] )
                {
                    case "Log in":
                        $query = "SELECT * FROM Users WHERE " .
                        "Username='" . $_POST['user'] . "' " .
                        "AND Pass='" . $_POST['pass'] . "'";
                        $result = mysqli_query($db, $query);
                        mysqli_close($db);
                        if( mysqli_num_rows($result) > 0 )
                        {
                            $_SESSION['username'] = $_POST['user'];
                            header("Location: home.php");
                        }
                        break;
                    case "Register":
                        $query = "insert into Users values ( '" . 
                        $_POST['user'] . "', '" .
                        $_POST['pass'] . "' )";
                        mysqli_query($db, $query);
                        $_SESSION['username'] = $_POST['user'];
                        mysqli_close($db);
                        header("Location: home.php");
                }
            }
        ?>
        <form class="login" action="login.php" method="POST"> 
            Please enter your username and password!<br>
            <input type="text" name="user" placeholder="Username" required><br>
            <input type="password" name="pass" placeholder="Password" required><br>
            <?php
                if( isset( $_POST["submit"] ) )
                {
                    print '<span style = "color:red">invalid username or password</span><br>';
                }
            ?>
            <input type="submit" name="submit" value="Log in"><input type = "submit" name = "submit" value = "Register">
        </form>
    </body>
</html>