<?php
session_start();


require_once("navbar.php"); ?>

<title>User</title>

<style>
    body {
        background-color: black;
    }

    form {
        border: 2px solid white;
        padding: 20px;
        position: relative;
        background-image: url('images/user_foto.jpg');
        background-size: cover;
        background-position: center;
        text-align: center;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 250px;
        padding: 8px;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #ffffff;
        color: black;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #dddddd;
    }
</style>

<?php

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include_once("connection.php");
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["newFirstName"]) && isset($_POST["newLastName"])) {
        $newFirstName = sanitizeInput($_POST["newFirstName"]);
        $newLastName = sanitizeInput($_POST["newLastName"]);


        $updateStmt = $con->prepare("UPDATE Benutzer SET FirstName = :newFirstName, LastName = :newLastName WHERE email = :email");
        $updateStmt->execute(["newFirstName" => $newFirstName, "newLastName" => $newLastName, "email" => $email]);
        $_SESSION["FirstName"] = $newFirstName;
        $_SESSION["LastName"] = $newLastName;
    }

    // Handling password update
    if (isset($_POST["oldPassword"]) && isset($_POST["newPassword"])) {
        $oldPassword = sanitizeInput($_POST["oldPassword"]);
        $newPassword = sanitizeInput($_POST["newPassword"]);


        $stmt = $con->prepare("SELECT password FROM Benutzer WHERE email = :email");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($oldPassword, $user['password'])) {
            $newPwdHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePwdStmt = $con->prepare("UPDATE Benutzer SET password = :newPassword WHERE email = :email");
            $updatePwdStmt->execute(["newPassword" => $newPwdHash, "email" => $email]);

            echo '<table border="1">';
            echo '<tr><th>Password Change Successful</th></tr>';
            echo '<tr><td>Your password has been updated successfully!</td></tr>';
            echo '</table>';
        } else {
            echo '<table border="1">';
            echo '<tr><th>Password Change Failed</th></tr>';
            echo '<tr><td>Incorrect old password. Please try again.</td></tr>';
            echo '</table>';
        }
    }

    if (isset($_POST["newEmail"])) {
        $newEmail = sanitizeInput($_POST["newEmail"]);

        // Ob der Email gerade verwendet ist von andere Personen
        $emailCheckStmt = $con->prepare("SELECT * FROM Benutzer WHERE email = :newEmail AND email != :email");
        $emailCheckStmt->execute(["newEmail" => $newEmail, "email" => $email]);
        $existingEmail = $emailCheckStmt->fetch();

        if (!$existingEmail) {
            // Update the user's email in the database
            $updateEmailStmt = $con->prepare("UPDATE Benutzer SET email = :newEmail WHERE email = :email");
            $updateEmailStmt->execute(["newEmail" => $newEmail, "email" => $email]);

            $_SESSION["email"] = $newEmail;

            header("Location: index.php");
            exit();
        }
    }
}

function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<h1>Edit Profile</h1><br>
<form method="POST" enctype="multipart/form-data">
    <label for="newFirstName">New First Name:</label>
    <input type="text" id="newFirstName" name="newFirstName" value="<?php echo $_SESSION['FirstName']; ?>"><br><br>

    <label for="newLastName">New Last Name:</label>
    <input type="text" id="newLastName" name="newLastName" value="<?php echo $_SESSION['LastName']; ?>"><br><br>

    <label for="newEmail">New Email:</label>
    <input type="email" id="newEmail" name="newEmail" value="<?php echo $_SESSION['email']; ?>"><br><br>

    <label for="oldPassword">Old Password:</label>
    <input type="password" id="oldPassword" name="oldPassword" required><br><br>

    <label for="newPassword">New Password:</label>
    <input type="password" id="newPassword" name="newPassword" required><br><br>

    <input type="submit" value="Save Changes">
</form>

<br>
<h1>User Bookings</h1>

<?php
$userID = $_SESSION['ID'];

try {
    // Fetch reservations for the logged-in user
    $sql = "SELECT * FROM Reservations WHERE UserID = :userID";
    $sth = $con->prepare($sql);
    $sth->bindParam(':userID', $userID);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    // Reservations zeigen mit echo
    if ($result) {
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Movie Title</th>';
        echo '<th>Date</th>';
        echo '<th>Time</th>';
        echo '<th>Seat Number</th>';
        echo '<th>User ID</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>{$row['ID']}</td>";
            echo "<td>{$row['MovieTitle']}</td>";
            echo "<td>{$row['DATE']}</td>";
            echo "<td>{$row['TIME']}</td>";
            echo "<td>{$row['SeatNr']}</td>";
            echo "<td>{$row['UserID']}</td>";
            echo "</tr>";
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No bookings found.</p>';
    }
} catch (PDOException $e) {
    // Handle database errors gracefully
    echo "Error: " . $e->getMessage();
}
?>

