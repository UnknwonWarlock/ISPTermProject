<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Display</title>
        <script src="assets/js/create.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
    </head>
    <body>
        <header><a class="home" href="login.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><button><a href="login.php">Logout</a></button></li>
            <li><button><a href="home.php">Home</a></button></li>
            <li><button onclick="openTab(event, 'About')" class="tablinks">About</button></li>
            <li><button onclick="openTab(event, 'Help')" class="tablinks">Help</button></li>
        </ul>        
        <canvas id="test">

        </canvas>
        <script>
        </script>
    </body>
</html>