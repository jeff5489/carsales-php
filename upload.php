<?php session_start(); ?>
<?php require('include/header.php'); ?>

<?php
$carId = $_POST['carId'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}



// Check if file already exists
if (file_exists($target_file)) {
    // echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    // echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Insert photo info into DB
if(isset($target_file)){
    $sql = "INSERT INTO photos(carId, photoName) 
    VALUES('$carId', '$target_file')";
    
    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    if ($conn->query($sql) === TRUE) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 	else {
    echo "Can't access target file";
}

?>

<div class="container border bg-light">

    <?php require('include/navbar.php'); 
        require('include/commonFunctions.php');
        restrictAllButEmployees();
    ?>

    <div class="row border">
        <div class="col d-flex justify-content-center">
            <h1>Upload Photo</h1>
        </div>
    </div>
    <div class="row border">
        <div class="col border">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <p>Select image to upload</p> 
                <input type="file" name="fileToUpload" id="fileToUpload"><br><br>

                <label for="">Car Id associated with photo:</label><br>
                <input type="text" name="carId" id=""><br>
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </div>


</div>



<?php require('include/footer.php');?>