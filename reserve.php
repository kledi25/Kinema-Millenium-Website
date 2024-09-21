<?php # Leo
session_start();
if (!isset($_SESSION['Role'])) {
    # Check the role of the user, if no role is available, it means that the user is not logged in, and is sent to the login page instead
    header("location:login.php");
    exit();
}
require_once 'connection.php';
require_once 'navbar.php';

$UserID = $_SESSION["ID"];
$ID = $_GET["movie_id"];
# Get data from DB using the GET variable containing the ID of the film
$sql = "SELECT * from Content where ID = :ID";
$sth = $con->prepare($sql);
$sth->bindParam(':ID', $ID);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$movies = $result[0];

$MovieTitle = sanitizeInput($movies['Title']);
$UserID = sanitizeInput($UserID);
$DATE = sanitizeInput($movies['DATE']);
$TIME = sanitizeInput($movies['TIME']);

if (isset($_POST["Seats"])) {
    $_SESSION["SEATS"] = $_POST["SeatNr"];
}

if (isset($_POST["reserve"]) && !empty($_SESSION["SEATS"])) {
# This code sends data to DB when the 'reserve' button is pressed and the customer has selected Sitting.
    foreach ($_SESSION["SEATS"] as $SeatNr) {
        $SeatNr = sanitizeInput($SeatNr);
        $sql = "INSERT INTO Reservations (MovieTitle,  DATE, TIME, SeatNr, UserID, MovieID) VALUES (:MovieTitle,  :DATE, :TIME, :SeatNr, :UserID, :MovieID)";
        $sth = $con->prepare($sql);
        $sth->bindParam(':MovieTitle', $MovieTitle);
        $sth->bindParam(':DATE', $DATE);
        $sth->bindParam(':TIME', $TIME);
        $sth->bindParam(':SeatNr', $SeatNr);
        $sth->bindParam(':UserID', $UserID);
        $sth->bindParam(':MovieID', $ID);
        $sth->execute();
    }
# These variables are deleted so that the customer can reuse them without mixing the data
    unset($_SESSION["SEATS"]);
    unset($_POST["reserve"]);
}


# This code collects the previously booked seats from the DB so that other customers
$sql = "SELECT SeatNr from Content c join Reservations r on  c.ID=r.MovieID where r.MovieID= :ID ";
$sth = $con->prepare($sql);
$sth->bindParam(':ID', $ID);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$resSeats = [];
foreach ($result as $key => $val) {
    foreach ($val as $nKey => $nVal) {
        $resSeats[] = $nVal;
    }
}


?>
    <style>
        /* Distance with the left end of the screen */
        .padLeft {
            padding-left: 20vw;
        }


        div {
            margin: 0;
            padding: 0;
            border: 0;
        }

        /* Hide the default checkbox */
        input[type="checkbox"] {
            display: none;
        }

        /* Customize the appearance of the custom checkbox */
        input[type="checkbox"] + label:before {
            content: url('images/armchair.png'); /* seat icon or any other icon you want to use */
            font-size: 2vw; /* adjust the font size as needed */
            display: inline-block;
            width: 2vw; /* adjust the width as needed */
            min-width: 15px;
            height: 2vw; /* adjust the height as needed */
            min-height: 15px;
            line-height: 2vw; /* center the icon vertically */
            text-align: center; /* center the icon horizontally */
            background-color: #ccc; /* default background color */
            border-radius: 50%; /* make the background round */
            margin: 0.7vw;
        }

        /* Change appearance when checkbox is checked */
        input[type="checkbox"]:checked + label:before {
            background-color: #00f; /* blue background when checked */
        }

        /* Change appearance when checkbox is disabled */
        input[type="checkbox"]:disabled + label:before {
            background-color: #f00; /* red background when disabled */
        }


    </style>

    <div class="container-fluid w-100 mb-5 ps-4 ps-sm-2 padLeft">
        <div class="row align-items-center justify-content-center">

            <div class="col-12 col-sm-6 mt-5 d-flex space-around">
                <form action="reserve.php?movie_id=<?php echo $_GET["movie_id"]; ?>" method="POST">
                    <?php
                    # generate 7 rows with 10 seats
                    for ($i = 0; $i < 7; $i++) {
                        for ($j = 0; $j < 10; $j++) {
                            ?>
                            <!-- Each checkbox has its own ID, which we need to give a suitable label (it does not work without a label).  -->
                            <!-- Each checkbox has an ID check to check if these seats are already booked, and if this is the case, declare the input field as 'disabled' -->
                            <input type="checkbox" id="customCheckbox<?php echo $i . $j ?>" name="SeatNr[]"
                                   value="<?php echo $i . $j ?>" <?php if (in_array($i . $j, $resSeats)) {
                                echo "disabled";
                            } ?>>
                            <label for="customCheckbox<?php echo $i . $j ?>"></label>
                        <?php } ?>
                        <br>
                    <?php } ?>
                    <button type="submit" name="Seats" value="1"
                            class="btn btn-primary w-100 me-5">Zgjidh Ndenjeset
                    </button>
                </form>
            </div>


            <div class="col-12 col-sm-6 mt-5 " style=" color:black !important;">
                <form action="reserve.php?movie_id=<?php echo $_GET["movie_id"]; ?>" method="POST"
                      class="row align-items-center justify-content-center">
                    <div class="modal-body">
                        <!-- In this form customers do not enter any information, but here they can make sure that the booking that is being made is the booking they want -->
                        <label for="MovieTitle">Titulli i filmit : <?php echo $MovieTitle; ?></label> <br>
                        <label for="DATE">Data e paraqitjes: <?php echo $DATE; ?></label><br>
                        <label for="DATE">Ora e paraqitjes: <?php echo $TIME; ?></label><br>
                        <label for="SeatNr">Ndenjesa/Ndenjeset e zgjedhura <?php if (isset($_POST["SeatNr"])) {
                                if (count($_POST["SeatNr"]) != 0) { # Simple calculation to give the price (400 AL per ticket)
                                    foreach ($_POST["SeatNr"] as $seatNr) {
                                        echo " :";
                                        echo $seatNr;
                                    }
                                }
                            }
                            ?> </label>
                        <br>
                        <label for="Price">Cmimi total: <?php if (isset($_POST["SeatNr"])) {
                                echo(count($_POST["SeatNr"]) * 400);
                            } ?> </label><br>
                        <!-- The button is required to send the SQL statement -->
                        <button type="submit" name="reserve" value="1"
                                class="btn btn-primary w-75">Prenoto Ndenjeset
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </div>


<?php
$str = 'ä ö ü ß < > & " \'';
$str = htmlspecialchars($str);
function sanitizeInput($input): string
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

require_once 'footer.php';
?>