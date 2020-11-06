<?php session_start(); ?>
<?php require('include/header.php'); 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<?php

class myGlobals {
    static $pageno;
    static $total_pages;
    static $no_of_records_per_page = 100;
    static $offset;
    static $total_pages_sql;
    // static $query;
    static $sqlEnd;
}

// $query;
$abc = 0;

if(isset($_GET['pageno'])){
    myGlobals::$pageno = $_GET['pageno'];
    // echo "query below<br>";
    // $testQuery = myGlobals::$query;
    // echo $testQuery;
    // print_r($testQuery);
    showOtherPages();
} else {
    // $pageno = 1;
    // searchCars($pageno);
}

function showOtherPages(){
    echo "showOtherPages<br>";
    // global $abc;
    // echo $abc;

    echo "query below<br>";
    global $query;
    echo $query;

    $mysqli = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    // $pageResults = $mysqli->query(myGlobals::$query);
    // $pageResults = $mysqli->query( global $query);

    // return $pageResults;
}

if(isset($_POST['functionToBeCalled'])){
    $functionToBeCalled = $_POST['functionToBeCalled'];
    switch ($functionToBeCalled) {
        case "searchCars":
            if(isset($_POST['year'])){
                $pageResults = searchCars();
                // searchCars();
                // $images = getImages();
            }
            break;
    }
}

$Images = array();

function searchCars(){
    global $query;
    $year = $_POST['year'];
    $make = $_POST['make'];

    if(!empty($_POST['make'])){
    }

    if(!empty($_POST['ford']) || !empty($_POST['chevrolet']) || !empty($_POST['toyota'])){
        if(isset($_POST['ford']) && !empty($_POST['ford'])){
            $model = $_POST['ford'];
        }elseif(isset($_POST['chevrolet']) && !empty($_POST['chevrolet'])){
            $model = $_POST['chevrolet'];
        }elseif(isset($_POST['toyota']) && !empty($_POST['toyota'])){
            $model = $_POST['toyota'];
        }else{
        }
    }

    // three in query
    if(!empty($year) && !empty($make) && !empty($model) ){
        $query = "select * from cars where manYear = $year and make = '$make' and model = '$model';";
    }
    // year and make
    elseif (!empty($year) && !empty($make) && empty($model)){
        $query = "select * from cars where manYear = $year and make = '$make'";
    }
    // make and model
    elseif(!empty($make) && !empty($model) && empty($year)){
        $query = "select * from cars where make = '$make' and model = '$model'";
    }
    // only year
    elseif(!empty($year) && empty($make) && empty($model)){
        $query = "select * from cars where manYear = $year ";
    }
    // only make
    elseif(empty($year) && !empty($make) && empty($model)){
        $query = "select * from cars where make = '$make'";
    } 

    $mysqli = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }




    // PAGINATION

    if (isset($_GET['pageno'])) {
        // $pageno = $_GET['pageno'];
    } else {
        myGlobals::$pageno = 1;
    }
    

    if(isset(myGlobals::$pageno)){
        myGlobals::$offset = (myGlobals::$pageno-1) * myGlobals::$no_of_records_per_page;
    }

    $conn=mysqli_connect("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");

    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
    }

    myGlobals::$total_pages_sql = "SELECT COUNT(*) FROM cars";
    $result = mysqli_query($conn,myGlobals::$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    myGlobals::$total_pages = ceil($total_rows / myGlobals::$no_of_records_per_page);

    $x = myGlobals::$no_of_records_per_page;
    $os = myGlobals::$offset;
    myGlobals::$sqlEnd = "LIMIT $os, $x;";

    $query = $query . " " . myGlobals::$sqlEnd;
    // echo myGlobals::$query;

    $pageResults = $mysqli->query($query);

    return $pageResults;




    // Getting images
    // Getting images
    // Getting images

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
            echo "No results";
        }
    } 	else {
        echo "Can't access target file";
    }
}



// PAGINATION


    // if (isset($_GET['pageno'])) {
    //     $pageno = $_GET['pageno'];
    // } else {
    //     $pageno = 1;
    // }
    // $no_of_records_per_page = 5;
    // $offset = ($pageno-1) * $no_of_records_per_page;

    // $conn=mysqli_connect("carsales.adeftsolutions.com", "carsalesadeft", "5;X^=wrjf6N;", "carsalesadeft_main");
    // // Check connection
    // if (mysqli_connect_errno()){
    //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //     die();
    // }

    // $total_pages_sql = "SELECT COUNT(*) FROM cars";
    // $result = mysqli_query($conn,$total_pages_sql);
    // $total_rows = mysqli_fetch_array($result)[0];
    // $total_pages = ceil($total_rows / $no_of_records_per_page);

    // // $query = "select * from cars where make = '$make'";
    // $sql = "select * from cars LIMIT $offset, $no_of_records_per_page";

    // $res_data = mysqli_query($conn,$sql);
    // while($row = mysqli_fetch_array($res_data)){
    //     echo $row['inventoryId'] . '<br>';

    // }
    // mysqli_close($conn);


// GET PHOTOS FOR TABLE

// function getImages(){
//     // $images = array();
//     if(isset($inventoryId)){
//         $sql = "select * from photos where carId = '$inventoryId' ORDER BY carId asc";
//         // echo 'query : ' . $sql;
        
//         $conn = new mysqli("carsales.adeftsolutions.com", "carsalesadeft", "5;X^=wrjf6N;", "carsalesadeft_main");
//         $result = $conn->query($sql);

//         if ($result->num_rows > 0) {
//             // output data of each row
//             while($row = $result->fetch_assoc()) {
//                 array_push($images, '<img  class="img-fluid p-1" src="' .$row["photoName"] . '" alt="" >');
//             }
//         } else {
//             echo "No results";
//         }
//     } 	else {
//         echo "Can't access target file";
//     }

//     return $images;
// }

?>



<div class="container bg-light">
<?php require('include/navbar.php'); ?>

    <!-- <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if(myGlobals::$pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if(myGlobals::$pageno <= 1){ echo '#'; } else { echo "?pageno=".(myGlobals::$pageno - 1); } ?>">Prev</a>
        </li>

        <li class="<?php if(myGlobals::$pageno >= myGlobals::$total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if(myGlobals::$pageno >= myGlobals::$total_pages){ echo '#'; } else { echo "?pageno=".(myGlobals::$pageno + 1); } ?>">Next</a>
        </li>

        <li><a href="?pageno=<?php echo myGlobals::$total_pages; ?>">Last</a></li>
    </ul> -->

    <?php 
    // echo "pageno: " . myGlobals::$pageno . "<br>" .
    //  " Total Pages: " . myGlobals::$total_pages . "<br>"
    //  ; 
     ?>

    <div class="row">
        <div class="col d-flex justify-content-center">
            <h1>Search Cars</h1>
        </div>
    </div>
    <div class="row">
        
        <div class="col-3 border">
        
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <label for="">Search our cars:</label><br>

                <?php
                    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
                    $sql = "SELECT manYear FROM cars ORDER BY manYear desc;";
                    $result = $conn->query($sql);
                
                    if ($result->num_rows > 0) {

                        // Available Years
                        $previousYear = 9999;
                        echo 
                        "<label>Year:</label><br>" .
                        "<select class='form-control' name='year' id='year'>" .
                        "<option></option>";

                        while($row = $result->fetch_assoc()) {
                            $thisYear = $row["manYear"];
                            if($thisYear == $previousYear){
                                continue;
                            } elseif ($thisYear !== $previousYear) {
                                echo "<option value=" . $row["manYear"] . ">" . $row["manYear"] . "</option>";
                                $previousYear = $thisYear;
                            }
                        }
                        echo "</select>";

                    } else {
                        echo "No vehicle years to display<br>";
                    }

                    // Available Makes
                    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
                    $sql = "SELECT make FROM cars ORDER BY make asc;";
                    $result = $conn->query($sql);

                    $previousMake = '';
                    echo 
                    "<label>Make:</label><br>" .
                    "<select class='form-control' name='make' id='make' onchange=\"getMake()\">" .
                    "<option></option>";

                    while($row = $result->fetch_assoc()) {
                        $thisMake = $row["make"];
                        if(strtolower($thisMake) == strtolower($previousMake)){
                            continue;
                        } elseif ($thisMake !== $previousMake) {
                            echo "<option value=" . $row["make"] . ">" . $row["make"] . "</option>";
                            $previousMake = $thisMake;
                        }
                    }
                    echo "</select>";


                    // <label for="">Make:</label><br>
                    // <select name="make" onchange="getMake()" id="make">
                    //     <option name="" value=""> </option>
                    //     <option name="chevrolet" value="chevrolet">Chevrolet</option>
                    //     <option name="ford" value="ford">Ford</option>
                    //     <option name="toyota" value="toyota">Toyota</option>
                    // </select>
                    // <br><br>


                    // Available Models
                    //Uncomment this to get models back

                    // $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
                    // $sql = "SELECT make, model FROM cars;";
                    // $result = $conn->query($sql);

                    // $previousMake = '';
                    // echo 
                    // "<label>model:</label><br>" .
                    // "<select class='form-control' name='model' id='model' onchange=\"getMake()\">" .
                    // "<option></option>";

                    // while($row = $result->fetch_assoc()) {
                    //     $thisModel = $row["model"];
                    //     if(strtolower($thisModel) == strtolower($previousModel)){
                    //         continue;
                    //     } elseif ($thisModel !== $previousModel) {
                    //         echo "<option value=" . $row["model"] . ">" . $row["model"] . "</option>";
                    //         $previousModel = $thisModel;
                    //     }
                    // }
                    // echo "</select>";





                    // <div class="hideAtFirst" id="chevy">
                    //     <label for="">Chevy Models:</label><br>
                    //     <select name="chevrolet" id="model">
                    //         <option name="" value=""> </option>
                    //         <option name="camaro" value="camaro">Camaro</option>
                    //         <option name="corvette" value="corvette">Corvette</option>
                    //         <option name="cruze" value="cruze">Cruze</option>
                    //     </select>
                    //     <br><br>
                    // </div>


                ?>

                <!-- <label for="">Make:</label><br>
                <select name="make" onchange="getMake()" id="make">
                    <option name="" value=""> </option>
                    <option name="chevrolet" value="chevrolet">Chevrolet</option>
                    <option name="ford" value="ford">Ford</option>
                    <option name="toyota" value="toyota">Toyota</option>
                </select>
                <br><br> -->

                <div class="hideAtFirst" id="chevy">
                    <label for="">Chevy Models:</label><br>
                    <select class="form-control" name="chevrolet" id="model">
                        <option name="" value=""> </option>
                        <option name="camaro" value="camaro">Camaro</option>
                        <option name="corvette" value="corvette">Corvette</option>
                        <option name="cruze" value="cruze">Cruze</option>
                    </select>
                </div>
                
                <div class="hideAtFirst" id="ford">
                    <label for="">Ford Models:</label><br>
                    <select class="form-control" name="ford" id="model">
                        <option name="" value=""> </option>
                        <option name="mustang" value="mustang">Mustang</option>
                        <option name="fiesta" value="fiesta">Fiesta</option>
                        <option name="f150" value="f150">F-150</option>
                    </select>
                </div>
                
                <div class="hideAtFirst" id="toyota">
                    <label for="">Toyota Models:</label><br>
                    <select class="form-control" name="toyota" id="model">
                        <option name="" value=""> </option>
                        <option name="corolla" value="corolla">Corolla</option>
                        <option name="prius" value="prius">Prius</option>
                        <option name="tundra" value="tundra">Tundra</option>
                    </select>
                </div>
                
                <input type="hidden" name="functionToBeCalled" value="searchCars">
                <input type="submit" value="Select">
            </form>
        </div>

        <div class="col-9 border">

            <table class="table">
                <tr  class="thead-dark">
                    <th>Photo</th>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model </th>
                    <th>Mileage </th>
                    <th>Color </th>
                    <th>Condition</th>
                    <th>Inventory Id</th>
                </tr>

                <?php 
                // $inventoryId = $result['inventoryId'];
                // $manYear = $result['manYear'];
                // $make = $result['make'];
                // $model = $result['model'];
                // $mileage = $result['mileage'];
                // $color = $result['color'];
                // $condition = $result['condition'];
                // $vin = $result['vin'];
                // $notes = $result['notes'];

                if (isset($pageResults)) {
                    foreach($pageResults as $result){
                ?>
                <tr>
                    <!-- <td><?php // echo $result['inventoryId'] ?></td> -->
                    <td class="p-1">
                        <?php   
                            // if(empty($images)){
                            //     echo 'No photos';
                            // }

                            $inventoryId = $result['inventoryId']; 

                            if(isset($inventoryId)){
                                $sql = "select photoName from photos where carId = '$inventoryId' limit 1;";
                                // echo "inventoryId: " . $inventoryId . "<br>";
                                
                                $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
                                $imageResult = $conn->query($sql);
                        
                                if ($imageResult->num_rows > 0) {
                                    // output data of each row
                                    while($row = $imageResult->fetch_assoc()) {
                                        // array_push($images, '<img  class="img-fluid p-1" src="' .$row["photoName"] . '" alt="" >');
                                        echo '<img style="max-width: 100px" class="img-fluid " src="' .$row["photoName"] . '" alt="" >';
                                        // echo $result;
                                    }
                                    // echo '<img  class="img-fluid p-1" src="' .$result["photoName"] . '" alt="" >';
                                    // echo $result;
                                } else {
                                    echo "No results";
                                }
                            } 	else {
                                echo "Can't access target file";
                            }
                        
                        ?>
                            <?php 
                            // foreach ($images as $image){ 
                            //     echo $image;
                            // }
                            ?>
                    
                    </td>
                    <td><?php echo $result['manYear'] ?></td>
                    <td><?php echo $result['make'] ?></td>
                    <td><?php echo $result['model'] ?></td>
                    <td><?php echo $result['mileage'] ?></td>
                    <td><?php echo $result['color'] ?></td>
                    <td><?php echo $result['carCondition'] ?></td>
                    <td><?php echo $result['inventoryId'] ?></td>
                    <!-- <td><?php //echo $result['notes'] ?></td> -->

                <td>
                    <?php
                        $inventoryId = $result['inventoryId'];
                        $manYear = $result['manYear'];
                        $make = $result['make'];
                        $model = $result['model'];
                        $mileage = $result['mileage'];
                        $color = $result['color'];
                        $condition = $result['carCondition'];
                        // echo 'CAR CONDITION: ' . $condition;
                        $vin = $result['vin'];
                        $notes = $result['notes'];


                        echo 
                        '<a href="indCarInfo.php?' .
                        'inventoryId=' . $inventoryId . '&' .
                        'manYear=' . $manYear . '&' .
                        'make=' . $make . '&' .
                        'model=' . $model . '&' .
                        'mileage=' . $mileage . '&' .
                        'color=' . $color . '&' .
                        'condition=' . $condition . '&' .
                        'vin=' . $vin . '&' .
                        'notes=' . $notes . '&' .
                        '">Details</a>'

                    ?>
                    
                </td>
                </tr>
                <?php } } ?>

            </table>
        </div>
    </div>
</div>

<?php

    $query = "test query";

?>

<script>
    function getMake() {
        let make = document.querySelector("#make").value;

        switch (make) {
            case "chevrolet":
                document.querySelector("#chevy").style.visibility = "visible";
                document.querySelector("#ford").style.visibility = "hidden";
                document.querySelector("#toyota").style.visibility = "hidden";
                break;
            case "ford":
                document.querySelector("#ford").style.visibility = "visible";
                document.querySelector("#chevy").style.visibility = "hidden";
                document.querySelector("#toyota").style.visibility = "hidden";
                break;
            case "toyota":
                document.querySelector("#toyota").style.visibility = "visible";
                document.querySelector("#chevy").style.visibility = "hidden";
                document.querySelector("#ford").style.visibility = "hidden";
                break;
        }
    }
</script>


<?php require('include/footer.php');?>