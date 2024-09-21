<?php
// Start of the session
session_start();

// Integration of the connection to the database
require_once("connection.php");

// Editing a user
if (
    isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["pwd"]) && isset($_POST["email"]) && isset($_POST["role"])
) {
    // Retrieve the entered user data
    $id = $_POST["editUser"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["pwd"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Adding password verification by regular expression
    $password_regex = "/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[_,.#?!@$%^&*=-]).{8,}$/";
    $pwdREGEXfail = !preg_match($password_regex, $password);

    // Check whether the password meets the requirements
    if (!$pwdREGEXfail) {
        // Hashing the password
        $pwdHash = password_hash($password, PASSWORD_DEFAULT);

        // Preparing and executing the SQL query to update the user
        $sql = "UPDATE Benutzer SET FirstName = :firstName, LastName = :lastName, Role = :role, email = :email, PASSWORD = :pwd WHERE ID = :ID";
        $sth = $con->prepare($sql);
        if (!$sth) {
            die('Error in preparing the query: ' . $con->errorInfo()[2]);
        }
        $sth->bindParam(':firstName', $firstName);
        $sth->bindParam(':lastName', $lastName);
        $sth->bindParam(':email', $email);
        $sth->bindParam(':pwd', $pwdHash);
        $sth->bindParam(':role', $role);
        $sth->bindParam(':ID', $id);
        if (!$sth->execute()) {
            die('Error in executing the query: ' . $sth->errorInfo()[2]);
        }
        // Forwarding to the user edit page
        header("location:user_edit.php");
    } else {
        // Display of an error message if the password does not meet the requirements
        echo '<script>alert("Password must contain at least one uppercase letter, one digit, and one special character, and be at least 8 characters long.");</script>';
    }
}
?>
<title>User Edit</title>
<?php
// Integration of the navigation bar
require_once("navbar.php");
?>

<main class="my-3">
    <h1 class="d-flex justify-content-center m-3">Edit User</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Emri</th>
            <th scope="col">Mbiemri</th>
            <th scope="col">Email</th>
            <th scope="col">Roli</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Retrieve all users from the database and display them in a table
        $sql = "SELECT * FROM Benutzer";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item) {
            ?>
            <tr>
                <td scope="row"><?php echo $item['FirstName']; ?><br></td>
                <td scope="row"><?php echo $item['LastName']; ?><br></td>
                <td scope="row"><?php echo $item['email']; ?><br></td>
                <td scope="row"><?php echo $item['Role']; ?><br></td>
                <td>
                    <!-- Button to open the editing mode for the corresponding user -->
                    <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editModal<?php echo $item["ID"]; ?>">
                        Edit
                    </button>
                </td>
                <!-- Editing modal -->
                <div class="modal fade" style="color: black" id="editModal<?php echo $item["ID"]; ?>" tabindex="-1"
                     aria-labelledby="editModal<?php echo $item["ID"]; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5"
                                    id="exampleModalLabel"><?php echo $item["FirstName"]; ?> </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <!-- Form for editing the user -->
                            <form action="user_edit.php" method="POST">
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <!-- Input field for the user ID (hidden) -->
                                            <input type="hidden" class="form-control" name="id"
                                                   value="<?php echo $item['ID'] ?>">
                                        </div>
                                        <div class="row">
                                            <!-- Input field for the first name -->
                                            <div class="mb-3">
                                                <label for="firstName" class="form-label">Emri</label>
                                                <input type="text" class="form-control" name="firstName"
                                                       id="firstName" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Input field for the surname -->
                                            <div class="mb-3">
                                                <label for="LastName" class="form-label">Mbiemri</label>
                                                <input type="text" class="form-control" name="lastName"
                                                       id="lastName" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Input field for the e-mail address -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Emaili</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                       aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Input field for the password -->
                                            <div class="mb-3">
                                                <label for="pwd" class="form-label">Passwordi</label>
                                                <input type="password" class="form-control" name="pwd" id="pwd"
                                                       aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Input field for the user role -->
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Roli</label

                                                <div class="row">
                                            <br>
                                            <button type="submit" name="editUser" value="<?php echo $item["ID"]; ?>"
                                                    class="btn btn-primary">Save changes
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</main>
<?php
require "footer.php";
?>


