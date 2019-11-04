<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/homeStyle.css">
    </head>
    <body>
        <header><a class="home" href="home.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><a class="active" href="#">Login</a></li>
            <li><a href="about.html">About</a></li>
        </ul>
        <form class="login" action="main.php" method="POST"> 
            Please enter your username and password!<br>
            <input type="text" name="user" placeholder="Username" required><br>
            <input type="password" name="pass" placeholder="Password" required><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>