<?php session_start(); ?>
<?php require('include/header.php'); ?>

<?php
$providedUserName = $_POST['userName'];
$providedPassword = $_POST['pass'];

if(isset($_POST['functionToBeCalled'])){
    $functionToBeCalled = $_POST['functionToBeCalled'];
    switch ($functionToBeCalled) {
        case "logout":
            logout();
            break;
    }
}   

function logout(){
    $_SESSION['userName'] = "";
    $_SESSION['user_level'] = "";
}

$toEcho = array();
    
if(!empty($_POST['userName'] && !empty($_POST['pass']))){

    $sql = "select userName, pass, positionTitle from employees;";
    
    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            
            if ($row['userName'] == $providedUserName && $row['pass'] == $providedPassword) {

                $_SESSION['userName'] = $row['userName'];
                $_SESSION['user_level'] = $row['positionTitle'];

                array_push($toEcho, 'Username and password have a match<br>');

                if($row['positionTitle'] == 'admin'){
                    
                    array_push($toEcho, '<a href="car.php?">Car Page</a><br>');
                    array_push($toEcho, '<a href="admin.php?">Admin Page</a><br>');
                    array_push($toEcho, '<a href="contactRequests.php?">Contact Requests</a><br>');

                }elseif ($row['positionTitle'] == 'sales associate') {

                    array_push($toEcho, '<a href="car.php?">Car Page</a><br>');
                    array_push($toEcho, '<a href="contactRequests.php?">Contact Requests</a><br>');
                }
                
            } else {
                echo "Incorrect user name or password <br>";
            }

        } 
        else {
            echo "row isn't set to assoc array <br>";
        }
    } else {
        array_push($toEcho, 'No results from select query<br>');
    }
} else {
    echo "Username or password is empty <br>";
    array_push($toEcho, 'Username or password is empty<br>');
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

    <div class="row d-flex justify-content-center border">
        <h1>Log In</h1>
    </div>

    <div class="row border">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <label for="">User Name:</label><br>
            <input type="text" name="userName"><br><br>

            <label for="">Password</label><br>
            <input type="text" name="pass"><br><br>

            <input type="submit" value="login"><br>
        
        </form>
    </div>
    <div class="row border">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="functionToBeCalled" value="logout"><br>
            <input type="submit" value="logout"><br>
        </form>
    </div>

    <div class="row">
        <div class="col">
            <p>Associate Username: john</p>
            <p>Password: pass</p><br>

            <p>Admin Username: vladamir</p>
            <p>Password: pass</p>

            <?php
                foreach ($toEcho as $value) {
                    echo $value;
                }
            ?>
        
        </div>
        
    </div>

</div>

<?php require('include/footer.php');?>