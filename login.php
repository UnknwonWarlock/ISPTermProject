<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Login</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/homeStyle.css">
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
    </head>
    <body>
        <header><a class="home" href="login.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><button onclick="openTab(event, 'login')" class="tablinks">Login</button></li>
            <li><button onclick="openTab(event, 'About')" class="tablinks">About</button></li>
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
                        "AND Pass='" . $_POST['pass'] . "';";
                        $result = mysqli_query($db, $query);
                        if( mysqli_num_rows($result) > 0 )
                        {
                            $_SESSION['username'] = $_POST['user'];
                            $query2 = "SELECT scrapbook FROM " . $_POST['user'];
                            $result2 = mysqli_query($db, $query2);
                            if( mysqli_num_rows($result2) > 0 )
                            {
                                $row = mysqli_fetch_array($result2);
                                $_SESSION['scrapbook'] = $row['scrapbook'];
                            }
                            header("Location: home.php");
                        }
                        break;
                    case "Register":
                        $query = "SELECT * FROM Users WHERE " .
                        "Username='" . $_POST['user'] . "'";
                        $result = mysqli_query($db, $query);
                        if( mysqli_num_rows($result) > 0 )
                        {
                            mysqli_close($db);
                            break;
                        }
                        $query = "insert into Users values ( '" . 
                        $_POST['user'] . "', '" .
                        $_POST['pass'] . "' )";
                        mysqli_query($db, $query);
                        $_SESSION['username'] = $_POST['user'];
                        $query2 = "create table " . $_SESSION['username'] . "( scrapbook VARCHAR(30), cover VARCHAR(30), paper VARCHAR(30), rings VARCHAR(30), text VARCHAR(30) );";
                        trim($query2);
                        mysqli_query($db, $query2);
                        mysqli_close($db);
                        header("Location: home.php");
                }
            }
        ?>
        <div id="login" class="tabcontent">
            <form class="login" action="login.php" method="POST"> 
                Please enter your username and password!<br>
                <input type="text" name="user" id="textbox" placeholder="Username" required><br>
                <input type="password" name="pass" id="textbox" placeholder="Password" required><br><br>
                <?php
                    if( isset( $_POST["submit"] ) )
                    {
                        print '<span style = "color:red ">';
                        switch( $_POST["submit"] )
                        {
                            case "Log in":
                                print "Invalid username or password";
                                break;
                            case "Register":
                                print "Username already exists";
                        }
                        print '</span><br>';
                    }
                ?>
                <input type="submit" name="submit" id="button" value="Log in" style="border: 1px dashed black;"><input type="submit" name="submit" id="button" value="Register" style="border: 1px dashed black;">
            </form>
        </div>
        <div id="About" class="tabcontent" style="width: 50%;">
            <h3><u>About</u></h3>
            <p>
                <b><u>DigiScrap</u></b>:
            </p>
            <p style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                Is a digital scrapbook made as a group collaboration project
                for an interenet systems programming course term project at the University of Akron.
                It allows users to register and login to an account then make and delete scrapbooks, add personal settings,
                display the scrapbooks created, and continuously add and delete from scrapbooks.
            </p>
            <p>
                <b><u>Attention</u></b>:
            </p>
            <p style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                This product is in a prototype state and therefore we are not responsible for any private information put
                on this site. Therefore we recommend you only put information on here that will not risk yours or anyone else's
                safety.
            </p>
            <p>
                <b><u>Contributors</u></b>:
            </p>
            <p  style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                <b><u>dropzone.js</u></b>:<br> For the nice and intuitive drag and drop file implementation used in the adding feature <br>
                <b><u>Mason Roberts</u></b>:<br> Database table creations and management, File uploading and deleting, Adding images to a scrapbook,
                and general help with design features with the tabs and dropdown menu selectors. <br>
                <b><u>Bree Harris</u></b>:<br> Insert your contributions here Bree!<br>
            </p>
        </div>
        <script>
            document.getElementsByClassName('tablinks')[0].click()
            
            //inspired by w3Schools
            function openTab(evt, tabName) {
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