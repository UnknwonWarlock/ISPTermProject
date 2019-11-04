<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
    </head>
    <body>
        <?php
            print "<header><a class='home' href='home.php'>DigiScrap</a>: A Place for Scrap Bookers! " . "Welcome " . $_POST['user'] . "!</header>";
        ?>
        <ul>
            <li><a href="login.php"><button>Login</button></a></li>
            <li><a href="about.html"><button>About</button></a></li>
            <li><button onclick="openCity(event, 'AEScrap')">Add to Existing Scrapbook</button></li>
            <li><button onclick="openCity(event, 'DEScrap')">Delete from Existing Scrapbook</button></li>
            <li><button onclick="openCity(event, 'CScrap')">Create Scrapbook</button></li>
            <li><button onclick="openCity(event, 'DScrap')">Delete Scrapbook</button></li>
        </ul>
        <div id="CScrap" class="tabcontent">
            <h3>Create Scrapbook</h3>
            <form method="POST" action="">
                Username: <br>
                <?php
                    print "<input type='text' name='user' value='" . $_POST['user'] . "' readonly><br>";
                ?>
                Scrapbook Name: <br>
                <input type="text" name="scrapbook" placeholder="scrapbook name" required><br>
                <input type="submit" name="submit" value="Create!">
            </form>
        </div>
        <div id="DScrap" class="tabcontent">
            <h3>Delete Scrapbook</h3>
            <form method="POST" action="">
                Username: <br>
                <?php
                    print "<input type='text' name='user' value='" . $_POST['user'] . "' readonly><br>";
                ?>
                Scrapbook Name: <br>
                <input type="text" name="scrapbook" placeholder="scrapbook name" required><br>
                <input type="submit" name="submit" value="Delete!">
            </form>
        </div>
        <div id="AEScrap" class="tabcontent">
            <h3>Add to Existing Scrapbook</h3>
            <form method="POST" action="insert.php">
                Username: <br>
                <?php
                    print "<input type='text' name='user' value='" . $_POST['user'] . "' readonly><br>";
                ?>
                <input type="submit" name="submit" value="Go to Customize Page!">
            </form>
        </div>
        <div id="DEScrap" class="tabcontent">
            <h3>Delete from Existing Scrapbook</h3>
            <form method="POST" action="">
                Username: <br>
                <?php
                    print "<input type='text' name='user' value='" . $_POST['user'] . "' readonly><br>";
                ?>
                Scrapbook Name: <br>
                <input type="text" name="scrapbook" placeholder="scrapbook name" required><br>
                Picture Title: <br>
                <input type="text" name="title" placeholder="Picture Title" required><br>
                <input type="submit" name="submit" value="Delete!">   
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