<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
<?php #Kledi
require_once("connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="images/logoja.svg" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/db0af3c443.js" crossorigin="anonymous"></script>

</head>
<style>
    body, .navbar, .navbar-nav, .nav-link, a {
        color: white !important;
    }

    .navbar-collapse {
        color: white !important;
    }
    .navbar {
        background: rgba(0, 0, 0, 0.5); /* Adjust the last number for transparency */
    }
</style>
<body id="nav">


<header>
    <nav class="navbar navbar-expand-sm bg-dark text-white">
        <div class="container-fluid text-white">
            <a class="navbar-brand" href="index.php">
                <img src="images\logoja.svg" alt="Logo" width="30" height="24"
                     class="d-inline-block align-text-top text-white">
                Millennium <!-- Add the name and the logo of the Website -->
            </a>
            <!-- Create the toggler for the responsive Website -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="program.php">Programi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trailer.php">Trailerat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php">Rreth nesh</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION["email"])) {
                        if (isset($_SESSION["Role"]) && $_SESSION["Role"] == "admin") {

                            // User is an admin
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="admin.php"><i class="fa-solid fa-user-pen" style="color: #d21919;"></i>Admin</a>';
                            echo '</li>';
                        } else {
                            // User is not an admin
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="user.php"><i class="fa-solid fa-user" style="color: #d21919;"></i> ' . $_SESSION["FirstName"] . " " . $_SESSION["LastName"] . '</a>';
                            echo '</li>';
                        }

                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" style="color: #d21919;"></i>Logout</a>';
                        echo '</li>';
                    } else {
                        // User is not logged in
                        echo ' <li class="nav-item">';
                        echo ' <a class="nav-link" href="login.php"> <i class="fa-solid fa-right-to-bracket" style="color: #d21919;"></i> Hyr</a>';
                        echo '</li>';
                        echo ' <li class="nav-item">';
                        echo ' <a class="nav-link" href="register.php"><i class="fa-solid fa-user-plus" style="color: #de1717;"></i> Regjistrohu</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

