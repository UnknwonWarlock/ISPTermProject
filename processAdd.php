<!DOCTYPE html>
<html>


    <?php
        /**
         * For easy configuration, I've added these global variables
         * **NOTE**
         * For some reason, php has trouble creating directories.
         * Make a directory in the same directory as this script called "uploadedFiles"
         * and set the permissions to 777
         */
        $MySQL_db = "db1.cs.uakron.edu:3306"; 
        $MySQL_username = "mcr66";
        $MySQL_password = "ohl5eiB0";

        /**
         * Copy uploaded file to a permanent location
         */
        $user = $_POST["user"];
        $scrapbook = $_POST["scrapbook"];
        $title = $_POST["title"];
        $file = $_FILES['file'];
        $caption = $_POST["caption"];

        // File is written to the following directory
        // "./uploadedFiles/<user>-<scrapbook>-<fileName>"
        if(!file_exists(getcwd() . "/uploadedFiles")) {

            mkdir(getcwd() . "/uploadedFiles", 0777, true);
        }
        $filepath = "/uploadedFiles/" . $user . "-" . $scrapbook . "-" . $file["name"];

        // Move uploaded file to permanent location
        $success = ($file['error'] == 0 && move_uploaded_file($file['tmp_name'], getcwd() . $filepath));
        if(!$success) {

            print "Failed to upload file";
            exit;
        }

        /**
         * Save copy of file record in MySQL database
         */
        // Connect to MySQL database,
        // Replace with <database URI>, <username>, <password>
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

        // Create insert query string for newly uploaded file
        $uriprefix = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/"));
        $fileuri = $uriprefix . $filepath;

        // Create insert query string for newly uploaded file
        $query = "INSERT INTO scrapbook_user VALUES ("
            . "'" . $user           . "', "
            . "'" . $scrapbook      . "', "
            . "'" . $title          . "', "
            . "'" . $file["name"]   . "', "
            . "'" . $filepath       . "', "
            . "'" . $caption        . "'"
        . ");";
        trim($query);

        // Send SQL command to MySQL
        if (!mysqli_query($db, $query)) {

            print "Error - the query could not be executed";
            exit;
        }

        /**
         * If everything was successful,
         * print the permanent location of the uploaded file
         */
        print $fileuri;
    ?>
</html>