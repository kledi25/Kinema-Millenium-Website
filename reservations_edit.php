<?php # Leo
# Start session , so that Session variables can be accessed
session_start();
# Check the role of the user, if he is not the role 'admin', then he is sent to the main page
if (isset($_SESSION['Role'])) {
    if ($_SESSION['Role'] != 'admin') {
        header("location:index.php");
        exit();
    }
} else {
    header("location:index.php");
    exit();
}
# Bind the navbar and connection file
require_once 'navbar.php';
require_once 'connection.php';
// PHP Code that proves the Existence of input and sends them to the DB to save
if (isset($_POST["MovieTitle"]) && isset($_POST["DATE"]) && isset($_POST["TIME"]) && isset($_POST["SeatNr"]) && isset($_POST["UserID"]) && isset($_POST["addProd"])) {

    require_once "connection.php";
    $MovieTitle = sanitizeInput($_POST["MovieTitle"]);
    $DATE = $_POST["DATE"];
    $TIME = $_POST["TIME"];
    $SeatNr = $_POST["SeatNr"];
    $UserID = sanitizeInput($_POST["UserID"]);

    $sql = "INSERT INTO Reservations (MovieTitle,  DATE, TIME, SeatNr, UserID) VALUES (:MovieTitle,  :DATE, :TIME, :SeatNr, :UserID)";
    $sth = $con->prepare($sql); # For security reasons we use 'Prepared-Statements'.
    # Then we bind the input data with the corresponding Table Column in the DB
    $sth->bindParam(':MovieTitle', $MovieTitle);
    $sth->bindParam(':DATE', $DATE);
    $sth->bindParam(':TIME', $TIME);
    $sth->bindParam(':SeatNr', $SeatNr);
    $sth->bindParam(':UserID', $UserID);
    # If an error occurs, try-catch helps to react to it
    try {
        $sth->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
    unset($_POST["addProd"]);
}
# Delete Row
if (isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];
    $sql = "DELETE FROM Reservations WHERE ID = :ID;";
    $sth = $con->prepare($sql);
    $sth->bindParam(":ID", $deleteId);
    $sth->execute();
    unset($_POST["delete"]);// unset the variable for later use
}
// PHP Code that proves the Existence of input and sends them to the DB to update
if (isset($_POST["MovieTitle"]) && isset($_POST["DATE"]) && isset($_POST["TIME"]) && isset($_POST["SeatNr"]) && isset($_POST["UserID"]) && isset($_POST["editProd"])) {

    require_once "connection.php";
    $MovieTitle = sanitizeInput($_POST["MovieTitle"]);
    $DATE = $_POST["DATE"];
    $TIME = $_POST["TIME"];
    $SeatNr = $_POST["SeatNr"];
    $UserID = sanitizeInput($_POST["UserID"]);
    $ID = $_POST["editProd"];

    $sql = "UPDATE Reservations SET MovieTitle = :MovieTitle,  DATE = :DATE, TIME = :TIME, SeatNr = :SeatNr, UserID = :UserID 
    WHERE ID = :ID ;";
    $sth = $con->prepare($sql); # For security reasons we use 'Prepared-Statements'.
    # Then we bind the input data with the corresponding Table Column in the DB
    $sth->bindParam(':MovieTitle', $MovieTitle);
    $sth->bindParam(':DATE', $DATE);
    $sth->bindParam(':TIME', $TIME);
    $sth->bindParam(':SeatNr', $SeatNr);
    $sth->bindParam(':UserID', $UserID);
    $sth->bindParam(':ID', $ID);
    # If an error occurs, try-catch helps to react to it
    try {
        $sth->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
    unset($_POST["editProd"]);
}
?>

    <style>
        /* Set a Site style */
        .modal {
            color: black;
        }

        li {
            color: black;
        }

    </style>


    <table class="table"> <!-- Use bootstrap to generate the Table -->
        <!-- Write Standard Table Head -->
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
        # Get the Data for the table from the DB
        $sql = "SELECT * from Reservations";
        $sth = $con->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            # For each Row on the DB , a Bootstrap table row will be generated, together with a 'Delete' and 'Change' as well as a Bootstrap modal for the Changes
            ?>
            <!-- Edit Reservation Modal -->
            <div class="modal fade" id="editModal<?php echo $item["ID"]; ?>" tabindex="-1"
                 aria-labelledby="editModal<?php echo $item["ID"]; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $item["MovieTitle"]; ?> </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="reservations_edit.php" method="POST">
                            <div class="modal-body">
                                <label for="MovieTitle">Ndrysho Rezervimin</label>
                                <label for="MovieTitle">Emri i Filmit:</label>
                                <input type="text" id="MovieTitle" name="MovieTitle"> <br>
                                <label for="DATE">Data :</label>
                                <input type="date" id="DATE" name="DATE"><br>
                                <label for="TIME">Ora :</label>
                                <input type="time" id="TIME" name="TIME"><br>
                                <label for="SeatNr">Numri i ndenjeses :</label>
                                <input type="text" id="SeatNr" name="SeatNr"><br>
                                <label for="UserID">Link:</label>
                                <input type="text" id="UserID" name="UserID"><br>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mbyll</button>
                                <button type="submit" name="editProd" value="<?php echo $item["ID"]; ?>"
                                        class="btn btn-primary">Ruaj Ndryshimet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!----------- Fill the table with the gotten Data from the DB --------------->
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
                    <form action="reservations_edit.php" method="POST">
                        <!-- This button returns a form with only one value, which is used as a condition to execute a SQL statement and as ID value -->
                        <button name="editProd" value="<?php echo $item["ID"] ?>" type="button" class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal<?php echo $item["ID"] ?>">Ndrysho
                        </button>
                    </form>
                </td>


                <td>
                    <form action="reservations_edit.php" method="POST">
                        <!-- This button returns a form with only one value, which is used as a condition to execute a SQL statement and as ID value -->
                        <button type="submit" name="delete" class="btn btn-primary" value="<?php echo $item['ID']; ?>">
                            Fshij
                        </button>
                    </form>
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>

    <!-- Bootstrap-Modal to give Data for new Reservations  -->
    <div class="col-4">
        <button type="button" class="btn btn-primary float-end ms-5 px-5" data-bs-toggle="modal"
                data-bs-target="#addModal">
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
                <form action="reservations_edit.php" method="POST">
                    <!-- This form contains the data needed for a new Reservation   -->
                    <div class="modal-body container">
                        <label for="MovieTitle">Emri i Filmit:</label>
                        <input type="text" id="MovieTitle" name="MovieTitle"> <br>
                        <label for="DATE">Data :</label>
                        <input type="date" id="DATE" name="DATE"><br>
                        <label for="TIME">Ora :</label>
                        <input type="time" id="TIME" name="TIME"><br>
                        <label for="SeatNr">Numri i ndenjeses :</label>
                        <input type="text" id="SeatNr" name="SeatNr"><br>
                        <label for="UserID">Link:</label>
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
# PHP Function to delete unnecessary characters from input
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
# Bind Footer to current Site

require_once("footer.php");
?>