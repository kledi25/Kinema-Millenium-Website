<?php #Lea
session_start();
include_once "connection.php"; // Including the database connection
?>

<html>

<style>
    /* CSS Styles */
    body {
        background-image: linear-gradient(to bottom, #b70819 20%, #3b0303 55%);

    }

    .card-container {
        display: flex;
        flex-wrap: nowrap;
        margin: 40px;
        justify-content: space-evenly;
    }

    .card {
        flex: 0 0 auto;
        margin-right: 10px;
        padding-left: 5vh;
        padding-right: 5vh;
        padding-top: 2vh;
    }

    .card img {
        width: 100%;
        height: auto;
    }

    .centered {
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    h1 {
        display: flex;
        justify-content: center; /* Horizontally center the content */
        align-items: center; /* Vertically center the content */
    }

    .card-hover:hover {
        transform: scale(1.05); /* Increase size on hover */
        transition: transform 0.3s ease; /* Smooth transition effect */
    }


</style>


<body>
<!--PHP Navbar connection-->
<?php
include_once "navbar.php"; // Including the navigation bar
?>

<img src="images/program.jpg" width="100%"> <!-- Header Image -->
<div class="centered"><p style="font-size: 100px; font-weight: bold;">Programi</p></div> <!-- Header text -->

<br><br>
<h1 style="font-weight: bold;">Programi i dites se sotshme</h1> <!-- Heading for current programs -->

<div class="card-container">

    <!--Fetch data from the server-->
    <?php
    // Fetching data for current programs
    $sql = "SELECT ID,Title, Poster, Description, DATE, TIME, DIMENSION, Link FROM Content";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetching data for upcoming programs
    $sql_upcoming = "SELECT ID, Title_Upcoming, Poster_Upcoming, DATE_Upcoming, DIMENSION_Upcoming, Description_Upcoming, Link_Upcoming FROM Upcoming_Movies;";
    $stmt_upcoming = $con->prepare($sql_upcoming);
    $stmt_upcoming->execute();
    $result_upcoming = $stmt_upcoming->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <!-- Loop through current programs and display them in cards -->
    <div class='row justify-content-center m-0' >
        <?php foreach ($result as $row): ?>
            <div class="col-12 col-md-4" style="margin-top: 20px">
                <div class="card card-hover" style="width: 100%; text-align:center;">
                    <div class="card-body">
                        <h5 class="card-header"> <?= htmlspecialchars($row['Title']) ?> </h5>
                        <a href="reserve.php?movie_id=<?= htmlspecialchars($row['ID']) ?>">
                            <p class="card-img">
                                <img src="<?= htmlspecialchars($row['Poster']) ?>" style="width: 100%; max-height: 530px;" alt="<?= htmlspecialchars($row['Title']) ?>">
                            </p>
                        </a>
                        <p class="card-text"> <?= htmlspecialchars($row['Description']) ?> </p>
                        <p class="card-date-time"> Orari: <?= htmlspecialchars(date('Y-m-d H:i', strtotime($row['DATE'] . ' ' . $row['TIME']))) ?> </p>
                        <a href="reserve.php?movie_id=<?= htmlspecialchars($row['ID']) ?>" class="btn btn-dark" style="width: 100%">Rezervo</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
<br>

<h1>Se shpejti ne kinema</h1> <!-- Heading for upcoming programs -->

<div class="card-container">

    <!-- Loop through upcoming programs and display them in cards -->
    <div class='row justify-content-center m-0' >
        <?php foreach ($result_upcoming as $row_upcoming): ?>
            <div class="col-12 col-md-4" style="margin-top: 20px">
                <div class="card card-hover" style="width: 100%; text-align:center;">
                    <div class="card-body">
                        <h5 class="card-header"> <?= htmlspecialchars($row_upcoming["Title_Upcoming"]) ?> </h5>
                        <a href="reserve.php?movie_id=<?= htmlspecialchars($row_upcoming['ID']) ?>">
                            <p class="card-img">
                                <img src="<?= htmlspecialchars($row_upcoming['Poster_Upcoming']) ?>" style="width: 100%; max-height: 430px;" alt="<?= htmlspecialchars($row_upcoming["Title_Upcoming"]) ?>">
                            </p>
                        </a>
                        <p class="card-text"> <?= htmlspecialchars($row_upcoming['Description_Upcoming']) ?> </p>
                        <p class="card-date-time"> Orari: <?= htmlspecialchars(date('Y-m-d', strtotime($row_upcoming["DATE_Upcoming"]))) ?> </p>
                        <a href="reserve.php?movie_id=<?= htmlspecialchars($row_upcoming['ID']) ?>" class="btn btn-dark" style="width: 100%">Rezervo</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<br>


<!--Bootstrap JS link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

<?php
include_once "footer.php"; // Including the footer
?>

</body>
</html>
