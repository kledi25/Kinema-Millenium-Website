<?php
session_start();
include_once "connection.php";

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
?>

<style>

    body {
        background-image: url("images/coverImage.jpg");
        background-size: cover;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .container {
        background-color: rgb(242 68 65 / 50%);
        border-radius: 15px;
        padding: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal {
        color: black !important;
    }

</style>

<?php
include_once "navbar.php";
?>

<br><br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) && isset($_POST["button"] ))  {
        $UserEmail = $_POST['email'];
        $TEXT = $_POST['message'];

        $statement = $con->prepare("INSERT INTO Comments (TEXT, UserEmail) VALUES (:TEXT, :UserEmail)");
        $statement->bindParam(':TEXT', $TEXT);
        $statement->bindParam(':UserEmail', $UserEmail);
        $statement->execute();

        ?>




            <?php

        // imah rnfu kjpv rcnv
        try {
            //Server settings
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'leakraja.official@gmail.com';                     //SMTP username
            $mail->Password = 'imah rnfu kjpv rcnv';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('leakraja.official@gmail.com', 'Mailer');
            $mail->addAddress('leakra17@htl-shkoder.com', 'lea');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'New Message from user';
            $mail->Body = 'You received the following message from ' . $UserEmail . ' : ' . '<br>' . $TEXT;
            unset($_POST["button"]);
            if ($mail->send()){
            $_SESSION["sent"]= 1;
            //echo 'Message has been sent';
            ?>
            <?php
            } ?>
            <?php
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
    ?>

<?php
} else {
        //echo "Something is wrong";
    }

?>
<?php
 if (isset($_SESSION["sent"])){

?>
<div class="modal" id="sendModal" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Mesazhi u dergua me sukses!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-title fs-5" id="exampleModalLabel">Ne do ju kthejme pergjigje sa me shpejt te jete e mundur.</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mbyll</button>
            </div>
        </div>
    </div>
</div>
     <script>
         $(document).ready(function(){
             $('#sendModal').modal('show');
         });
     </script>
<?php
unset($_SESSION["sent"]);
}
?>
<div class="container col-6">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row g-3" method="POST">
        <h2>Mos hezitoni te na kontaktoni</h2>

        <div class="col-md-6">
            <label class="visually-hidden" for="autoSizingInput">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
        </div>

        <div class="col-md-6">
            <label class="visually-hidden" for="autoSizingInputGroup">Email</label>
            <div class="input-group">
                <div class="input-group-text">@</div>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            </div>
        </div>

        <div class="col-12">
            <label class="visually-hidden" for="autoSizingInputGroup">Email</label>
            <div class="input-group-text">
                <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                          placeholder="Enter your message" rows="3"></textarea>

            </div>
        </div>

        <div class="col-6"></div>
        <div class="col-auto">
            <button type="submit" name="button" value="1" class="btn btn-danger bt-lg">
                Submit
            </button>
        </div>
    </form>
</div>



<div class="footer">
    <?php include_once "footer.php"; ?>
</div>

<!--Bootstrap JS link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>



