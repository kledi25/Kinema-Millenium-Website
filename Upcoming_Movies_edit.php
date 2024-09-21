<?php
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
# Aktualisiere // PHP Code that proves the Existence of input and sends them to the DB to update
if (isset($_POST["editProd"]) && isset($_POST["Title"]) && isset($_POST["Poster"]) && isset($_POST["Description"]) && isset($_POST["DATE"])
    && isset($_POST["DIMENSION"]) && isset($_POST["Link"])) {
    require_once "connection.php";
    $ID = sanitizeInput($_POST["editProd"]);
    $Title_Upcoming = sanitizeInput($_POST["Title"]);
    $Poster_Upcoming = sanitizeInput($_POST["Poster"]);
    $Description_Upcoming = sanitizeInput($_POST["Description"]);
    $DATE_Upcoming = sanitizeInput($_POST["DATE"]);
    $DIMENSION_Upcoming = sanitizeInput($_POST["DIMENSION"]);
    $Link_Upcoming = sanitizeInput($_POST["Link"]);

    $sql = "UPDATE Upcoming_Movies SET Title_Upcoming = :Title_Upcoming, Poster_Upcoming = :Poster_Upcoming, Description_Upcoming = :Description_Upcoming, DATE_Upcoming = :DATE_Upcoming, DIMENSION_Upcoming = :DIMENSION_Upcoming, Link_Upcoming = :Link_Upcoming
  WHERE ID = :ID ;";
    $sth = $con->prepare($sql);# For security reasons we use 'Prepared-Statements'.
    # Then we bind the input data with the corresponding Table Column in the DB
    $sth->bindParam(':ID', $ID);
    $sth->bindParam(':Title_Upcoming', $Title_Upcoming);
    $sth->bindParam(':Poster_Upcoming', $Poster_Upcoming);
    $sth->bindParam(':Description_Upcoming', $Description_Upcoming);
    $sth->bindParam(':DATE_Upcoming', $DATE_Upcoming);
    $sth->bindParam(':DIMENSION_Upcoming', $DIMENSION_Upcoming);
    $sth->bindParam(':Link_Upcoming', $Link_Upcoming);
    # If an error occurs, try-catch helps to react to it
    if (!$sth->execute()) {
        echo "Fehler beim Ausführen der Abfrage: " . $sth->errorInfo();
        exit();
    }
    unset($_POST["editProd"]);
}
# Delete Row
if (isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];
    $sql = "DELETE FROM Upcoming_Movies WHERE ID = :ID;";
    $sth = $con->prepare($sql);
    $sth->bindParam(":ID", $deleteId);
    $sth->execute();
    unset($_POST["delete"]);// unset the variable for later use
}
// PHP Code that proves the Existence of input and sends them to the DB to save
if (isset($_POST["Title"]) && isset($_POST["Poster"]) && isset($_POST["Description"]) && isset($_POST["DATE"])
    && isset($_POST["DIMENSION"]) && isset($_POST["Link"]) && isset($_POST["addProd"])) {

    require_once "connection.php";
    $Title_Upcoming = sanitizeInput($_POST["Title"]);
    $Poster_Upcoming = sanitizeInput($_POST["Poster"]);
    $Description_Upcoming = sanitizeInput($_POST["Description"]);
    $DATE_Upcoming = $_POST["DATE"];
    $DIMENSION_Upcoming = $_POST["DIMENSION"];
    $Link_Upcoming = sanitizeInput($_POST["Link"]);
    var_dump($Title_Upcoming);
    $sql = "INSERT INTO Upcoming_Movies (Title_Upcoming, Poster_Upcoming, Description_Upcoming, DATE_Upcoming,  DIMENSION_Upcoming, Link_Upcoming) VALUES (:Title_Upcoming, :Poster_Upcoming, :Description_Upcoming , :DATE_Upcoming, :DIMENSION_Upcoming, :Link_Upcoming)";
    $sth = $con->prepare($sql);# For security reasons we use 'Prepared-Statements'.
    # Then we bind the input data with the corresponding Table Column in the DB
    $sth->bindParam(':Title_Upcoming', $Title_Upcoming);
    $sth->bindParam(':Poster_Upcoming', $Poster_Upcoming);
    $sth->bindParam(':Description_Upcoming', $Description_Upcoming);
    $sth->bindParam(':DATE_Upcoming', $DATE_Upcoming);
    $sth->bindParam(':DIMENSION_Upcoming', $DIMENSION_Upcoming);
    $sth->bindParam(':Link_Upcoming', $Link_Upcoming);
    # If an error occurs, try-catch helps to react to it
    try {
        $sth->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }

    unset($_POST["addProd"]);
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

    <table class="table"><!-- Use bootstrap to generate the Table -->
        <!-- Write Standard Table Head -->
        <thead>
        <tr>
            <th scope="col" class="col-1">ID</th>
            <th scope="col" class="col-1">Titel_Vorschau</th>
            <th scope="col" class="col-2">Plakat_Vorschau</th>
            <th scope="col" class="col-3">Beschreibung_Vorschau</th>
            <th scope="col" class="col-1">DATUM_Vorschau</th>
            <th scope="col" class="col-1">DIMENSION_Vorschau</th>
            <th scope="col" class="col-1">Link_Vorschau</th>
            <th scope="col" class="col-1"></th>
            <th scope="col" class="col-1"></th>
        </tr>
        </thead>

        <tbody>
        <?php
        # Get the Data for the table from the DB
        $sql = "SELECT * from Upcoming_Movies";
        $sth = $con->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            # For each Row on the DB , a Bootstrap table row will be generated, together with a 'Delete' and 'Change' as well as a Bootstrap modal for the Changes
            ?>
            <!-- Edit Upcoming Movie Modal -->
            <div class="modal fade" id="editModal<?php echo $item["ID"]; ?>" tabindex="-1"
                 aria-labelledby="editModal<?php echo $item["ID"]; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5"
                                id="exampleModalLabel"><?php echo $item["Title_Upcoming"]; ?> </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="Upcoming_Movies_edit.php" method="POST">
                            <div class="modal-body">
                                <label for="Title">Titel des neuen Films:</label>
                                <input type="text" id="Title" name="Title"> <br>
                                <label for="Poster">Plakat:</label>
                                <input type="text" id="Poster" name="Poster"><br>
                                <label for="Description">Film Beschreibung:</label>
                                <input type="text" id="Description" name="Description"><br>
                                <label for="DATE">Veröffentlichungsdatum:</label>
                                <input type="date" id="DATE" name="DATE"><br>

                                <label for="DIMENSION">Abmessung :</label>
                                <div class="col-md" id="DIMENSION">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelectGrid" name="DIMENSION">
                                            <option value="2D">2D</option>
                                            <option value="3D">3D</option>
                                        </select>
                                    </div>
                                </div>

                                <label for="Link">Link:</label>
                                <input type="text" id="Link" name="Link"><br>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                <button type="submit" name="editProd" value="<?php echo $item["ID"]; ?>"
                                        class="btn btn-primary">Änderungen speichern
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
                    <?php echo $item['Title_Upcoming'] ?>
                </td>

                <td>
                    <?php echo $item['Poster_Upcoming'] ?>
                </td>

                <td>
                    <?php echo $item['Description_Upcoming'] ?>
                </td>

                <td>
                    <?php echo $item['DATE_Upcoming'] ?>
                </td>


                <td>
                    <?php echo $item['DIMENSION_Upcoming'] ?>
                </td>

                <td>
                    <?php echo $item['Link_Upcoming'] ?>
                </td>

                <td>
                    <form action="Upcoming_Movies_edit.php" method="POST">
                        <!-- This button returns a form with only one value, which is used as a condition to execute a SQL statement and as ID value -->
                        <button name="editProd" value="<?php echo $item["ID"] ?>" type="button" class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal<?php echo $item["ID"] ?>">Bearbeiten
                        </button>
                    </form>
                </td>


                <td>
                    <form action="Upcoming_Movies_edit.php" method="POST">
                        <!-- This button returns a form with only one value, which is used as a condition to execute a SQL statement and as ID value -->
                        <button type="submit" name="delete" class="btn btn-primary" value="<?php echo $item['ID']; ?>">
                            Löschen
                        </button>
                    </form>
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>



    <!-- Bootstrap-Modal to give Data for new Upcoming Movies  -->
    <div class="col-4">
        <button type="button" class="btn btn-primary float-end ms-5 px-5" data-bs-toggle="modal"
                data-bs-target="#addModal">
            Füge einen Film hinzu
        </button>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModal">Füge einen Film hinzu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="Upcoming_Movies_edit.php" method="POST">
                    <!-- This form contains the data needed for a new Upcoming Movie   -->
                    <div class="modal-body container">
                        <label for="Title">Filmtitel:</label>
                        <input type="text" id="Title" name="Title"> <br>
                        <label for="Poster">Plakat :</label>
                        <input type="text" id="Poster" name="Poster"><br>
                        <label for="Description">Beschreibung :</label>
                        <input type="text" id="Description" name="Description"><br>
                        <label for="DATE">Datum :</label>
                        <input type="date" id="DATE" name="DATE"><br>
                        <label class="col-3" for="DIMENSION">Abmessung:</label>
                        <select name="DIMENSION" class="form-select col-8" aria-label="Dimensions Select Dropdown">
                            <option value="2D">2D</option>
                            <option value="3D">3D</option>
                        </select>
                        <label for="Link">Link:</label>
                        <input type="text" id="Link" name="Link"><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                        <button type="submit" name="addProd" value="1" class="btn btn-primary">Änderungen speichern</button>
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
# Fußzeile einbinden
require_once("footer.php");
?>