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

            $query3 = "DROP TABLE " . $_SESSION["username"] . "_" . $_POST['scrapbook'] . ";";
            mysqli_query($db,$query3);
            unset($_SESSION['scrapbook']);
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

<!DOCTYPE html>
<html>
    <head>
        <title>DigiScrap: Digital Scrap Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/styles/baseStyle.css">
        <link rel="stylesheet" type="text/css" href="assets/styles/tabStyle.css">
        <link rel="stylesheet" type="text/css" href="assets/dist/dropzone.css">
        <script src="assets/js/dropzone.js"></script>
    </head>
    <body>
        <header>
            <a class = "home" href = "home.php">DigiScrap</a>: A Place for Scrap Bookers! Welcome <?php echo $_SESSION['username'] ?>! 
        </header>
        <ul>
            <li><button><a href="login.php">Logout</a></button></li>
            <li><button onclick="openTab(event, 'scrapSelect')" class="tablinks")>Scrapbook</button></li>
            <li><button onclick="openTab(event, 'AEScrap')" class="tablinks">Add to Existing Scrapbook</button></li>
            <li><button onclick="openTab(event, 'DEScrap')" class="tablinks">Delete from Existing Scrapbook</button></li>
            <li><button onclick="openTab(event, 'CScrap')" class="tablinks">Create Scrapbook</button></li>
            <li><button onclick="openTab(event, 'DScrap')" class="tablinks">Delete Scrapbook</button></li>
                
        </ul>
        <div id="scrapSelect" class="tabcontent">
            <h3><u>Select Current Scrapbook</u></h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <select name="scrapbook" id="scrapbook" style="width: 25%;">
                <?php
                    echo $scrapbooks;
                ?>
                </select><br>
                <input type="submit" name="submit" value="Select Scrapbook!">
            </form>
        </div>
        <div id="CScrap" class="tabcontent">
            <h3><u>Create Scrapbook</u></h3>
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
        <div id="AEScrap" class="tabcontent">
        <div class="gridWrapper">
            <div class="column">
                <form id="scrapbookForm" method="POST" enctype="multipart/form-data">
                    <!-- make input for user readonly after testing -->
                    Scrapbook:<br>
                    <input name="scrapbook" id="scrapbook" value="<?php echo $_SESSION['scrapbook']; ?>"readonly><br><br>
                </form>
            </div>
            <div class="column" id="insertCol" style="border: 2px dashed black;">
                <!--
                    the dropzone class gives us the dropzone.js drag and drop form with an id for custom options to be enabled
                    WARNING: the action must not be changed
                -->
                <form action="processAdd.php" class="dropzone" id="my-awesome-dropzone" method="POST" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Enter a Title!" id="picTitle" required>
                </form>
                <form id="captionForm" method="POST" style="border: none" enctype="multipart/form-data">
                    <textarea cols="280" type="text" name="caption" id="picCaption">Enter a Caption!</textarea><br><br>
                    <input type="button" name="submit" value="Add" class="submit" id="button">
                </form>

                <!--
                    This script allows me to change some of base options for the drag and drop form
                    such as one file at a time and remove and replace the old file with a new one, a diffent initial display message
                    and the size of the picture (have to override the dropzone.css too)
                -->
                <script>
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
                                location.reload();
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
                                    else
                                    {
                                        alert("Please have a correct username or scrapbook name");
                                    }
                                });
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
                <input name="scrapbook" value="<?php echo $_SESSION['scrapbook']; ?>"readonly>
                <input type="submit" name="submit" value="Delete Scrapbook!">
            </form>
        </div>
        <div id="DEScrap" class="tabcontent">
            <h3><u>Delete from Existing Scrapbook</u></h3>
            <form method="POST" action="home.php">
                Scrapbook Name: <br>
                <input name="scrapbook" value="<?php echo $_SESSION['scrapbook']; ?>"readonly>
                Picture Title: <br>
                <select name="title">
                <?php
                    echo $imageTitles;
                ?>
                </select><br>
                <input type="submit" name="submit" value="Delete Picture!">   
            </form>
        </div>
        <script>
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

