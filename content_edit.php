<?php # Leo
session_start();
if (isset($_SESSION['Role'])) {# Überprüfung der Role der User, wenn er nicht der Role 'admin' ist, dann ist er zu Hauptseite geschickt
    if ($_SESSION['Role'] != 'admin') {
       header("location:index.php");
        exit();
    }
}else{
   header("location:index.php");
    exit();
}

require_once 'navbar.php';
require_once 'connection.php';
?>
<style>/* Schrift Farbe zu schwarz setzen */
    .modal {
        color: black;
    }

    li {
        color: black;
    }

</style>

<table class="table"><!-- Bootstrap nutzen zum generierung einer tabelle -->
    <!--  Table Head (Erste Zeile in eine Tabelle, die die Namen der Spalten zeigt) -->
    <thead>
    <tr>
        <th scope="col" class="col-1">ID</th>
        <th scope="col" class="col-1">Title</th>
        <th scope="col" class="col-2">Poster</th>
        <th scope="col" class="col-3">Description</th>
        <th scope="col" class="col-1">DATE</th>
        <th scope="col" class="col-1">TIME</th>
        <th scope="col" class="col-1">DIMENSION</th>
        <th scope="col" class="col-1">Link</th>
        <th scope="col" class="col-1"></th>
        <th scope="col" class="col-1"></th>
    </tr>
    </thead>

    <tbody>
    <?php
    # Die daten, die in die Tabelle gezeigt werden, abrufen.
    $sql = "SELECT * from Content";
    $sth = $con->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $item) {# Für jede Zeile von der DB bekommen, wird eine Zeile generiert , zusätzlich eine 'Löschen' und 'Ändern' Taste
        ?>
        <!--------------------------------------edit prod Modal content--------------------------------------------------->
        <div class="modal fade" id="editModal<?php echo $item["ID"] ;?>" tabindex="-1"
             aria-labelledby="editModal<?php echo $item["ID"] ;?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $item["Title"] ;?> </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="content_edit.php" method="POST">
                        <div class="modal-body">
                            <label for="Title">Titulli i filmit te ri:</label>
                            <input type="text" id="Title" name="Title"> <br>
                            <label for="Poster">Poster:</label>
                            <input type="text" id="Poster" name="Poster"><br>
                            <label for="Description">Pershkrim i filmit:</label>
                            <input type="text" id="Description" name="Description"><br>
                            <label for="DATE">Data e paraqitjes:</label>
                            <input type="date" id="DATE" name="DATE"><br>
                            <label for="TIME">Ora e paraqitjes:</label>
                            <input type="time" id="TIME" name="TIME"><br>

                            <label for="DIMENSION">Dimensionet :</label>
                            <div class="col-md" id="DIMENSION">
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelectGrid" name="DIMENSION">
                                        <option selected>Zgjidh Dimensionin</option>
                                        <option value="2D">2D</option>
                                        <option value="3D">3D</option>
                                    </select>
                                </div>
                            </div>

                            <label for="Link">Link:</label>
                            <input type="text" id="Link" name="Link"><br>

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
                <?php echo $item['Title'] ?>
            </td>

            <td>
                <?php echo $item['Poster'] ?>
            </td>

            <td>
                <?php echo $item['Description'] ?>
            </td>

            <td>
                <?php echo $item['DATE'] ?>
            </td>

            <td>
                <?php echo $item['TIME'] ?>
            </td>

            <td>
                <?php echo $item['DIMENSION'] ?>
            </td>

            <td>
                <?php echo $item['Link'] ?>
            </td>

            <td>
                <form action="content_edit.php" method="POST">
                    <button name="editProd" value="<?php echo $item["ID"] ?>" type="button" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal<?php echo $item["ID"] ?>">Ndrysho
                    </button>
                </form>
            </td>


            <td>
                <form action="content_edit.php" method="POST">
                    <button type="submit" name="delete" class="btn btn-primary" value="<?php echo $item['ID']; ?>">Fshij
                    </button>
                </form>
            </td>
        </tr>

    <?php } ?>

    </tbody>

</table>



<!------------------------------------------------ Add a product modal ------->
<div class="col-4">
    <button type="button" class="btn btn-primary float-end ms-5 px-5" data-bs-toggle="modal" data-bs-target="#addModal">
        Shto nje film
    </button>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModal">Shto nje film</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="content_edit.php" method="POST">
                <div class="modal-body container">
                    <label for="Title">Emri i Filmit:</label>
                    <input type="text" id="Title" name="Title"> <br>
                    <label for="Poster">Poster :</label>
                    <input type="text" id="Poster" name="Poster"><br>
                    <label for="Description">Pershkrimi :</label>
                    <input type="text" id="Description" name="Description"><br>
                    <label for="DATE">Data :</label>
                    <input type="date" id="DATE" name="DATE"><br>
                    <label for="TIME">Ora :</label>
                    <input type="time" id="TIME" name="TIME"><br>
                    <label class="col-3" for="DIMENSION">Dimensioni:</label>
                    <select name="DIMENSION" class="form-select col-8" aria-label="Dimensions Select Dropdown">
                        <option value="2D">2D</option>
                        <option value="3D">3D</option>
                    </select>
                    <label for="Link">Link:</label>
                    <input type="text" id="Link" name="Link"><br>

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
//----------------------------------------------Edit poruduct
if (isset($_POST["editProd"]) && isset($_POST["Title"]) && isset($_POST["Poster"]) && isset($_POST["Description"]) && isset($_POST["DATE"])
    && isset($_POST["TIME"]) && isset($_POST["DIMENSION"]) && isset($_POST["Link"])) {
    require_once "connection.php";
    $ID = sanitizeInput($_POST["editProd"]);
    $Title = sanitizeInput($_POST["Title"]);
    $Poster = sanitizeInput($_POST["Poster"]);
    $Description = sanitizeInput($_POST["Description"]);
    $DATE = sanitizeInput($_POST["DATE"]);
    $TIME = sanitizeInput($_POST["TIME"]);
    $DIMENSION = sanitizeInput($_POST["DIMENSION"]);
    $Link = sanitizeInput($_POST["Link"]);

    $sql = "UPDATE Content SET Title = :Title, Poster = :Poster, Description = :Description, DATE = :DATE, TIME = :TIME, DIMENSION = :DIMENSION, Link = :Link
  WHERE ID = :ID ;";
    $sth = $con->prepare($sql);
    $sth->bindParam(':ID', $ID);
    $sth->bindParam(':Title', $Title);
    $sth->bindParam(':Poster', $Poster);
    $sth->bindParam(':Description', $Description);
    $sth->bindParam(':DATE', $DATE);
    $sth->bindParam(':TIME', $TIME);
    $sth->bindParam(':DIMENSION', $DIMENSION);
    $sth->bindParam(':Link', $Link);
    $sth->execute();
    unset($_POST["editProd"]);
}
?>






<?php
//----------------------------------------------delete Content
if (isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];
    $sql = "DELETE FROM Content WHERE ID = :ID;";
    $sth = $con->prepare($sql);
    $sth->bindParam(":ID", $deleteId);
    $sth->execute();
}
?>


<?php
//----------------------------------------------add Product
if (isset($_POST["Title"]) && isset($_POST["Poster"]) && isset($_POST["Description"]) && isset($_POST["DATE"])
    && isset($_POST["TIME"]) && isset($_POST["DIMENSION"]) && isset($_POST["Link"]) && isset($_POST["addProd"])) {

    require_once "connection.php";
    $Title = sanitizeInput($_POST["Title"]);
    $Poster = sanitizeInput($_POST["Poster"]);
    $Description = sanitizeInput($_POST["Description"]);
    $DATE = $_POST["DATE"];
    $TIME = $_POST["TIME"];
    $DIMENSION = $_POST["DIMENSION"];
    $Link = sanitizeInput($_POST["Link"]);

    $sql = "INSERT INTO Content (Title, Poster, Description, DATE, TIME, DIMENSION, Link) VALUES (:Title, :Poster, :Description , :DATE, :TIME, :DIMENSION, :Link)";
    $sth = $con->prepare($sql);
    $sth->bindParam(':Title', $Title);
    $sth->bindParam(':Poster', $Poster);
    $sth->bindParam(':Description', $Description);
    $sth->bindParam(':DATE', $DATE);
    $sth->bindParam(':TIME', $TIME);
    $sth->bindParam(':DIMENSION', $DIMENSION);
    $sth->bindParam(':Link', $Link);
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
require_once("footer.php");
?>
