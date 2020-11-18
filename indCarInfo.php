<?php require('include/header.php'); ?>

<?php       

$images = array(); 
$carInfo = array();

$inventoryId = $_GET['inventoryId'];
$carInfo['inventoryId'] = $inventoryId;

$manYear = $_GET['manYear'];
$carInfo['manYear'] = $manYear;

$make = $_GET['make'];
$carInfo['make'] = $make;

$model = $_GET['model'];
$carInfo['model'] = $model;

$mileage = $_GET['mileage'];
$carInfo['mileage'] = $mileage;

$color = $_GET['color'];
$carInfo['color'] = $color;

$condition = $_GET['carCondition'];
$carInfo['condition'] = $condition;

$vin = $_GET['vin'];
$carInfo['vin'] = $vin;

$notes = $_GET['notes'];
$carInfo['notes'] = $notes;

if(isset($inventoryId)){
    $sql = "select * from photos where carId = '$inventoryId' ORDER BY carId asc";
    // echo 'query : ' . $sql;
    
    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($images, '<img  class="img-fluid p-1" src="' .$row["photoName"] . '" alt="" >');
        }
    } else {
        // echo "No photos";
    }
} 	else {
    echo "Can't access target file";
}

?>

<div class="container border bg-light">

<?php require('include/navbar.php'); ?>

    <div class="row border d-flex justify-content-center">
        <h1 class="border">Car Information Page</h1>
    </div>
    <div class="row border">
        <div class="col-3 border">
        <?php   
            if(empty($images)){
                echo 'No photos';
            }
        ?>
            <?php foreach ($images as $image){ 
                echo $image;
            }
            ?>
        </div>
        <div class="col-9 border">
            <!-- <a href='indCarInfo.php'>XYZ</a> -->
            <?php 
            foreach ($carInfo as $key => $value){ 
                ?>
                <p><?php //echo $key . ': ' . $value; ?></p>

            <?php } ?>
            <?php 
                echo 'Inventory Id: ' . $inventoryId = $_GET['inventoryId'] . '<br>';
                echo 'Manufacture Year: ' . $manYear = $_GET['manYear'] . '<br>';
                echo 'Make: ' . $make = $_GET['make'] . '<br>';
                echo 'Model: ' . $model = $_GET['model'] . '<br>';
                echo 'Mileage: ' . $mileage = $_GET['mileage'] . '<br>';
                echo 'Color: ' . $color = $_GET['color'] . '<br>';
                echo 'Condition: ' . $condition = $_GET['condition'] . '<br>';
                echo 'Vin #: ' . $vin = $_GET['vin'] . '<br>';
                echo 'Notes: ' . $notes = $_GET['notes'] . '<br>';

                echo "<h3>Contact us about this car?</h3>";

                echo "<a href='contact.php?" . 
                "inventoryId=" . $inventoryId . "&" .
                "vin=" . $vin . "&" .
                "make=" . $make . "&" .
                "model=" . $model . "&" .
                "'>Contact Us</a>";

                echo '<br>';

            ?>
        </div>
    </div>
    <div class="row">
    </div>
</div>

<?php require('include/footer.php');?>