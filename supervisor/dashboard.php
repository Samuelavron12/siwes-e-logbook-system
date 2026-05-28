<?php
require_once 'header.php';
?>
<div class="dashboard-header">
    <!-- LEFT -->
    <div class="welcome-section">
        <h2>
            Welcome,
            <?php echo $_SESSION['full_name']; ?>
        </h2>
         <p>SIWES E-Logbook Supervisory Dashboard</p>
    </div>
    <!-- RIGHT -->
    <div class="datetime-section">
        <p id="day"></p>
        <p id="date"></p>
        <h3 id="clock"></h3>
    </div>
</div>

<script>

/* LIVE DATE AND TIME */

function updateDateTime(){

    const now = new Date();

    const day =
    now.toLocaleDateString('en-US', {
        weekday: 'long'
    });

    const date =
    now.toLocaleDateString();

    const time =
    now.toLocaleTimeString();

    document.getElementById("day")
    .innerHTML = day;

    document.getElementById("date")
    .innerHTML = date;

    document.getElementById("clock")
    .innerHTML = time;
}

setInterval(updateDateTime, 1000);

updateDateTime();

/* IMAGE SLIDER */

let slideIndex = 0;

showSlides();

function showSlides(){

    let slides =
    document.getElementsByClassName("slides");

    for(let i = 0; i < slides.length; i++){

        slides[i].style.display = "none";
    }

    slideIndex++;

    if(slideIndex > slides.length){

        slideIndex = 1;
    }

    slides[slideIndex - 1].style.display =
    "block";

    setTimeout(showSlides, 5000);
}

</script>


<?php
require_once 'footer.php';
?>