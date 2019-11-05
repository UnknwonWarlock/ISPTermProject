<!DOCTYPE html>
<html>
    <head>
        <!--
            baseStyle.css is for personal formatting while dropzone.js and dropzone.css is an open source easy to manage drag and drop 
            functionality package
        -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/styles/baseStyle.css">
        <link rel="stylesheet" type="text/css" href="assets/styles/homeStyle.css">
        <link rel="stylesheet" type="text/css" href="assets/dist/dropzone.css">
        <script src="assets/js/dropzone.js"></script>
    </head>
    <body>
        <header style="text-align: left"><a class="home" href="home.php">DigiScrap</a>: A Place for Scrap Bookers!</header>
        <ul>
            <li><a class="active" href="#">Login</a></li>
            <li><a href="about.html">About</a></li>
        </ul>
        <div class="gridWrapper">
            <div class="column">
                <form id="scrapbookForm" method="POST" enctype="multipart/form-data">
                    <!-- make input for user readonly after testing -->
                    <input type="text" name="user" id="scrapbook" placeholder="Username">
                    <input type="text" name="scrapbook" id="scrapbook" placeholder="Scrapbook Name" required>
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
    </body>
</html>