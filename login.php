<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/homeStyle.css">
    </head>
    <body>
        <header><a class = "home" href = "home.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><a class = "active" href = "#">Login</a></li>
            <li><a href = "aboute.html"</a>About</a></li>
        </ul>
        <?php
            if( isset( $_POST["submit"] ))
            {
                if(!$_POST['user']) 
                {
                    $error['user'] = "<p>Please supply your username.</p>\n";
                }
                if(!$_POST['pass']) 
                {
                    $error['pass'] = "<p>Please supply your password.</p>\n";
                }
            }
        ?>
        <form class = "login" action = "login.php" method = "POST"> Please enter your username and password!</br>
            <input type = "text" name = "user" placeholder = "Username"><br>
            <input type = "password" name = "pass" placeholder = "Password"><br>
            <input type = "submit" name = "submit"value = "Submit">
        </form>
    </body>
</html>