<?php
session_start();

if (isset($_SESSION['Role'])) {

    if ($_SESSION['Role'] != 'admin') {
        header("location:index.php");
        exit();
    }
}else{
    header("location:index.php");
    exit();
}



require_once 'navbar.php';
require 'connection.php';
?>
<style>
    .modal {
        color: black;
    }

    li {
        color: black;
    }

</style>
<table class="table">
    <thead>
    <tr>
        <th scope="col" class="col-1">ID</th>
        <th scope="col" class="col-1">MovieTitle</th>
        <th scope="col" class="col-1">DATE</th>
        <th scope="col" class="col-1">TIME</th>
        <th scope="col" class="col-1">SeatNr</th>
        <th scope="col" class="col-1">UserID</th>
        <th scope="col" class="col-1"></th>
        <th scope="col" class="col-1"></th>
    </tr>
    </thead>

    <tbody>
    <?php
    $sql = "SELECT * from Reservations";
    $sth = $con->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $item) {
    ?>
    <!--------------------------------------edit reservation Modal content--------------------------------------------------->
    <div class="modal fade" id="editModal<?php echo $item["ID"] ;?>" tabindex="-1"
         aria-labelledby="editModal<?php echo $item["ID"] ;?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Ndrysho nje rezervim <?php echo $item["ID"] ;?> </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="reservations.php" method="POST">
                    <div class="modal-body">
                        <label for="MovieTitle">Titulli i filmit:</label>
                        <input type="text" id="MovieTitle" name="MovieTitle"> <br>

                        <label for="DATE">Data e paraqitjes:</label>
                        <input type="date" id="DATE" name="DATE"><br>
                        <label for="TIME">Ora e paraqitjes:</label>
                        <input type="time" id="TIME" name="TIME"><br>

                        <label for="SeatNr">Numri i ndenjeses :</label>
                        <input type="text" id="SeatNr" name="SeatNr"><br>
                        <label for="UserID">ID e perdoruesit :</label>
                        <input type="text" id="UserID" name="UserID"><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mbyll</button>
                        <button type="submit" name="editProd" value="<?php echo $item["ID"] ;?>" class="btn btn-primary">Ruaj Ndryshimet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


        <!-------------------------------------- Table content--------------------------------------------------->
        <tr>
            <td>
                <?php echo $item['ID'] ?>
            </td>

            <td>
                <?php echo $item['MovieTitle'] ?>
            </td>

            <td>
                <?php echo $item['DATE'] ?>
            </td>

            <td>
                <?php echo $item['TIME'] ?>
            </td>

            <td>
                <?php echo $item['SeatNr'] ?>
            </td>

            <td>
                <?php echo $item['UserID'] ?>
            </td>

            <td>
                <form action="reservations.php" method="POST">
                    <button name="editProd" value="<?php echo $item["ID"] ?>" type="button" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal<?php echo $item["ID"] ?>">Ndrysho
                    </button>
                </form>
            </td>


            <td>
                <form action="reservations.php" method="POST">
                    <button type="submit" name="delete" class="btn btn-primary" value="<?php echo $item['ID']; ?>">Fshij
                    </button>
                </form>
            </td>
        </tr>

    <?php } ?>
    </tbody>
</table>

<!------------------------------------------------ Add a reservation modal ------->
<div class="col-4">
    <button type="button" class="btn btn-primary float-end ms-5 px-5" data-bs-toggle="modal" data-bs-target="#addModal">
        Shto nje rezervim
    </button>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModal">Shto nje rezervim</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="reservations.php" method="POST">
                <div class="modal-body container">
                    <label for="MovieTitle">Titulli i filmit:</label>
                    <input type="text" id="MovieTitle" name="MovieTitle"> <br>
                    <label for="DATE">Data :</label>
                    <input type="date" id="DATE" name="DATE"><br>
                    <label for="TIME">Ora :</label>
                    <input type="time" id="TIME" name="TIME"><br>


                    <label for="SeatNr">Numri i ndenjeses:</label>
                    <input type="text" id="SeatNr" name="SeatNr"><br>

                    <label for="UserID">ID e perdoruesit:</label>
                    <input type="text" id="UserID" name="UserID"><br>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mbyll</button>
                    <button type="submit" name="addProd" value="1" class="btn btn-primary">Ruaj Ndryshimet</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br><br><br><br><br><br>




<?php
//----------------------------------------------Edit reservations
if (isset($_POST["editProd"]) && isset($_POST["MovieTitle"]) && isset($_POST["DATE"]) && isset($_POST["TIME"]) && isset($_POST["SeatNr"]) && isset($_POST["UserID"]) ) {
    require_once "connection.php";
    $ID = sanitizeInput($_POST["editProd"]);
    $MovieTitle = sanitizeInput($_POST["MovieTitle"]);
    $DATE = $_POST["DATE"];
    $TIME = $_POST["TIME"];
    $SeatNr = sanitizeInput($_POST["SeatNr"]);
    $UserID = sanitizeInput($_POST["UserID"]);

    $sql = "UPDATE Reservations SET MovieTitle = :MovieTitle, DATE = :DATE, TIME = :TIME, SeatNr = :SeatNr, UserID = :UserID WHERE ID = :ID ;";
    $sth = $con->prepare($sql);
    $sth->bindParam(':ID', $ID);
    $sth->bindParam(':MovieTitle', $MovieTitle);
    $sth->bindParam(':DATE', $DATE);
    $sth->bindParam(':TIME', $TIME);
    $sth->bindParam(':SeatNr', $SeatNr);
    $sth->bindParam(':UserID', $UserID);
    $sth->execute();
    unset($_POST["editProd"]);
}
?>


<?php
//----------------------------------------------delete Reservations
if (isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];
    require_once 'connection.php';
    $sql = "DELETE FROM Reservations WHERE ID = :ID;";
    $sth = $con->prepare($sql);
    $sth->bindParam(":ID", $deleteId);
    $sth->execute();
}
?>



<?php
//----------------------------------------------add reservations
if (isset($_POST["MovieTitle"]) && isset($_POST["DATE"]) && isset($_POST["TIME"]) && isset($_POST["SeatNr"]) && isset($_POST["UserID"]) && isset($_POST["addProd"])) {

    require_once "connection.php";
    $MovieTitle = sanitizeInput($_POST["MovieTitle"]);
    $DATE = sanitizeInput($_POST["DATE"]);
    $TIME = sanitizeInput($_POST["TIME"]);
    $SeatNr = sanitizeInput($_POST["SeatNr"]);
    $UserID = sanitizeInput($_POST["UserID"]);

    $sql = "INSERT INTO Reservations (MovieTitle, DATE, TIME, SeatNr, UserID) VALUES (:MovieTitle, :DATE, :TIME, :SeatNr, :UserID)";
    $sth = $con->prepare($sql);
    if (false === $sth) {
        // Handle the error here
        echo "Error preparing query: " . $con->errorInfo();
    }
    $sth->bindParam(':MovieTitle', $MovieTitle);
    $sth->bindParam(':DATE', $DATE);
    $sth->bindParam(':TIME', $TIME);
    $sth->bindParam(':SeatNr', $SeatNr);
    $sth->bindParam(':UserID', $UserID);
    $sth->execute();
    unset($_POST["addProd"]);
}
?>

<?php
$str = 'ä ö ü ß < > & " \'';
$str = htmlspecialchars($str);
function sanitizeInput($input)
{
$input = trim($input);
$input = stripslashes($input);
$input = htmlspecialchars($input);
return $input;
}

?>


<?php
require_once 'footer.php';
?>
