<?php
require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$total_logs = 0;
$pending_logs = 0;
$approved_logs = 0;
$total_evidence = 0;

/* TOTAL LOGS */

$total_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM log_entries
    WHERE student_id = '$student_id'
");

if($total_query){
    $total_logs =
    $total_query->fetch_assoc()['total'];
}

/* PENDING LOGS */

$pending_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM log_entries
    WHERE student_id = '$student_id'
    AND status = 'pending'
");

if($pending_query){
    $pending_logs =
    $pending_query->fetch_assoc()['total'];
}

/* APPROVED LOGS */

$approved_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM log_entries
    WHERE student_id = '$student_id'
    AND status = 'approved'
");

if($approved_query){
    $approved_logs =
    $approved_query->fetch_assoc()['total'];
}

/* REJECTED LOGS */

$rejected_logs = 0;

$rejected_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM log_entries
    WHERE student_id = '$student_id'
    AND status = 'rejected'
");

if($rejected_query){

    $rejected_logs =
    $rejected_query->fetch_assoc()['total'];
}

/* WEEKLY EVIDENCE */
$evidence_count = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "

        SELECT COUNT(*) AS total

        FROM weekly_evidence

        WHERE student_id = '$student_id'

        "

    )

);


?>
<!-- DASHBOARD TOP -->

<div class="dashboard-header">
    <!-- LEFT -->
    <div class="welcome-section">
        <h2> Welcome, <?php echo $_SESSION['full_name']; ?> </h2>
        <p>SIWES E-Logbook student Dashboard</p>
    </div>
    <!-- RIGHT -->
    <div class="datetime-section">
        <p id="day"></p>
        <p id="date"></p>
        <h3 id="clock"></h3>
    </div>
</div>
<!-- DASHBOARD CARDS -->
<div class="cards-section">
    <div class="card">
        <h3>Total Logs</h3>
        <p><?php echo $total_logs; ?></p>
    </div>
    <div class="card">
        <h3>Pending Logs</h3>
        <p><?php echo $pending_logs; ?></p>
    </div>
    <div class="card">
        <h3>Approved Logs</h3>
        <p><?php echo $approved_logs; ?></p>
    </div>
    <div class="card rejected-card">
        <h3>Rejected Logs</h3>
        <p><?php echo $rejected_logs; ?></p>
    </div>
    <div class="card">
        <h3>Evidence</h3>
        <p><?php echo $evidence_count['total']; ?></p>
    </div>

   <!--- <div class="card">
        <h3>Weekly Evidence</h3>
        <p><?php echo $total_evidence; ?></p>
    </div> ---->
</div>
<!-- IMAGE SLIDER -->
<div class="slider-container">
    <!-- SLIDE 1 -->
    <div class="slides fade">
        <img src="../assets/images/itf.png">
        <div class="slide-text">
            <h2>Industrial Training Fund Updates</h2>
            <p>Latest SIWES and internship development across Nigerian institutions.</p>
            <a href="https://www.itf.gov.ng/" target="_blank"> learn more</a>
        </div>
    </div>
    <!-- SLIDE 2 -->
    <div class="slides fade">
        <img src="../assets/images/nuc.webp">
        <div class="slide-text">
            <h2>NUC Education News</h2>
            <p>Stay informed about university accreditation and SIWES policies.</p>
            <a href="https://www.nuc.edu.ng/" target="_blank">learn more</a>
        </div>
    </div>
    <!-- SLIDE 3 -->
    <div class="slides fade">
        <img src="../assets/images/jamb.webp">
        <div class="slide-text">
            <h2>Nigerian Academic Trends</h2>
            <p>Explore educational opportunities, technology and student development news.</p>
            <a href="https://www.jamb.gov.ng/" target="_blank">learn more</a>
        </div>
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