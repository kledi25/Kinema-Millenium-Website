<?php
session_start();

require_once 'connection.php';
require_once 'navbar.php';

// Check if the form is submitted
if (isset($_POST["delete"])) {
    // Get the ID of the comment to delete from the form submission
    $deleteId = $_POST["delete"];

    // SQL query to delete a comment with the specified ID
    $sql = "DELETE FROM Comments WHERE ID = :ID;";

    // Prepare the SQL statement
    $sth = $con->prepare($sql);

    // Bind the comment ID parameter
    $sth->bindParam(":ID", $deleteId);

    // Execute the SQL statement
    $sth->execute();
}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/logoja.svg" type="image/svg+xml">
    <title>Comment Editing</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<style>
    table {
        margin: 3vh;
        width: 60%;
    }

    li {
        color: black;
    }

</style>

<body>
<div class="container">
    <!-- HTML Table Structure -->
    <table class="table table-responsive table-striped table-hover table-sm">
        <thead>
        <tr>
            <th scope="col" class="col-2">ID</th>
            <th scope="col" class="col-4">Text</th>
            <th scope="col" class="col-5">User Email</th>
            <th scope="col" class="col-1"></th>
        </tr>
        </thead>

        <tbody>
        <?php
        // SQL query to select all comments
        $sql = "SELECT * from Comments";
        $sth = $con->prepare($sql);
        $sth->execute();
        // Fetch all comments as an associative array
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each comment in the result set
        foreach ($result as $item) {
            ?>
            <tr>
                <!-- Display the comment ID -->
                <td><?php echo $item['ID'] ?></td>

                <!-- Display the comment text -->
                <td><?php echo $item['TEXT'] ?></td>

                <!-- Display the user email associated with the comment -->
                <td><?php echo $item['UserEmail'] ?></td>

                <!-- Form to delete a comment -->
                <td>
                    <form action="comments_edit.php" method="POST">
                        <!-- Hidden input to pass the comment ID -->
                        <input type="hidden" name="delete" value="<?php echo $item['ID']; ?>">
                        <!-- Button to submit the form and delete the comment -->
                        <button type="submit" class="btn btn-dark" style="border: none">Fshij</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

</body>




