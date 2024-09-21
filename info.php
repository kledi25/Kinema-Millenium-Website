<?php #Amri
session_start();
#require navbar um den Navbar zu zeigen
require_once("navbar.php");
?>
<title>Rreth nesh</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        background-color: black;
    }

    @media only screen and (max-width: 600px) {
        .container-fluid {
            padding: 0;
        }

        .col-md-6 {
            width: 100%;
            padding: 0;
        }

        .img-fluid {
            width: 100%;
            height: auto;
        }

        .h2 {
            font-size: 25px;
        }

        .col-md-2 {
            width: 100%;
            padding: 0;
        }

        .col-md-2 img {
            width: 100%;
            height: auto;
        }

        .col-md-2 p {
            font-size: 18px;
        }

        @media only screen and (max-width: 800px) {
            .desktop-img {
                display: none;
            }


</style>

<h2 class="h2 mt-4" style="font-size: 35px; text-align: center; color:#ef3b39">Rreth nesh</h2>
<!-- Hier werden mit einer div und Paragraph die Informationen des Kinos gezeigt -->
<div class="container-fluid px-5 mt-5">
    <div class="row">
        <div class="col-md-8">
            <p class="p1 px-10 pb-5" style="color: white; text-align:justify;">
                Filmi hyri në Shqipëri në vitet 1911-12. Shfaqjet e para publike u dhanë në qytetet Shkodër e Korçë.
                Sallat e para të kinemave si institucione publike u ngritën me iniciativë private pas Luftës I Botërore,
                duke perfshirë këtu edhe qytetin e Shkodrës. Filmat e parë u bënë nga të huajt; ata qenë kronika. E
                hapur në vitin 1958 si Kinema Republika, ajo kishte një kapacitet për 600 vende. Ndërtesa ka të ngjarë
                të jetë para kinemasë dhe ka kolona që mbështesin një pediment, me fasadën në një stil klasik. Pas
                viteve te komunizmit kinemaja u riemëruar Kinema Millenium, ajo u rinovua së fundmi nga grupi Kinema
                Millenium, kapaciteti i ndenjëseve tani është reduktuar në 250. Ndodhet në perëndim të sheshit kryesor
                në qendër të qytetit verior të Shkodrës. Çmimi i biletave varion nga 600 LEK për filmat 3D dhe 500 LEK
                të reja për filmat të cilët nuk janë 3D. Përveç funksionit të saj si kinema, aty mund të gjeni edhe një
                ndër bar-kafetë më të hershme të Shkodrës.
                Oraret e punës janë: <br>
                E hëne - të dielen: 08:00 - 23:00<br>
            </p>
        </div>
<!-- Mit eine Klasse rows werden 4 Photos vom Kino gezeigt-->
        <div class="col-md-4">

            <div class="row">
                <div class="col-md-6 desktop-img">
                    <img src="images/kino1.jpg" alt="kino1" class="img-fluid">
                </div>
                <div class="col-md-6 desktop-img">
                    <img src="images/kino2.jpg" alt="kino2" class="img-fluid">
                </div>
                <div class="col-md-6 desktop-img">
                    <img src="images/kino3.jpg" alt="kino3" class="img-fluid">
                </div>
                <div class="col-md-6 desktop-img">
                    <img src="images/kino4.jpg" alt="kino4" class="img-fluid">
                </div>
        </div>
    </div>

<div class="container-fluid" style="border-radius:10px">
    <div class="row">
        <div class="col-md-12 px-5">
            <p class="p1 px-5 mx-5 pb-5" style="color: white; font-size: 15px; text-align:justify;">

            </p>
        </div>
    </div>
</div>
<!-- Hier wird unsere Team angezeit mit die Fotos, Paragraph, und die col-md class-->
<h2 class="h2 mt-4" style="font-size: 35px; text-align: center; color:#ef3b39">Skuadra jonë</h2>
<div class="row ps-2 ms-2 justify-content-center" style="padding-right: 0px;">
    <div class="col-md-2">
        <img src="images/UnsereFotos/kledi.png" class="img-fluid img1">
        <p style="font-size: 25px; color:black">Kledi Sufaj</p>
        <p style="font-size: 15px; color:grey">Projekt Leader</p>
    </div>

    <div class="col-md-2">
        <img src="images/UnsereFotos/lea.png" class="img-fluid">
        <p style="font-size: 25px; color:black">Lea Kraja</p>
        <p style="font-size: 15px; color:grey">Project Leader</p>
    </div>

    <div class="col-md-2">
        <img src="images/UnsereFotos/amri.jpg" class="img-fluid img1">
        <p style="font-size: 25px; color:black">Amri Kalamishi</p>
        <p style="font-size: 15px; color:grey">Project Member</p>
    </div>

    <div class="col-md-2">
        <img src="images/UnsereFotos/aleandro.jpg" class="img-fluid img1">
        <p style="font-size: 25px; color:black">Aleandro Çupi</p>
        <p style="font-size: 15px; color:grey">Project Member</p>
    </div>

</div>
<!-- Google Maps-Integration mit einer iframe um die Location des Kinos zu zeigen-->
<div class="container-fluid pt-3">
    <div id="mapouter" style="width: 100%; margin: 0; padding: 0;">
        <div class="gmap_canvas">
            <iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                    style="width: 100%; height: 300px;"
                    src="https://maps.google.com/maps?width=100%&amp;height=400&amp;hl=en&amp;q=Kinema%20Republika&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
    </div>
</div>


<br>

<?php
require_once("footer.php");
?>
