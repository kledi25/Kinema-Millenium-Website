<?php
# Start session , so that Session variables can be accessed
session_start();
# Error variables declaration, useful for error correction
$emailErr = false;
$failedEmail = false;
$pwdREGEXfail = false;
# Password regular expression
$password_regex = "/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[_,.#?!@$%^&*=-]).{8,}$/";

# Check if the request is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Check if all fields are sent
    if ((isset($_POST["email"])) && (isset($_POST["PASSWORD"])) && (isset($_POST["FirstName"])) &&
        (isset($_POST["LastName"]))) {

        # Input 'Clean' from unnecessary characters
        $email = sanitizeInput($_POST["email"]);
        $PASSWORD = $_POST["PASSWORD"];
        $FirstName = sanitizeInput($_POST["FirstName"]);
        $LastName = sanitizeInput($_POST["LastName"]);

        #  call Connection to DB
        include_once("connection.php");

        # Get from the database users with the given Email
        $stmt = $con->prepare("SELECT * FROM Benutzer WHERE email = :email");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        # Check if the user already exists
        if (!empty($user["email"])) {
            $failedEmail = true;
            var_dump($user["email"]);
        } else {
            # Check Email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = true;
            } else {
                # Check Password format
                if (preg_match($password_regex, $PASSWORD)) {
                    # Convert Password to Hash and save the data in the DB
                    $PWD_HASH = password_hash($PASSWORD, PASSWORD_DEFAULT);
                    $statement = $con->prepare("INSERT INTO Benutzer (FirstName, LastName, Role,PASSWORD,email ) VALUES (:FirstName,:LastName,'user',:PASSWORD,:email)");
                    $statement->execute(["FirstName" => $FirstName, "LastName" => $LastName, "PASSWORD" => $PWD_HASH, "email" => $email]);
                    // Login , data saved in Session-Variables and redirect to homepage
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = "user";
                    $_SESSION["FirstName"] = $user['FirstName'];
                    $_SESSION["LastName"] = $user['LastName'];
                    $_SESSION["ID"] = $user['ID'];
                    header("location:index.php"); //php redirect to main site
                } else {
                    $pwdREGEXfail = true;
                }
            }
        }
    }
}

# Function to clean Input from unnecessary characters
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php # Get Navbar file
require_once('navbar.php');
?>
<style>
    /* Set a Site style */
    form {
        background-image: url("images/Login_Background.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        height: 120vh;
        margin: 0;
        padding: 0;
    }

    div {
        margin: 0;
    }

    body {
        font-family: "Bodoni MT";
        margin: 0;
        padding: 0;
    }

    .login_form {
        background-color: rgb(77, 0, 0);
    }
</style>

<!-- Register form -->
<form class="needs-validation" novalidate action="register.php" method="POST" style="max-width:100%;">
    <section>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row d-flex justify-content-center align-items-center h-100 col-8">
                <div class="col justify-content-center align-items-center">
                    <div class="card card-registration mt-5 justify-content-center align-items-center login_form">
                        <div class="col-xl-10 login_form">

                            <div class="card-body p-md-5 text-black">
                                <h3 class="pb-5 text-uppercase text-center"
                                    style="color:white;">Regjistrohu ne Kinema Millennium</h3>

                                <!-- Input fields for email, first name, last name and password -->
                                <div class="form-outline pb-4">
                                    <input name="FirstName" type="text" id="email" class="form-control form-control-lg"
                                           placeholder="Jepni emrin" required/>
                                    <div class="invalid-feedback">Ju lutem jepni Emrin</div>
                                </div>

                                <div class="form-outline pb-4">
                                    <input name="LastName" type="text" id="email" class="form-control form-control-lg"
                                           placeholder="Jepni mbiemrin" required/>
                                    <div class="invalid-feedback">Ju lutem jepni Mbiemrin</div>
                                </div>

                                <div class="form-outline pb-4">
                                    <input name="email" type="text" id="email" class="form-control form-control-lg"
                                           placeholder="Jepni emailin " required/>
                                    <div class="invalid-feedback">Ju lutem jepni emailin</div>
                                    <?php if ($emailErr) { ?>
                                        <div class="invalid-feedback">Ju lutem jepni emailin ne format te Pershtatshem
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <div class="pb-4">
                                        <div class="form-outline">
                                            <input type="password" id="pwdHash" class="form-control form-control-lg"
                                                   name="PASSWORD" placeholder="Jepni Fjalekalimin" required/>
                                            <div class="invalid-feedback">Ju lutem jepni fjalkalimin</div>
                                            <?php if ($pwdREGEXfail) { ?>
                                                <div class="invalid-feedback">Paswordi duhet te jete te pakten 8
                                                    karaktere i gjate dhe te permbaje te pakten nje numer dhe nje nga karakteret
                                                    (_,.#?!@$%^&*-).
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- register button -->
                                <button type="submit" class="btn btn-warning btn-lg mx-2 px-5 col-11 col-lg-5 ">
                                    Regjistrohu
                                </button>

                                <!-- Login-site button -->
                                <button href="login.php" type="button"
                                        class="btn btn-warning btn-lg mx-2 px-4 col-11 col-lg-6 ">
                                    <a href="login.php" style="text-decoration: none; color: black !important; ">
                                        Shko te faqja e kycjes
                                    </a>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<?php
# Get Footer file
require_once('footer.php');
?>


<?php
# Show error based on the pre-defined error-variables
if ($failedEmail) { ?>
    <!-- Existing email error Message -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color: black" class="modal-title" id="exampleModalLabel">Ky email eshte tashme ne
                        perdorim.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
        myModal.show()
    </script>
<?php } else if ($emailErr) { ?>
    <!-- Wrong email format Message -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color: black" class="modal-title" id="exampleModalLabel">Shkruani nje email me format :
                        Adresa@Shembull.com</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
        myModal.show()
    </script>
<?php } ?>

<?php
# Incorrect Password format error Message
if ($pwdREGEXfail) { ?>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color: black" class="modal-title" id="exampleModalLabel">Shkruani nje password qe te
                        permbaje te pakten 8 karaktere, ku te perfshihet te pakten nje numer dhe nje nga karakteret
                        (_,.#?!@$%^&*-). </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
        myModal.show()
    </script>
<?php } ?>

<script>
    (() => {
        'use strict'
        // Get formular inputs that need validation
        const forms = document.querySelectorAll('.needs-validation')
        // Iterate through the validations and interrupt data-sending in case of failed validation
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>