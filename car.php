<?php session_start(); ?>


<?php //require('include/db.php'); ?>
<?php require('include/header.php'); ?>

<?php

$carId = $_POST['carId'];
$manYear = $_POST['manYear'];
$make = $_POST['make'];
$model = $_POST['model'];
$mileage = $_POST['mileage'];
$color = $_POST['color'];
$condition = $_POST['condition'];
$notes = $_POST['notes'];
$vin = $_POST['vin'];

if(isset($_POST['functionToBeCalled'])){
    $functionToBeCalled = $_POST['functionToBeCalled'];
    switch ($functionToBeCalled) {
        case "showAllCars":
            $result = showAllCars();
            break;
        case "Hide Cars":
            ob_end_clean();
            break;
        case "addCar":
            addCar($manYear, $make, $model, $mileage, $color, $condition, $notes, $vin);
            break;
        case "deleteCar":
            deleteCar($carId);
            break;
        case "editCar":
            editCar($carId, $manYear, $make, $model, $mileage, $color, $condition, $notes, $vin);
            break;
    }
}

function editCar($carId, $manYear, $make, $model, $mileage, $color, $condition, $notes, $vin){

    if(!empty($_POST['ford']) || !empty($_POST['chevrolet']) || !empty($_POST['toyota'])){

        if(isset($_POST['ford']) && !empty($_POST['ford'])){
            $model = $_POST['ford'];
        }elseif(isset($_POST['chevrolet']) && !empty($_POST['chevrolet'])){
            $model = $_POST['chevrolet'];
        }elseif(isset($_POST['toyota']) && !empty($_POST['toyota'])){
            $model = $_POST['toyota'];
        }else{
            $model = 'model not selected';
        }

    }
    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    $sql = "UPDATE cars SET manYear='$manYear', make='$make', model='$model', mileage='$mileage', color='$color', 
    notes='$notes', carCondition='$condition', vin='$vin' WHERE inventoryId = '$carId' ";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
}

function deleteCar($carId){
    if(isset($_POST['carId'])){

        $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
        $sql = "delete from cars where inventoryId = '$carId'";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } 	else {
        echo "Can't access customer id";
    }
}

function showAllCars(){

    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");

    $sql = "SELECT * FROM cars ORDER BY inventoryId asc";
    $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // output data of each row
    //     while($row = $result->fetch_assoc()) {

    //         // echo "inventoryId: " . $row["inventoryId"]. " Year: " . $row["manYear"] . " Make: " . $row["make"] . 
    //         // " Model: " . $row["model"] . " Mileage: " . $row["mileage"] . " Color: " . $row["color"] . 
    //         // " Condition: " . $row["carCondition"] . " Vin: " . $row["vin"] . " Description: " . $row["notes"] . "<br>";
    //     }
    // } else {
    //     echo "0 results";
    // }

    return $result;
}

function addCar($manYear, $make, $model, $mileage, $color, $condition, $notes, $vin){

    if(!empty($_POST['ford']) || !empty($_POST['chevrolet']) || !empty($_POST['toyota'])){

        if(isset($_POST['ford']) && !empty($_POST['ford'])){
            $model = $_POST['ford'];
        }elseif(isset($_POST['chevrolet']) && !empty($_POST['chevrolet'])){
            $model = $_POST['chevrolet'];
        }elseif(isset($_POST['toyota']) && !empty($_POST['toyota'])){
            $model = $_POST['toyota'];
        }else{
            $model = 'model not selected';
        }
    }

    $sql = "INSERT INTO cars(manYear, make, model, mileage, color, carCondition, vin, notes) 
    VALUES('$manYear', '$make', '$model', '$mileage', '$color', '$condition', '$vin', '$notes')";
    
    $conn = new mysqli("jeffstrunk.com", "jeffst13", "fi47bomam", "jeffst13_carsales");
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>
    <div class="container border bg-light">

    <?php require('include/navbar.php'); 
        require('include/commonFunctions.php');
        restrictAllButEmployees();
    ?>

        <div class="row border d-flex justify-content-center">
            <h1>Manage Car Inventory</h1>
        </div>
        <div class="row border">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <label><h3>Show all car inventory</h3></label><br>
                    <input type="hidden" name="functionToBeCalled" value="showAllCars">
                    <input type="submit" name="submit" value="View Cars">
                    <input type="submit" name="functionToBeCalled" value="Hide Cars">
                    <br><br>

                    <table class="table">
                        <tr class="thead-dark">
                            <th>Inventory Id </th>
                            <th>Year </th>
                            <th>Make</th>
                            <th>Model </th>
                            <th>Mileage </th>
                            <th>Color </th>
                            <th>Condition</th>
                            <th>Vin #</th>
                            <th>Notes</th>
                        </tr>
                        
                    <?php
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                    ?>
                               
                                    <tr>
                                        <?php ob_start(); ?>
                                        <td><?php echo $row["inventoryId"] ?></td>
                                        <td><?php echo $row["manYear"] ?></td>
                                        <td><?php echo $row["make"] ?></td>
                                        <td><?php echo $row["model"] ?></td>
                                        <td><?php echo $row["mileage"] ?></td>
                                        <td><?php echo $row["color"] ?></td>
                                        <td><?php echo $row["carCondition"] ?></td>
                                        <td><?php echo $row["vin"] ?></td>
                                        <td><?php echo $row["notes"] ?></td>
                                        <?php //ob_end_clean(); ?>
                                    </tr>
                                    
                                
                    <?php       
                            }
                        } else {
                            // echo "0 results";
                        }   
                    ?>
                    
                    </table>
                    <input type="submit" name="functionToBeCalled" value="Hide Cars">
            </form> 
        </div>


       <div class="row border">

             <div class="col-4 border">
                
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div>
                        <label><h3>Add a car</h3></label><br>

                        <label>Manufacturer Year</label><br>
                        <select name="manYear" id="">
                            <option name="" value=""> </option>
                            <option name="" value="2020">2020</option>
                            <option name="" value="2019">2019</option>
                            <option name="" value="2018">2018</option>
                            <option name="" value="2017">2017</option>
                            <option name="" value="2016">2016</option>
                            <option name="" value="2015">2015</option>
                            <option name="" value="2014">2014</option>
                            <option name="" value="2013">2013</option>
                            <option name="" value="2012">2012</option>
                            <option name="" value="2011">2011</option>
                            <option name="" value="2010">2010</option>
                            <option name="" value="2009">2009</option>
                            <option name="" value="2008">2008</option>
                            <option name="" value="2007">2007</option>
                            <option name="" value="2006">2006</option>
                            <option name="" value="2005">2005</option>
                            <option name="" value="2004">2004</option>
                            <option name="" value="2003">2003</option>
                            <option name="" value="2002">2002</option>
                            <option name="" value="2001">2001</option>
                            <option name="" value="2000">2000</option>
                            <option name="" value="1999">1999</option>
                            <option name="" value="1998">1998</option>
                            <option name="" value="1997">1997</option>
                            <option name="" value="1996">1996</option>
                            <option name="" value="1995">1995</option>
                            <option name="" value="1994">1994</option>
                            <option name="" value="1993">1993</option>
                            <option name="" value="1992">1992</option>
                            <option name="" value="1991">1991</option>
                            <option name="" value="1990">1990</option>
                            <option name="" value="1989">1989</option>
                            <option name="" value="1988">1988</option>
                            <option name="" value="1987">1987</option>
                            <option name="" value="1986">1986</option>
                            <option name="" value="1985">1985</option>
                            <option name="" value="1984">1984</option>
                            <option name="" value="1983">1983</option>
                            <option name="" value="1982">1982</option>
                            <option name="" value="1981">1981</option>
                            <option name="" value="1980">1980</option>
                            <option name="" value="1979">1979</option>
                            <option name="" value="1978">1978</option>
                            <option name="" value="1977">1977</option>
                            <option name="" value="1976">1976</option>
                            <option name="" value="1975">1975</option>
                            <option name="" value="1974">1974</option>
                            <option name="" value="1973">1973</option>
                            <option name="" value="1972">1972</option>
                            <option name="" value="1971">1971</option>
                            <option name="" value="1970">1970</option>
                            <option name="" value="1969">1969</option>
                            <option name="" value="1968">1968</option>
                            <option name="" value="1967">1967</option>
                            <option name="" value="1966">1966</option>
                            <option name="" value="1965">1965</option>
                            <option name="" value="1964">1964</option>
                            <option name="" value="1963">1963</option>
                            <option name="" value="1962">1962</option>
                            <option name="" value="1961">1961</option>
                            <option name="" value="1960">1960</option> 
                        </select><br>

                        <label for="">Make:</label><br>
                        <select name="make" onchange="setModels()" id="make">
                            <option name="" value=""> </option>
                            <option name="chevrolet" value="chevrolet">Chevrolet</option>
                            <option name="ford" value="ford">Ford</option>
                            <option name="toyota" value="toyota">Toyota</option>
                        </select>
                        <br><br>

                        <div class="hideAtFirst" id="chevrolet">
                            <label for="">Chevy Models:</label><br>
                            <select name="chevrolet" id="">
                                <option name="" value=""> </option>
                                <option name="camaro" value="camaro">Camaro</option>
                                <option name="corvette" value="corvette">Corvette</option>
                                <option name="cruze" value="cruze">Cruze</option>
                            </select>
                        </div> 
            
                        <div class="hideAtFirst" id="ford">
                            <label for="">Ford Models:</label><br>
                            <select name="ford" id="">
                                <option name="" value=""> </option>
                                <option name="mustang" value="mustang">Mustang</option>
                                <option name="fiesta" value="fiesta">Fiesta</option>
                                <option name="f150" value="f150">F-150</option>
                            </select>
                        </div>
                        
                        <div class="hideAtFirst" id="toyota">
                            <label for="">Toyota Models:</label><br>
                            <select name="toyota" id="">
                                <option name="" value=""> </option>
                                <option name="corolla" value="corolla">Corolla</option>
                                <option name="prius" value="prius">Prius</option>
                                <option name="tundra" value="tundra">Tundra</option>
                            </select>
                        </div>

                        <label>Mileage</label><br>
                        <input type="text" name="mileage" ><br>
            
                        <div id="">
                            <label for="">Color:</label><br>
                            <select name="color" id="">
                                <option name="red" value="Red">Red</option>
                                <option name="orange" value="Orange">Orange</option>
                                <option name="yellow" value="Yellow">Yellow</option>
                                <option name="green" value="Green">Green</option>
                                <option name="blue" value="Blue">Blue</option>
                                <option name="indigo" value="Indigo">Indigo</option>
                                <option name="violet" value="Violet">Violet</option>
                                <option name="black" value="Black">Black</option>
                                <option name="" value="White">White</option>
                            </select>
                        </div>

                        <div id="">
                            
                            <label for="">Condition: </label><br>
                            <select name="condition" id="">
                                <option name="" value="New">New</option>
                                <option name="" value="Used – Like New">Used – Like New</option>
                                <option name="" value="Used – Good">Used – Good</option>
                                <option name="" value="Used – Some Damage">Used – Some Damage</option>
                                <option name="" value="Used – Some Damage">Used - Major Damage</option>
                                <option name="" value="Used – Some Damage">Really Bad - If you buy this car you aren't wise</option>
                            </select>
                        </div>

                        <label>Vin#</label><br>
                        <input type="text" name="vin" ><br>

                        <label>Description</label><br>
                        <textarea name="notes" id="" cols="20" rows="10" ></textarea><br>

                        <input type="hidden" name="functionToBeCalled" value="addCar">
                        <input type="submit" name="submit" value="Add">
                    </div>
                </form>
                
                

            </div>




            <div class="col-4">
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div>
                        <label><h3>Edit a car</h3></label><br>
                        <label>Must re-enter all fields!!!</label><br>

                        <label>Car/Inventory Id</label><br>
                        <input type="text" name="carId"><br>

                        <label>Manufacturer Year</label><br>
                        <select name="manYear" id="">
                            <option name="" value=""> </option>
                            <option name="" value="2020">2020</option>
                            <option name="" value="2019">2019</option>
                            <option name="" value="2018">2018</option>
                            <option name="" value="2017">2017</option>
                            <option name="" value="2016">2016</option>
                            <option name="" value="2015">2015</option>
                            <option name="" value="2014">2014</option>
                            <option name="" value="2013">2013</option>
                            <option name="" value="2012">2012</option>
                            <option name="" value="2011">2011</option>
                            <option name="" value="2010">2010</option>
                            <option name="" value="2009">2009</option>
                            <option name="" value="2008">2008</option>
                            <option name="" value="2007">2007</option>
                            <option name="" value="2006">2006</option>
                            <option name="" value="2005">2005</option>
                            <option name="" value="2004">2004</option>
                            <option name="" value="2003">2003</option>
                            <option name="" value="2002">2002</option>
                            <option name="" value="2001">2001</option>
                            <option name="" value="2000">2000</option>
                            <option name="" value="1999">1999</option>
                            <option name="" value="1998">1998</option>
                            <option name="" value="1997">1997</option>
                            <option name="" value="1996">1996</option>
                            <option name="" value="1995">1995</option>
                            <option name="" value="1994">1994</option>
                            <option name="" value="1993">1993</option>
                            <option name="" value="1992">1992</option>
                            <option name="" value="1991">1991</option>
                            <option name="" value="1990">1990</option>
                            <option name="" value="1989">1989</option>
                            <option name="" value="1988">1988</option>
                            <option name="" value="1987">1987</option>
                            <option name="" value="1986">1986</option>
                            <option name="" value="1985">1985</option>
                            <option name="" value="1984">1984</option>
                            <option name="" value="1983">1983</option>
                            <option name="" value="1982">1982</option>
                            <option name="" value="1981">1981</option>
                            <option name="" value="1980">1980</option>
                            <option name="" value="1979">1979</option>
                            <option name="" value="1978">1978</option>
                            <option name="" value="1977">1977</option>
                            <option name="" value="1976">1976</option>
                            <option name="" value="1975">1975</option>
                            <option name="" value="1974">1974</option>
                            <option name="" value="1973">1973</option>
                            <option name="" value="1972">1972</option>
                            <option name="" value="1971">1971</option>
                            <option name="" value="1970">1970</option>
                            <option name="" value="1969">1969</option>
                            <option name="" value="1968">1968</option>
                            <option name="" value="1967">1967</option>
                            <option name="" value="1966">1966</option>
                            <option name="" value="1965">1965</option>
                            <option name="" value="1964">1964</option>
                            <option name="" value="1963">1963</option>
                            <option name="" value="1962">1962</option>
                            <option name="" value="1961">1961</option>
                            <option name="" value="1960">1960</option> 
                        </select><br>

                        
                        <label for="">Make:</label><br>
                        <select name="make" onchange="setModels()" id="make">
                            <option name="" value=""> </option>
                            <option name="chevrolet" value="chevrolet">Chevrolet</option>
                            <option name="ford" value="ford">Ford</option>
                            <option name="toyota" value="toyota">Toyota</option>
                        </select>
                        <br><br>

                        
                        <div class="" id="chevrolet">
                            <label for="">Chevy Models:</label><br>
                            <select name="chevrolet" id="">
                                <option name="" value=""> </option>
                                <option name="camaro" value="camaro">Camaro</option>
                                <option name="corvette" value="corvette">Corvette</option>
                                <option name="cruze" value="cruze">Cruze</option>
                            </select>
                        </div> 
            
                        <div class="" id="ford">
                            <label for="">Ford Models:</label><br>
                            <select name="ford" id="">
                                <option name="" value=""> </option>
                                <option name="mustang" value="mustang">Mustang</option>
                                <option name="fiesta" value="fiesta">Fiesta</option>
                                <option name="f150" value="f150">F-150</option>
                            </select>
                        </div>
                        
                        <div class="" id="toyota">
                            <label for="">Toyota Models:</label><br>
                            <select name="toyota" id="">
                                <option name="" value=""> </option>
                                <option name="corolla" value="corolla">Corolla</option>
                                <option name="prius" value="prius">Prius</option>
                                <option name="tundra" value="tundra">Tundra</option>
                            </select>
                        </div>

                        <label>Mileage</label><br>
                        <input type="text" name="mileage"><br>

                        
                        <div id="">
                            <label for="">Color:</label><br>
                            <select name="color" id="">
                                <option name="red" value="Red">Red</option>
                                <option name="orange" value="Orange">Orange</option>
                                <option name="yellow" value="Yellow">Yellow</option>
                                <option name="green" value="Green">Green</option>
                                <option name="blue" value="Blue">Blue</option>
                                <option name="indigo" value="Indigo">Indigo</option>
                                <option name="violet" value="Violet">Violet</option>
                            </select>
                        </div>

                        
                        <div id="">
                            <label for="">Condition:</label><br>
                            <select name="condition" id="">
                                <option name="" value="New">New</option>
                                <option name="" value="Used – Like New">Used – Like New</option>
                                <option name="" value="Used – Good">Used – Good</option>
                                <option name="" value="Used – Some Damage">Used – Some Damage</option>
                                <option name="" value="Used – Some Damage">Used - Major Damage</option>
                                <option name="" value="Used – Some Damage">Really Bad - If you buy this car you aren't wise</option>
                            </select>
                        </div>

                        <label>Vin#</label><br>
                        <input type="text" name="vin"><br>

                        <label>Description</label><br>
                        <textarea name="notes" id="" cols="20" rows="10"></textarea><br>

                        <input type="hidden" name="functionToBeCalled" value="editCar">
                        <input type="submit" name="submit" value="Edit">
                    </div>
                </form>
            </div>



            <div class="col-4 border">
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div>
                        <label><h3>Delete a car</h3></label><br>
                        <label>Car Inventory Id</label><br>
                        <input type="text" name="carId"><br>
                        <input type="hidden" name="functionToBeCalled" value="deleteCar">
                        <input type="submit" name="submit" value="Delete">
                    </div>
                </form>
            </div> 



        </div>
        
    </div>
<script>
    function setModels() {
        
        let make = document.querySelector("#make").value;

        switch (make) {
            case "chevrolet":
                document.querySelector("#chevrolet").style.visibility = "visible";
                document.querySelector("#ford").style.visibility = "hidden";
                document.querySelector("#toyota").style.visibility = "hidden";
                break;
            case "ford":
                document.querySelector("#ford").style.visibility = "visible";
                document.querySelector("#chevrolet").style.visibility = "hidden";
                document.querySelector("#toyota").style.visibility = "hidden";
                break;
            case "toyota":
                document.querySelector("#toyota").style.visibility = "visible";
                document.querySelector("#chevrolet").style.visibility = "hidden";
                document.querySelector("#ford").style.visibility = "hidden";
                break;
        }
    }
</script>

<?php require('include/footer.php');?>