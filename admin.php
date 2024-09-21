<?php #Kledi
session_start();
?>

<style>
    body{
        background: #000 !important;
    }
</style>
<?php
require_once "navbar.php";
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

<div class="container" style="display: flex; justify-content: center; margin-top: 20px">
    <h2>Admin Dashboard</h2>
</div>
<br>
<br>
<div class="container" style="margin-bottom: 98px">
    <div class="row">
        <button type="button" class="btn btn-outline-secondary"><a href="reservations_edit.php"
                                                                   class="list-group-item list-group-item-action">Edito
                Rezervimet</a></button>
        <button type="button" class="btn btn-outline-secondary"><a href="content_edit.php"
                                                                   class="list-group-item list-group-item-action">Edito
                Filmat</a></button>
        <button type="button" class="btn btn-outline-secondary"><a href="user_edit.php"
                                                                   class="list-group-item list-group-item-action">Edito
                Perdoruesit</a></button>
        <button type="button" class="btn btn-outline-secondary"><a href="comments_edit.php"
                                                                   class="list-group-item list-group-item-action">Edito
                Komentet</a></button>
        <button type="button" class="btn btn-outline-secondary"><a href="info_edit.php"
                                                                   class="list-group-item list-group-item-action">Edito
                Informacionet</a></button>
        <button type="button" class="btn btn-outline-secondary"><a href="Upcoming_Movies_edit.php"
                                                                   class="list-group-item list-group-item-action">Edito
                Filmat e ardhshem</a></button>
    </div>
</div>


    <?php
    require_once("footer.php");
    ?>


</html>