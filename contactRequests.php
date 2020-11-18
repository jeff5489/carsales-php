<?php session_start(); ?>


<?php require('include/header.php'); ?>

<?php

    $requestId = $_POST['requestId'];

    if(isset($_POST['functionToBeCalled'])){
        $functionToBeCalled = $_POST['functionToBeCalled'];
        switch ($functionToBeCalled) {
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
<div class="container bg-light">

    <?php require('include/navbar.php'); 
        require('include/commonFunctions.php');
        restrictAllButEmployees();
    ?>

    <div class="row border d-flex justify-content-center">
        <h1>Contact Requests</h1>
    </div>

    <div class="row border">

        
        <div class="col border">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <h3>View Contact Request</h3>
                <!-- <label>View Contact Request</label><br> -->
                <input type="hidden" name="functionToBeCalled" value="viewContactRequests">
                <input type="submit" name="submit" value="View">
                <input type="submit" name="functionToBeCalled" value="Hide Requests">

                <table class="table">
                    <tr class="thead-dark">
                        <th>Request Id </th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone #</th>
                        <th>Email</th>
                        <th>Contact In Morning</th>
                        <th>Contact In Afternoon</th>
                        <th>Contact In Evening</th>
                        <th>Message</th>
                    </tr>

                <?php

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "Id: " . $row["id"]. " First Name: " . $row["firstName"] . " Last Name: " . $row["lastName"] 
                            . " Phone Number: " . $row["phoneNumber"] . " Email Address: " . $row["emailAddress"] . " MessageContent: " . 
                            $row["messageContent"] . "<br>";
                    ?>

                <tr>
                    <?php ob_start(); ?>
                    <td><?php echo $row["id"] ?></td>
                    <td><?php echo $row["firstName"] ?></td>
                    <td><?php echo $row["lastName"] ?></td>
                    <td><?php echo $row["phoneNumber"] ?></td>
                    <td><?php echo $row["emailAddress"] ?></td>
                    <td><?php echo $row["contactInMorning"] ?></td>
                    <td><?php echo $row["contactInAfternoon"] ?></td>
                    <td><?php echo $row["contactInEvening"] ?></td>
                    <td><?php echo $row["messageContent"] ?></td>
                </tr>

                <?php
                    }
                    } else {
                        // echo "0 results";
                    }

                ?>
                </table>
                <input type="submit" name="functionToBeCalled" value="Hide Requests">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <label><h3>Delete Contact Request</h3></label><br>

                <label>Request Id</label><br>
                <input type="text" name="requestId" value=""><br>

                <input type="hidden" name="functionToBeCalled" value="deleteRequest">
                <input type="submit" name="submit" value="Delete">
            </form>
        </div>
    </div>

</div>