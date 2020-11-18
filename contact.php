<?php require('include/header.php'); ?>

<?php

$requestId = $_POST['requestId'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$emailAddress = $_POST['emailAddress'];
$messageContent = $_POST['messageContent'];
$contactInMorning = $_POST['contactInMorning'];
$contactInAfternoon = $_POST['contactInAfternoon'];
$contactInEvening = $_POST['contactInEvening'];


$inventoryId = $_GET['inventoryId'];
$vin = $_GET['vin'];
$make = $_GET['make'];
$model = $_GET['model'];

if(isset($_POST['functionToBeCalled'])){
    $functionToBeCalled = $_POST['functionToBeCalled'];
    switch ($functionToBeCalled) {
        case "submitContactForm":
            submitContactForm($firstName, $lastName, $phoneNumber, $emailAddress, $messageContent, $contactInMorning, 
            $contactInAfternoon, $contactInEvening);
            break;
        case "viewContactRequests":
            $result = viewContactRequests();
            break;
        case "Hide Requests":
            ob_end_clean();
            break;
        case "deleteRequest":
            deleteRequest($requestId);
            break;
    }
}   

function submitContactForm($firstName, $lastName, $phoneNumber, $emailAddress, $messageContent, $contactInMorning, 
$contactInAfternoon, $contactInEvening){
    
    $sql = "INSERT INTO contactRequests(firstName, lastName, phoneNumber, emailAddress, messageContent, contactInMorning, 
    contactInAfternoon, contactInEvening)                                                   
    VALUES('$firstName', '$lastName', '$phoneNumber', '$emailAddress', '$messageContent', '$contactInMorning', 
    '$contactInAfternoon', '$contactInEvening')";
    
    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }  
}

function viewContactRequests(){
$conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
$sql = "SELECT * FROM contactRequests ORDER BY id asc";
$result = $conn->query($sql);

return $result;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Id: " . $row["id"]. " First Name: " . $row["firstName"] . " Last Name: " . $row["lastName"] 
            . " Phone Number: " . $row["phoneNumber"] . " Email Address: " . $row["emailAddress"] . " MessageContent: " . 
            $row["messageContent"] . "<br>";
    }
    } else {
        echo "0 results";
    }
}

function deleteRequest($requestId){
    if(isset($_POST['requestId'])){
        $sql = "Delete from contactRequests where id = '$requestId' ";  
        $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully<br>";
            echo $requestId;
        } else {
            echo "Error deleting record: " . $conn->error;
        }

    } 	else {
        echo "Can't access customer id";
    }
}

?>

<div class="container border bg-light">

    <?php require('include/navbar.php'); ?>
    <?php 
        if($_SESSION['user_level'] == "admin"){
            echo "Logged in as: admin";
        } elseif ($_SESSION['user_level'] == "sales associate"){
            echo "Logged in as: sales associate";
        }
    ?>

    <div class="row border">
        <div class="col border d-flex justify-content-center">
            <h1>Contact Us</h1>
        </div>
    </div>

    <div class="row border">

        <div class="col border">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

            <?php
                $inventoryId = $_GET['inventoryId'];
                $inventoryId = str_replace("<br>", "", $inventoryId);
                $vin = $_GET['vin'];
                $vin = str_replace("<br>", "", $vin);
                $make = $_GET['make'];
                $make = str_replace("<br>", "", $make);
                $model = $_GET['model'];
                $model = str_replace("<br>", "", $model)
            ?>
                <label>First Name</label><br>
                <input type="text" name="firstName" value=""><br>
                <label>Last Name</label><br>
                <input type="text" name="lastName" value=""><br>
                <label>Phone Number</label><br>
                <input type="text" name="phoneNumber" value=""><br>
                <label>Email Address</label><br>
                <input type="text" name="emailAddress" value=""><br>
                <label>Car Id #</label><br>
                <input type="text" name="emailAddress" value="<?php echo $inventoryId; ?>"><br>
                <label>Make</label><br>
                <input type="text" name="emailAddress" value="<?php echo $make; ?>"><br>
                <label>Model</label><br>
                <input type="text" name="emailAddress" value="<?php echo $model; ?>"><br>
                <label>Message</label><br>
                <textarea name="messageContent" id="" cols="60" rows="10" value=""></textarea><br>

                <p>When do you want to be contacted?</p>
                <input type="checkbox" id="" name="contactInMorning" value="YES">
                <label for="">Morning</label><br>
                <input type="checkbox" id="" name="contactInAfternoon" value="YES">
                <label for="">Afternoon</label><br>
                <input type="checkbox" id="" name="contactInEvening" value="YES">
                <label for="">Evening</label><br><br>

                <input type="hidden" name="functionToBeCalled" value="submitContactForm">
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    
    </div>

    

</div>
