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
        <input type="text" id="cover" class="textbox" name="backColor" value="green" onkeyup="validateC('cover', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>
        <input type="text" id="paper" class="textbox" name="captColor" value="lightyellow" onkeyup="validateC('paper', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>
        <input type="text" id="rings" class="textbox" name="bordType" value="black" onkeyup="validateC('rings', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>
        <input type="text" id="textColor" class="textbox" name="bordColor" value="black" onkeyup="validateC('textColor', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>              
        <canvas id="test"></canvas>
        <script>
            set(1200, 600, "test");
            create("test", "cover", "paper", "rings", "textColor");
        </script>
    </body>
</html>