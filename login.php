<?php
# Start session , so that Session variables can be accessed
session_start();
# Check if the request is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Check if email and password are sent
    if (isset($_POST["email"]) && isset($_POST["PASSWORD"])) {
        $email = $_POST["email"];
        $PASSWORD = $_POST["PASSWORD"];

        # Get Connection file
        require_once('connection.php');
        # Get from the database users with the given Email
        $stmt = $con->prepare("SELECT * FROM Benutzer WHERE email = :email");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        # Check if the user already exists
        if (!empty($user)) {
            # Prove the password is correct
            if (password_verify($PASSWORD, $user["PASSWORD"])) {
                // Login , data saved in Session-Variables and redirect to homepage
                $_SESSION["email"] = $email;
                $_SESSION["Role"] = $user['Role'];
                $_SESSION["FirstName"] = $user['FirstName'];
                $_SESSION["LastName"] = $user['LastName'];
                $_SESSION["ID"] = $user['ID'];
                header("location:index.php"); //php Weiterleitung

            }
        }
    }
}

?>

<?php
# Get Navbar from file
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

    a {
        color: black;
    }
</style>

<!-- Login form -->
<form class="needs-validation" action="login.php" method="POST" style="max-width:100%;">
    <section>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row d-flex justify-content-center align-items-center h-100 col-8">
                <div class="col justify-content-center align-items-center">
                    <div class="card card-registration mt-5 justify-content-center align-items-center login_form">
                        <div class="col-xl-10 login_form">

                            <div class="card-body p-md-5 text-black">
                                <h3 class="pb-5 text-uppercase text-center"
                                    style="color:white;">Hyr ne Kinema Millennium</h3>

                                <div class="form-outline pb-4">
                                    <input name="email" type="text" id="email" class="form-control form-control-lg"
                                           placeholder="Jepni e-mailin" required/>
                                    <div class="invalid-feedback">Ju lutem jepni emailin</div>
                                </div>
                                <div class="row">
                                    <div class="pb-4">
                                        <input type="password" id="PASSWORD" class="form-control form-control-lg"
                                               name="PASSWORD" placeholder="Fjalekalimi" required/>
                                        <div class="invalid-feedback">Ju lutem jepni fjalkalimin</div>
                                    </div>

                                </div class="justify-content-center align-items-center">
                                <button type="submit" class="btn btn-warning btn-lg mx-2 px-5 col-11 col-lg-5">Kycu
                                    brenda
                                </button>
                                <button type="button" class="btn btn-warning btn-lg mx-2 px-4 col-11 col-lg-6 ">
                                    <a href="register.php" style="text-decoration: none; color: black !important;">
                                        Regjistrohu tani!
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