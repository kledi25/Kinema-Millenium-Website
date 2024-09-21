<?php
session_start();
require_once 'navbar.php';
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("location: index.php");
    exit();
}

$userID = $_SESSION['UserID'];

?>
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
    // Fetch reservations for the logged-in user
    $sql = "SELECT * FROM Reservations WHERE UserID = :userID";
    $sth = $con->prepare($sql);
    $sth->bindParam(':userID', $userID);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    // Display the reservations
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>{$row['ID']}</td>";
        echo "<td>{$row['MovieTitle']}</td>";
        echo "<td>{$row['DATE']}</td>";
        echo "<td>{$row['TIME']}</td>";
        echo "<td>{$row['SeatNr']}</td>";
        echo "<td>{$row['UserID']}</td>";
        echo "<td><!-- Your action button or link here --></td>";
        echo "<td><!-- Another action button or link here --></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php
require_once 'footer.php';
?>
