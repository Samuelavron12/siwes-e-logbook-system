<?php

session_start();

require_once '../config/db.php';
require_once '../tcpdf/tcpdf.php';

error_reporting(0); // prevent TCPDF break from warnings

$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['full_name'];

$pdf = new TCPDF();
$pdf->SetCreator('SIWES E-Logbook');
$pdf->SetAuthor('AVRON Tech Hub');
$pdf->SetTitle('SIWES Report');

$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();


// ===============================
// 1. STUDENT PROFILE
// ===============================
$profile_query = mysqli_query($conn, "
    SELECT *
    FROM student_profiles
    WHERE student_id='$student_id'
");

$profile = mysqli_fetch_assoc($profile_query);


// ===============================
// 2. COVER PAGE
// ===============================
$pdf->SetFont('helvetica','B',22);
$pdf->Cell(0, 20, 'STUDENT INDUSTRIAL WORK EXPERIENCE SCHEME', 0, 1, 'C');

$pdf->SetFont('helvetica','',18);
$pdf->Cell(0, 15, '(SIWES)', 0, 1, 'C');

$pdf->Ln(10);

$pdf->SetFont('helvetica','B',20);
$pdf->Cell(0, 15, 'E-LOGBOOK REPORT', 0, 1, 'C');


// ===============================
// 3. PASSPORT IMAGE
// ===============================
$passport_path = "../uploads/" . $profile['passport'];

if (!empty($profile['passport']) && file_exists($passport_path)) {
    $pdf->Image($passport_path, 80, 80, 45, 45);
}


// ===============================
// 4. STUDENT DETAILS
// ===============================
$pdf->Ln(60);

$pdf->SetFont('helvetica','',12);
$pdf->Cell(0, 8, 'Student Name: '.$student_name, 0, 1);
$pdf->Cell(0, 8, 'Matric No: '.$profile['matric_no'], 0, 1);
$pdf->Cell(0, 8, 'School: '.$profile['school'], 0, 1);
$pdf->Cell(0, 8, 'Faculty: '.$profile['faculty'], 0, 1);
$pdf->Cell(0, 8, 'Department: '.$profile['department'], 0, 1);
$pdf->Cell(0, 8, 'Level: '.$profile['level'], 0, 1);


// ===============================
// 5. ORGANIZATION DETAILS
// ===============================
$pdf->AddPage();

$pdf->SetFont('helvetica','B',18);
$pdf->Cell(0, 10, 'ORGANIZATION DETAILS', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('helvetica','',12);
$pdf->MultiCell(0, 8, "Company Name: ".$profile['company_name']);
$pdf->MultiCell(0, 8, "Company Address: ".$profile['company_address']);
$pdf->MultiCell(0, 8, "Industry Supervisor: ".$profile['industry_supervisor']);
$pdf->MultiCell(0, 8, "Supervisor Phone: ".$profile['supervisor_phone']);
$pdf->MultiCell(0, 8, "Start Date: ".$profile['start_date']);
$pdf->MultiCell(0, 8, "End Date: ".$profile['end_date']);


// ===============================
// 6. WEEKLY LOGS
// ===============================
$pdf->AddPage();

$pdf->SetFont('helvetica','B',16);
$pdf->Cell(0, 10, 'WEEKLY ACTIVITIES', 0, 1, 'C');

$logs = mysqli_query($conn, "
    SELECT *
    FROM log_entries
    WHERE student_id='$student_id'
    ORDER BY log_date ASC
");

$current_week = null;

$pdf->Ln(5);

while ($log = mysqli_fetch_assoc($logs)) {

    $week_no = date('W', strtotime($log['log_date']));

    if ($week_no != $current_week) {

        $current_week = $week_no;

        $pdf->Ln(4);
        $pdf->SetFont('helvetica','B',14);
        $pdf->Cell(0, 8, "WEEK $current_week", 0, 1, 'L');

        // Table header
        $pdf->SetFont('helvetica','B',11);
        $pdf->Cell(45, 8, 'Date', 1);
        $pdf->Cell(145, 8, 'Activity', 1);
        $pdf->Ln();
    }

    $pdf->SetFont('helvetica','',10);

    $pdf->Cell(45, 8, $log['log_date'], 1);
    $pdf->Cell(145, 8, $log['activity'], 1);
    $pdf->Ln();
}


// ===============================
// 7. WEEKLY EVIDENCE
// ===============================
$pdf->AddPage();

$pdf->SetFont('helvetica','B',16);
$pdf->Cell(0, 10, 'WEEKLY EVIDENCE', 0, 1, 'C');

$evidence = mysqli_query($conn, "
    SELECT *
    FROM weekly_evidence
    WHERE student_id='$student_id'
    ORDER BY week_no ASC
");

$current_week = null;

while ($ev = mysqli_fetch_assoc($evidence)) {

    if ($ev['week_no'] != $current_week) {

        $current_week = $ev['week_no'];

        $pdf->Ln(5);
        $pdf->SetFont('helvetica','B',14);
        $pdf->Cell(0, 8, "WEEK ".$current_week, 0, 1);

        $pdf->SetFont('helvetica','B',11);
        $pdf->Cell(50, 8, 'Title', 1);
        $pdf->Cell(90, 8, 'Description', 1);
        $pdf->Cell(50, 8, 'Date', 1);
        $pdf->Ln();
    }

    $pdf->SetFont('helvetica','',10);

    $pdf->Cell(50, 8, $ev['title'], 1);
    $pdf->Cell(50, 8, $ev['description'], 1);
    //$pdf->Cell(50, 8, $ev['evidence_file'], 1);
    $pdf->Cell(50, 8, $ev['uploaded_at'], 1);
    $pdf->Ln();

    // ===========================
    // IMAGE FIX (IMPORTANT PART)
    // ===========================
    if (!empty($ev['evidence_file'])) {

        $file_path = __DIR__ . "/../uploads/evidence" . $ev['evidence_file'];

        if (file_exists($file_path)) {

            $pdf->Ln(2);

            $pdf->Image(
                $file_path,
                15,
                $pdf->GetY(),
                60,
                40
            );

            $pdf->Ln(45);
        }
    }
}


// ===============================
// 8. OUTPUT PDF
// ===============================
$pdf->Output('SIWES_Report.pdf', 'D');

?>