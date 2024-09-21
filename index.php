    <?php #Kledi
    session_start();
    require_once "connection.php";
    ?>

    <title>Kinema Millennium</title>

    <style>
        body {
            background-image: linear-gradient(to bottom right, #bb2121, #670707);
        }

        .bg_img {
            background-image: url("images/cinema_hp.jpg");
            background-size: cover;
            background-position: center;
            height: 92vh;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
        }

        .bg_text {
            font-size: 72px;
            margin-bottom: 0em;
            margin-top: 0em;

        }

        .movies {
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 18px;
            color: #807f7d
        }

        .card-body {
            height: 520pt;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }


        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #scroll-arrow svg {
            transition: transform 0.3s ease-in-out;
        }

        #scroll-arrow:hover svg {
            transform: scale(1.2);
        }

    </style>

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


    <?php include_once('navbar.php'); ?>
    <div class="container-fluid bg_img">
        <div class="bg_text">
            <p class="bg_text"><strong>Kinema</strong></p>
            <p class="bg_text"><strong>Millennium</strong></p>
        </div>
    </div>
    <br>
    <br>
    <div class="container movies">
        <h1 style="display: flex; justify-content: center; margin-bottom: 20px">Playing now</h1>
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

    <style>
        /* Add this style to rotate the arrow when it points upwards */
        #scroll-arrow.upwards svg {
            transform: rotate(180deg);
        }
    </style>







    <?php include_once('footer.php'); ?>

