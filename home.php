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

        if($_POST['submit'] == "Select Scrapbook!")
        {
            $_SESSION["scrapbook"] = $_POST['scrapbook'];
        }
        
        else if($_POST["submit"] == "Create Scrapbook!")
        {
            $query = 'SELECT * FROM ' . $_SESSION["username"] . ' WHERE scrapbook="' . $_POST['scrapbook'] . '"';
            trim($query);
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) == 0)
            {

                $settings = $_POST['backColor'] . "/" . $_POST['captColor'] . "/" . $_POST['bordType'] . "/" . $_POST['bordColor'];
                $query2 = "INSERT INTO " . $_SESSION['username'] . " VALUES('" . $_POST['scrapbook'] . "', '" . $settings . "');";
                trim($query2);
                mysqli_query($db,$query2);

                $query3 = "CREATE TABLE " . $_SESSION['username'] . "_" . $_POST['scrapbook'] 
                    . "(title TEXT, " .
                    "image_name TEXT, " .
                    "image_path TEXT, " .
                    "caption TEXT);";
                trim($query3);
                mysqli_query($db, $query3);

                $query4 = "SELECT scrapbook FROM ". $_SESSION['username'];
                $result2 = mysqli_query($db, $query4);
                if( mysqli_num_rows($result2) > 0 )
                {
                    $row = mysqli_fetch_array($result2);
                    $_SESSION['scrapbook'] = $row['scrapbook'];
                }
            }
        }
        elseif($_POST["submit"] == "Delete Scrapbook!")
        {
            $query = 'SELECT * FROM ' . $_SESSION["username"] . ' WHERE scrapbook="' . $_POST['scrapbook'] . '"';
            trim($query);
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) > 0)
            {
                $query2 = 'DELETE FROM ' . $_SESSION["username"] . ' WHERE scrapbook="' . $_POST['scrapbook'] . '"';
                trim($query2);
                mysqli_query($db,$query2);

                $query4 = 'SELECT image_path FROM ' . $_SESSION["username"] . "_" . $_SESSION["scrapbook"] . ';';
                trim($query4);
                $result2 = mysqli_query($db, $query4);
                while($row = mysqli_fetch_array($result2))
                {
                    if(file_exists(realpath(getcwd() . $row["image_path"])))
                    {
                        unlink(realpath(getcwd() . $row["image_path"]));
                    }
                }

                $query3 = "DROP TABLE " . $_SESSION["username"] . "_" . $_POST['scrapbook'] . ";";
                mysqli_query($db,$query3);
                unset($_SESSION['scrapbook']);
            }
        }
        else if($_POST["submit"] == "Delete Picture!")
        {
            $query = 'SELECT image_path FROM ' . $_SESSION["username"] . "_" . $_SESSION["scrapbook"] . ' WHERE title="' . $_POST["title"] . '";';
            trim($query);
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_array($result);
            if(file_exists(realpath(getcwd() . $row["image_path"])))
            {
                unlink(realpath(getcwd() . $row["image_path"]));
                $query = 'DELETE FROM ' . $_SESSION["username"] . "_" . $_SESSION["scrapbook"] . ' WHERE title="' . $_POST["title"] . '"';
                trim($query);
                mysqli_query($db, $query);
            }
        }
        
        $scrapbooks = "";
        $result = mysqli_query($db, 'SELECT scrapbook FROM ' . $_SESSION["username"]);
        while($row = mysqli_fetch_array($result)){
            $scrapbooks .= "<option value='" . $row['scrapbook'] . "'>" . $row['scrapbook'] . "</option>";
        }

        $query = 'SELECT title FROM ' . $_SESSION["username"] . '_' . $_SESSION["scrapbook"];
        $result2 = mysqli_query( $db, $query);
        if( mysqli_num_rows($result2) > 0 ){
            while($row2 = mysqli_fetch_array($result2)){
                $imageTitles .= "<option value='" . $row2['title'] . "'>" . $row2['title'] . "</option>";
            }
        }
    ?>

    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/styles/baseStyle.css">
        <link rel="stylesheet" type="text/css" href="assets/dist/dropzone.css">
        <script src="assets/js/dropzone.js"></script>
        <script src="assets/js/create.js"></script>
    </head>
    <body>
        <header>
            <a class="home" href="home.php">DigiScrap</a>: A Place for Scrap Bookers! Welcome <?php echo $_SESSION['username'] ?>! 
        </header>
        <ul>
            <li><button><a href="login.php">Logout</a></button></li>
            <li><button onclick="openTab(event, 'About')" class="tablinks">About</button></li>
            <li><button onclick="openTab(event, 'Help')" class="tablinks">Help</button></li>
            <li><button onclick="openTab(event, 'scrapSelect')" class="tablinks">Select Working Scrapbook</button></li>
            <li><button onclick="openTab(event, 'AEScrap')" class="tablinks">Add to Scrapbook</button></li>
            <li><button onclick="openTab(event, 'DEScrap')" class="tablinks">Delete from Scrapbook</button></li>
            <li><button onclick="openTab(event, 'CScrap')" class="tablinks">Create Scrapbook</button></li>
            <li><button onclick="openTab(event, 'DScrap')" class="tablinks">Delete Scrapbook</button></li>
            <li><button><a href="display.php">Display Scrapbook</a></button></li>     
        </ul>
        <div id="scrapSelect" class="tabcontent">
            <h3><u>Select Current Scrapbook</u></h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <select name="scrapbook" id="scrapbook" style="width: 25%;">
                <?php
                    echo $scrapbooks;
                ?>
                </select><br><br>
                <input type="submit" name="submit" id="button2" value="Select Scrapbook!">
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
        <div id="Help" class="tabcontent">
            <h3><u>Help</u></h3>
            <p>
                <b><u>Blank Drop Down Menus?</u></b>:
            </p>
            <p  style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                <b><u>In Select Working Scrapbook Tab?</u></b>:
                <br> Make sure you actually have created a scrapbook in the <u><i>Create Scrapbook</i></u> tab first. <br>
                <b><u>In Delete Picture Tab?</u></b>:
                <br>
                    Did you put any pictures inside the scrapbook you are working on or is the working scrapbook the one you want to work on?
                    This can be be checked in the <u><i>Select Working Scrapbook</i></u> Tab.
                <br>
            </p>
            <p>
                <b><u>Can not change the scrapbook input?</u></b>:
            </p>
            <p  style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                <u><i>Scrapbook Name</i></u> input tabs are handled by the <u><i>Select Working Scrapbook</i></u> tab and that will change the value of these
                inputs. One of your scrapbooks will be selected automatically when you login if you have a scrapbook or when you first
                create a scrapbook in the <u><i>Create Scrapbook</i></u> tab. If this is blank then it means you have no scrapbook therefore
                you will have to create one before this gets a result.
            </p>
            <p>
                <b><u>Adding Pictures?</u></b>:
            </p>
            <p  style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                When adding a picture into a scrapbook inside the <u><i>Add to Scrapbook</i></u> tab make sure you have the correct 
                scrapbook selected that you want to add to. If any of the fields are invalid you will get an alert pop up for every field invalid
                but this is a prototype and this method is subject to change. This prototype only handles files 10mb or under and the size
                can be checked by hovering over the photo with your cursor (although we do not think a photo file is commonly over 10mb).
                Please make sure that the photos added are actually a common photo type of picture or later displaying of the scrapbook could
                be off.
            </p>
            <p>
                <b><u>Other Help or Bugs to Report?</u></b>:
            </p>
            <p  style="margin: 1px 50px 25px 50px; line-height: 1.5;">
                This is an ongoing work in progress application and there are definitely bugs that can still occur in this prototype.
                If you require any help, want to report a bug, or even want to recommend a feature you can contact us at the provided
                email below and we will get back to you at our earliest convenience: <br>
                <u>digiscraphelpline@gmail.com</u>
            </p>
        </div>
        <div id="CScrap" class="tabcontent">
            <h3><u>Create Scrapbook</u></h3>
            <form method="POST" action="home.php">
                <div class="gridWrapper">
                    <div class="column">
                        Scrapbook Name: <br>
                        <input type="text" id="textbox" class="textbox" style="width: 40%;" name="scrapbook" placeholder="scrapbook name" required><br><br>
                        <input type="submit" id="button2" style="width: 40%;" name="submit" value="Create Scrapbook!">
                    </div>
                    <div class="column">
                        Scrapbook Cover Color: <br>
                        <input type="text" id="cover" class="textbox" name="backColor" value="pink" onkeyup="validateC('cover', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>
                        Scrapbook Paper Color:<br>
                        <input type="text" id="paper" class="textbox" name="captColor" value="lightyellow" onkeyup="validateC('paper', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>
                    </div>
                    <div class="column">
                        Ring Color:<br>
                        <input type="text" id="rings" class="textbox" name="bordType" value="black" onkeyup="validateC('rings', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br>
                        Text Color:<br>
                        <input type="text" id="textColor" class="textbox" name="bordColor" value="black" onkeyup="validateC('textColor', 'test', 'cover', 'paper', 'rings', 'textColor')" required><br><br>
                    </div>
                    <div class="column">
                    </div>
                </div>
                <div class="gridWrapper">
                    <div class="column">
                    </div>
                    <div class="column">
                        <canvas id="test"></canvas>
                        <script>
                            set(600, 300, "test");
                            create("test", "cover", "paper", "rings", "textColor");
                        </script>
                    </div>
                    <div class="column">
                    </div>
                </div>
            </form>
        </div>
        <div id="AEScrap" class="tabcontent">
        <div class="gridWrapper">
            <div class="column">
                <form id="scrapbookForm" method="POST" enctype="multipart/form-data">
                    <!-- make input for user readonly after testing -->
                    Scrapbook:<br>
                    <input name="scrapbook" id="scrapbook" value="<?php echo $_SESSION['scrapbook']; ?>" readonly><br><br>
                </form>
            </div>
            <div class="column" id="insertCol" style="border: 2px dashed black;">
                <!--
                    the dropzone class gives us the dropzone.js drag and drop form with an id for custom options to be enabled
                    WARNING: the action must not be changed
                -->
                <form action="processAdd.php" class="dropzone" id="my-awesome-dropzone" method="POST" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Enter a Title!" id="picTitle" onkeyup="words('secret', 'picTitle', 'title')" required>
                </form>
                <form id="captionForm" method="POST" style="border: none" enctype="multipart/form-data">
                    <textarea cols="280" type="text" name="caption" id="picCaption" onkeyup="words('secret', 'picCaption', 'cap')">Enter a Caption!</textarea><br><br>
                    <input type="button" name="submit" value="Add" class="submit" id="button">
                </form>
                <canvas id="secret"></canvas>
                <!--
                    This script allows me to change some of base options for the drag and drop form
                    such as one file at a time and remove and replace the old file with a new one, a diffent initial display message
                    and the size of the picture (have to override the dropzone.css too)
                -->
                <script>
                    set(1,1, "secret");
                    function words(canv, words, type)
                    {
                        var check = testWords(canv, words, type);
                        if(check === false && type === "cap")
                        {
                            prompt("Too many words in Caption!");   
                        }
                        else if(check === false && type === "titles")
                        {
                            prompt("Too many words in Title");
                        }
                    }

                    document.getElementById("button").style.cursor = "pointer";

                    Dropzone.options.myAwesomeDropzone = {
                        paramName: "file",
                        maxFiles: 1,
                        maxfilesexceeded: function(file) 
                        {
                            this.removeAllFiles();
                            this.addFile(file);
                        },
                        dictDefaultMessage: "Drag and Drop Image",
                        thumbnailWidth: 500,
                        thumbnailHeight: 500,
                        autoProcessQueue: false,
                        url: 'processAdd.php',
                        init: function () {
                            var myDropzone = this;

                            // Update selector to match your button
                            $("#button").click(function (e) {
                                e.preventDefault();
                                myDropzone.processQueue();
                            });

                            this.on('sending', function(file, xhr, formData) {
                                // Append all form inputs to the formData Dropzone will POST
                                var data = $('#myAwesomeDropzone').serializeArray();
                                $.each(data, function(key, el) {
                                    if(el.value)
                                    {
                                        formData.append(el.name, el.value);
                                    }
                                    else
                                    {
                                        alert("Please Insert a Picture!");
                                    }
                                });

                                var data2 = $('#captionForm').serializeArray();
                                $.each(data2, function(key, el) {
                                    if(el.value !== "Enter a Caption!")
                                    {
                                        formData.append(el.name, el.value);
                                    }
                                    else
                                    {
                                        alert("Please enter a real caption!");
                                    }
                                });
                    
                                var data3 = $('#scrapbookForm').serializeArray();
                                $.each(data3, function(key, el) {
                                    if(el.value)
                                    {
                                        formData.append(el.name, el.value);
                                    }
                                });
                            });

                            this.on("complete", function (file) {
                                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                    document.getElementById("scrapbookForm").submit();
                                }
                            });
                        }
                    }
                </script>
                <!--
                    override for dropzone.css styles so that the thumbnail size is increased and that the error mark and success mark
                    is not displayed blocking the picture.
                -->
                <style>
                    .dropzone .dz-preview .dz-image 
                    {
                        width: 500px;
                        height: 500px;
                    }
                    .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg 
                    {
                        display: none;
                    }
                    .dz-preview.dz-image-preview{
                        border-radius: 25px !important;
                    }
                </style>
            </div>
            <div class="column"></div>
        </div>
        </div>
        <div id="DScrap" class="tabcontent">
            <h3><u>Delete Scrapbook</u></h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <input name="scrapbook" id="textbox" class="textbox" value="<?php echo $_SESSION['scrapbook']; ?>" readonly><br><br>
                <input type="submit" id="button2" name="submit" value="Delete Scrapbook!">
            </form>
        </div>
        <div id="DEScrap" class="tabcontent">
            <h3><u>Delete from Existing Scrapbook</u></h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <input name="scrapbook" id="textbox" class="textbox" value="<?php echo $_SESSION['scrapbook']; ?>" readonly><br>
                Picture Title:<br>
                <select name="title" id="textbox" class="textbox">
                <?php
                    echo $imageTitles;
                ?>
                </select><br><br>
                <input type="submit" name="submit" id="button2" value="Delete Picture!">   
            </form>
        </div>
        <script>
            document.getElementsByClassName('tablinks')[2].click()
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
<?php
    mysqli_close($db);
?>

