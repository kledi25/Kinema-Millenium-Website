<?php
// Starte die Session
session_start();

// Verbinde mit der Datenbank
require_once "connection.php";

// Füge die Navigationsleiste hinzu
require_once "navbar.php";
?>

    <!-- Meta-Daten für die Ansicht auf mobilen Geräten -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trailerat</title>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyDcrossorigin="anonymous"></script>

    <!-- CSS-Styling -->
    <style>
        /* General Styles */
        body {
            background-image: linear-gradient(to bottom right, #bb2121, #670707);
        }

        .carousel-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            z-index: 2;
        }

        .card-img {
            height: 500px;
            object-fit: cover;
        }

        .text-bigger {
            font-size: 4.1em;
        }

        .carousel-inner {
            height: 600px;
        }

        .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        h1 {
            font-size: 2em;
            text-align: center;
            color: white;
        }

        .container {
            margin-top: 20px;
        }

        .carousel-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .arrow {
            animation: bouncing 1s infinite ease-in-out;
            bottom: 0;
            display: block;
            height: 50px;
            left: 50%;
            margin-left: -25px;
            position: absolute;
            width: 50px;
        }

        @keyframes bouncing {
            0% {bottom: 0;}
            50% {bottom: 20px;}
            100% {bottom: 0;}
        }

        #scroll-arrow svg {
            transition: transform 0.3s ease-in-out;
        }

        #scroll-arrow:hover svg {
            transform: scale(1.2);
        }

        #scroll-arrow.upwards svg {
            transform: rotate(180deg);
        }

        /* Responsive CSS */
        @media (max-width: 768px) {
            .text-bigger {
                font-size: 3em;
            }

            .card-img {
                max-height: 100px;
            }

            h1 {
                font-size: 1.5em;
            }

            .carousel-inner {
                height: 400px;
            }

            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px; /* Add space between cards */
            }
        }

        @media (max-width: 576px) {
            .carousel-caption {
                text-align: center;
                width: 100%;
                left: 0;
                right: 0;
            }

            .text-bigger {
                font-size: 2em;
            }

            .card-img {
                max-height: 150px;
            }

            h1 {
                font-size: 1.2em;
            }

            .carousel-inner {
                height: 300px;
            }

            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px; /* Add space between cards */
            }
        }

        @media (max-width: 768px) {
            .carousel {
                display: none;
            }

            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px; /* Add space between cards */
            }
        }
    </style>
    <style>
        /* Add this style to rotate the arrow when it points upwards */
        #scroll-arrow.upwards svg {
            transform: rotate(180deg);
        }
    </style>

    <!-- Carousel für Videos -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
        <div class="carousel-indicators">
            <!-- Indikatoren für die Carousel-Slides -->
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style=" height: 600px;">
            <!-- Carousel-Inhalt -->
            <div class="carousel-item active">
                <!-- Aktives Slide -->
                <video class="video" muted autoplay="autoplay" loop="loop" preload="auto">
                    <source src="Videos/nktd.mp4"></source>
                </video>
            </div>
            <div class="carousel-item">
                <!-- Slide 2 -->
                <video class="video" muted autoplay="autoplay" loop="loop" preload="auto">
                    <source src="Videos/pptm.mp4"></source>
                </video>
            </div>
            <div class="carousel-item">
                <!-- Slide 3 -->
                <video class="video" muted autoplay="autoplay" loop="loop" preload="auto">
                    <source src="Videos/fnaf.mp4"></source>
                </video>
            </div>
        </div>
        <!-- Navigationsbuttons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <br>
<?php
$sql = "SELECT ID, Title, Poster, DATE, TIME, DIMENSION, Link FROM Content;";
$stmt = $con->prepare($sql);

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_upcoming = "SELECT ID, Title_Upcoming, Poster_Upcoming, DATE_Upcoming, DIMENSION_Upcoming, Link_Upcoming FROM Upcoming_Movies;";
$stmt_upcoming = $con->prepare($sql_upcoming);
$stmt_upcoming->execute();
$result_upcoming = $stmt_upcoming->fetchAll(PDO::FETCH_ASSOC);

?>

<br>
<div class="container movies">
    <h1 style="display: flex; justify-content: center; margin-bottom: 20px">Filmat e kesaj jave</h1>
    <?php
    echo "<div class='container'>";
    echo "<div class='row'>";
    foreach ($result as $row) {
        echo '<div class="col col-md-4">';
        echo ' <div class="card" style="width: 100%; text-align:center;">';
        echo '    <div class="card-body">';
        echo '    <h5 class="card-header"> ' . $row["Title"] . '</h5>';

        echo '    <a href="reserve.php?movie_id=' . $row["ID"] . '">';

        echo '        <p class="card-img" style="width: 100%; max-height: 530px; overflow: hidden;">';
        echo '            <img src="' . $row["Poster"] . '" style="width: 100%; height: auto;" alt="' . $row["Title"] . '">';
        echo '        </p>';
        echo '    </a>';
        echo '    <b><p class="card-text"><i class="fa-regular fa-calendar-xmark"></i> ' . $row["DATE"] . '</p></b>';

        $time = DateTime::createFromFormat('H:i:s', $row["TIME"]);
        $formattedTime = $time->format('H:i');

        echo '    <b><p class="card-text"><i class="fa-regular fa-clock"></i> ' . $formattedTime . '</p></b>';

        echo '   <b> <p class="card-text">' . $row["DIMENSION"] . '</p> </b>';
        echo '            </div>';
        echo '        </div>';
        echo ' </div>';
    }
    echo '</div>';
    echo '</div>';
    ?>
</div>
<br>
<br>

<div class="container-fluid upcoming_movies bg-dark" style="margin-top: 30px">
    <h1 style="display: flex; justify-content: center; margin-bottom: 20px; margin-top: 20px">Se Shpejti ne Kinema </h1>
    <?php
    echo "<div class='container bg-dark' style='margin-top:20px'>";
    echo "<div class='row'>";
    foreach ($result_upcoming as $row_upcoming) {
        echo '<div class="col col-md-4" style="margin-top: 30px">';
        echo ' <div class="card" style="width: 100%; text-align:center;">';
        echo '    <div class="card-body">';
        echo '    <h5 class="card-header"> ' . $row_upcoming["Title_Upcoming"] . '</h5>';
        echo '    <a href="'. $row_upcoming["Link_Upcoming"] .'">';
        echo '        <p class="card-img" style="width: 100%; max-height: 530px; overflow: hidden;">';
        echo '            <img src="' . $row_upcoming["Poster_Upcoming"] . '" style="width: 100%; height: auto;" alt="' . $row_upcoming["Title_Upcoming"] . '">';
        echo '        </p>';
        echo '    </a>';
        echo '    <b><p class="card-text"><i class="fa-regular fa-calendar-xmark"></i> ' . $row_upcoming["DATE_Upcoming"] . '</p></b>';
        echo '   <b> <p class="card-text">' . $row_upcoming["DIMENSION_Upcoming"] . '</p> </b>';
        echo '            </div>';
        echo '        </div>';
        echo ' </div>';
    }
    echo '</div>';
    echo '</div>';
    ?>
</div>


<div id="scroll-arrow" style="position: fixed; bottom: 20px; right: 20px; cursor: pointer; display: none;">
    <i class="fas fa-arrow-down fa-2x"></i>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollArrow = document.getElementById("scroll-arrow");
        const headings = document.querySelectorAll("h1");

        window.addEventListener("scroll", function () {
            const windowHeight = window.innerHeight;
            const scrollY = window.scrollY || window.pageYOffset;

            // Adjust the offset based on your design
            const offset = 50;

            if (scrollY > offset) {
                scrollArrow.style.display = "block";
            } else {
                scrollArrow.style.display = "none";
            }

            // Check if already at the bottom
            const isAtBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight;

            if (isAtBottom) {
                scrollArrow.classList.add("upwards");
            } else {
                scrollArrow.classList.remove("upwards");
            }
        });

        scrollArrow.addEventListener("click", function () {
            const currentScroll = window.scrollY || window.pageYOffset;
            let foundHeading = false;

            for (let i = 0; i < headings.length; i++) {
                const headingOffset = headings[i].offsetTop;

                if (headingOffset > currentScroll) {
                    headings[i].scrollIntoView({ behavior: "smooth" });
                    foundHeading = true;
                    break;
                }
            }

            if (!foundHeading) {
                // If no more headings, toggle the arrow to point upwards
                scrollArrow.classList.add("upwards");

                // Scroll to the top of the page
                window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });

                // After a delay, remove the upwards class to reset the arrow
                setTimeout(function () {
                    scrollArrow.classList.remove("upwards");
                }, 1000); // Adjust the delay if needed
            }
        });
    });
</script>

<?php
require_once ("footer.php");
?>
