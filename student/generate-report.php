<?php

session_start();
require_once '../config/db.php';
require_once '../tcpdf/tcpdf.php';

if (!isset($_SESSION['user_id'])) {
    die("Access Denied");
}

$student_id = $_SESSION['user_id'];

class MYPDF extends TCPDF {
    public function Header() {
        // No header
    }
    public function Footer() {
        // No footer
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('SIWES E-Logbook');
$pdf->SetAuthor('AVRON TECH HUB');
$pdf->SetTitle('SIWES REPORT');
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Fetch data
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$student_id'");
$user = mysqli_fetch_assoc($user_query);

$profile_query = mysqli_query($conn, "SELECT * FROM student_profiles WHERE student_id='$student_id'");
$profile = mysqli_fetch_assoc($profile_query);


// PAGE 1 - COVER PAGE

$pdf->AddPage();

// Main Title
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 12, 'STUDENT INDUSTRIAL WORK EXPERIENCE SCHEME', 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 8, '(SIWES)', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 22);
$pdf->Cell(0, 12, 'E-LOGBOOK REPORT', 0, 1, 'C');
$pdf->Ln(20);


// PASSPORT PHOTO - MOVED UP (centered)

$passport = __DIR__ . "/../uploads/" . $profile['passport'];
if (!empty($profile['passport']) && file_exists($passport)) {
    $pdf->Image($passport, 80, 95, 50, 50);
}
$pdf->Ln(65);


// STUDENT DETAILS - MOVED DOWN (below the photo, separate)

$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'STUDENT DETAILS', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('helvetica', '', 11);

// Define column widths
$labelWidth = 45;
$valueWidth = 130;

// Each label and value on the SAME LINE
$pdf->Cell($labelWidth, 8, 'Name:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $user['full_name'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Matric Number:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['matric_no'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'School:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['school'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Faculty:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['faculty'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Department:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['department'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Level:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['level'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Gender:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['gender'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Generated On:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, date('d-m-Y h:i A'), 0, 1, 'L');


// PAGE 2 - ORGANIZATION DETAILS

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'ORGANIZATION DETAILS', 0, 1, 'L');
$pdf->Ln(5);

$pdf->SetFont('helvetica', '', 11);

$pdf->Cell($labelWidth, 8, 'Company Name:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['company_name'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Industry Supervisor:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['industry_supervisor'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Supervisor Phone:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['supervisor_phone'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Start Date:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['start_date'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'End Date:', 0, 0, 'L');
$pdf->Cell($valueWidth, 8, $profile['end_date'], 0, 1, 'L');

$pdf->Cell($labelWidth, 8, 'Company Address:', 0, 0, 'L');
$pdf->MultiCell($valueWidth, 8, $profile['company_address'], 0, 'L');

// PAGES 3+ - WEEKLY LOGS

$first_query = mysqli_query($conn, "SELECT log_date FROM log_entries WHERE student_id='$student_id' ORDER BY log_date ASC LIMIT 1");
$first_row = mysqli_fetch_assoc($first_query);
$start_date = strtotime($first_row['log_date']);

$evidence_query = mysqli_query($conn, "SELECT * FROM weekly_evidence WHERE student_id='$student_id' ORDER BY week_no ASC");

while ($week = mysqli_fetch_assoc($evidence_query)) {
    $week_no = $week['week_no'];
    
    $pdf->AddPage();
    
    // Week header
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'WEEK ' . $week_no, 0, 1, 'C');
    $pdf->Ln(5);
    
    // Get logs for this week
    $logs_query = mysqli_query($conn, "SELECT * FROM log_entries WHERE student_id='$student_id' ORDER BY log_date ASC");
    
    while ($log = mysqli_fetch_assoc($logs_query)) {
        $log_week = floor((strtotime($log['log_date']) - $start_date) / (60 * 60 * 24 * 7)) + 1;
        if ($log_week == $week_no) {
            
            // Date header
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 8, date('l d-m-Y', strtotime($log['log_date'])), 0, 1);
            $pdf->Ln(2);
            
            // Define column widths for bordered table
            $labelWidthBordered = 45;
            $contentWidth = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'] - $labelWidthBordered - 5;
            
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->SetFillColor(245, 245, 245);
            
            // TITLE ROW
            $pdf->Cell($labelWidthBordered, 8, 'Title:', 1, 0, 'L', true);
            $pdf->SetFont('helvetica', '', 11);
            $pdf->Cell($contentWidth, 8, $log['title'], 1, 1, 'L');
            
            // ACTIVITY ROW
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell($labelWidthBordered, 8, 'Activity:', 1, 0, 'L', true);
            $pdf->SetFont('helvetica', '', 11);
            $pdf->MultiCell($contentWidth, 8, $log['activity'], 1, 'L');
            
            // STATUS ROW
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell($labelWidthBordered, 8, 'Status:', 1, 0, 'L', true);
            $pdf->SetFont('helvetica', '', 11);
            $pdf->Cell($contentWidth, 8, ucfirst($log['status']), 1, 1, 'L');
            
            // SUPERVISOR COMMENT ROW
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell($labelWidthBordered, 8, 'Supervisor Comment:', 1, 0, 'L', true);
            $pdf->SetFont('helvetica', '', 11);
            $comment = !empty($log['supervisor_comment']) ? $log['supervisor_comment'] : 'No Comment';
            $pdf->MultiCell($contentWidth, 8, $comment, 1, 'L');
            $pdf->Ln(6);
        }
    }
    
    // Week Evidence Section
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'WEEK ' . $week_no . ' EVIDENCE', 0, 1, 'L');
    $pdf->Ln(3);
    
    $labelWidthBordered = 45;
    $contentWidth = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'] - $labelWidthBordered - 5;
    
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetFillColor(245, 245, 245);
    
    // Evidence Title
    $pdf->Cell($labelWidthBordered, 8, 'Title:', 1, 0, 'L', true);
    $pdf->SetFont('helvetica', '', 11);
    $pdf->Cell($contentWidth, 8, $week['title'], 1, 1, 'L');
    
    // Evidence Description
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell($labelWidthBordered, 8, 'Description:', 1, 0, 'L', true);
    $pdf->SetFont('helvetica', '', 11);
    $pdf->MultiCell($contentWidth, 8, $week['description'], 1, 'L');
    
    // Evidence Image
    $image = __DIR__ . "/../uploads/evidence/" . $week['evidence_file'];
    if (file_exists($image)) {
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $pdf->Ln(10);
            $image_width = 100;
            $x = ($pdf->getPageWidth() - $image_width) / 2;
            $pdf->Image($image, $x, $pdf->GetY(), $image_width, 0, '', '', '', false, 300);
            $pdf->Ln(75);
        }
    }
}

$pdf->Output('SIWES_REPORT.pdf', 'D');
exit;
?>