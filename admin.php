<?php session_start(); ?>


<?php //require('include/db.php'); ?>
<?php require('include/header.php'); ?>

<?php
$employeeId = $_POST['employeeId'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$positionTitle = $_POST['positionTitle'];
$userName = $_POST['userName'];
$password = $_POST['pass'];


if(isset($_POST['functionToBeCalled'])){
    $functionToBeCalled = $_POST['functionToBeCalled'];
    switch ($functionToBeCalled) {
        case "viewEmployees":
            $result = viewEmployees();
            break;
        case "Hide Employees":
            ob_end_clean();
            break;
        case "addEmployee":
            addEmployee($firstName, $lastName, $positionTitle);
            break;
        case "deleteEmployee":
            deleteEmployee($employeeId);
            break;
        case "editEmployee":
            editEmployee($employeeId, $firstName, $lastName, $positionTitle);
            break;
    }
}

function viewEmployees(){

    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    $sql = "SELECT * FROM employees ORDER BY id asc";
    $result = $conn->query($sql);

    return $result;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            ob_start(); 
            echo "Employee Id: " . $row["id"] . 
            " First Name: " . $row["firstName"] . 
            " Last Name: " . $row["lastName"] . 
            " Position Title: " . $row["positionTitle"] .
            " User Name: " . $row["userName"] . 
            " Password: " . $row["password"] . 

            "<br>";

        }
    } else {
        echo "0 results";
    }
}

function addEmployee($firstName, $lastName, $positionTitle){
    if(isset($_POST['firstName'])){
        $sql = "INSERT INTO employees(firstName, lastName, positionTitle, userName, pass) 
        VALUES('$firstName', '$lastName', '$positionTitle', '$userName', '$password')";
        
        $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } 	else {
        echo "Can't access customer id";
    }
    
}

function deleteEmployee($employeeId){
    if(isset($_POST['employeeId'])){
        $sql = "Delete from employees where id = '$employeeId' ";  
        $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

    } 	else {
        echo "Can't access customer id";
    }
}

function editEmployee($employeeId, $firstName, $lastName, $positionTitle){
    if(isset($_POST['employeeId'])){

        $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
        $sql = "UPDATE employees SET firstName='$firstName', lastName='$lastName', positionTitle='$positionTitle',
        userName = '$userName', pass = '$password'  
        where id = '$employeeId' "; 

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        

    } 	else {
        echo "Can't access customer id";
    }
}

?>

<div class="container border bg-light">

    <?php require('include/navbar.php'); 
    require('include/commonFunctions.php');
    restrictAllButAdmins();
    ?>

    <div class="row border d-flex justify-content-center">
        <h1>Manage Employees</h1>
    </div>

    <div class="row">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <label><h3>View Employees</h3></label><br>
            <input type="hidden" name="functionToBeCalled" value="viewEmployees">
            <input type="submit" name="submit" value="View Employees">
            <input type="submit" name="functionToBeCalled" value="Hide Employees">

            <table class="table">
                <tr class="thead-dark">
                    <th>Employee Id </th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>

            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {

            ?>

            <tr>
                <?php ob_start(); ?>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["firstName"] ?></td>
                <td><?php echo $row["lastName"] ?></td>
                <td><?php echo $row["positionTitle"] ?></td>
                <td><?php echo $row["userName"] ?></td>
                <td><?php echo $row["pass"] ?></td>
            </tr>

            <?php
                }
            } else {
                echo "0 results";
            }
            ?>

            </table>
            <input type="submit" name="functionToBeCalled" value="Hide Employees">
        </form>
        
    </div>

    <div class="row">

        <div class="col-4 border">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div>
                    <label><h3>Add Employee</h3></label><br>
                    <label>First Name</label><br>
                    <input type="text" name="firstName" value=""><br>

                    <label>Last Name</label><br>
                    <input type="text" name="lastName" value=""><br>

                    <div>
                        <label for="">Position Title</label><br>
                        <select name="positionTitle" id="">
                            <option name="" value="sales associate">Sales Associate</option>
                            <option name="" value="admin">Admin</option>
                        </select>
                    </div> 

                    <label>User Name: </label><br>
                    <input type="text" name="userName" value=""><br>

                    <label>Password: </label><br>
                    <input type="text" name="password" value=""><br>

                    <input type="hidden" name="functionToBeCalled" value="addEmployee">
                    <input type="submit" name="submit" value="Add">
                </div>
            </form>
        </div>

        <div class="col-4 border">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div>
                    <label><h3>Edit Employee</h3></label><br>

                    <label>Employee Id</label><br>
                    <input type="text" name="employeeId" value=""><br>

                    <label>First Name</label><br>
                    <input type="text" name="firstName" value=""><br>

                    <label>Last Name</label><br>
                    <input type="text" name="lastName" value=""><br>

                    <div>
                        <label for="">Position Title</label><br>
                        <select name="positionTitle" id="">
                            <option name="" value="sales associate">Sales Associate</option>
                            <option name="" value="admin">Admin</option>
                        </select>
                    </div> 

                    <label>User Name: </label><br>
                    <input type="text" name="userName" value=""><br>

                    <label>Password: </label><br>
                    <input type="text" name="password" value=""><br>

                    <input type="hidden" name="functionToBeCalled" value="editEmployee">
                    <input type="submit" name="submit" value="Edit">
                </div>
            </form>
        
        </div>

        <div class="col-4 border">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div>
                    <label><h3>Delete Employee</h3></label><br>

                    <label>Employee Id</label><br>
                    <input type="text" name="employeeId" value=""><br>

                    <input type="hidden" name="functionToBeCalled" value="deleteEmployee">
                    <input type="submit" name="submit" value="Delete">
                </div>
            </form>
        </div>

    </div>

</div>

<?php require('include/footer.php');?>