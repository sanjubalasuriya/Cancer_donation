<<<<<<< HEAD
<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/vendor/autoload.php';
=======
<?php session_start();
include('../db/db.php');


require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;

>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reports.php');
    exit();
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    redirect_with_flash('reports.php', 'error', 'Session expired. Please try exporting again.');
}

/**
 * Shared spreadsheet generator and streamer.
 */
function stream_xlsx_report(string $title, array $headers, array $rows, string $filenamePrefix): void
{
    if (empty($rows)) {
        redirect_with_flash('reports.php', 'error', 'No records matched your export criteria.');
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

    $colCount = count($headers);
    $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

    $sheet->setCellValue('A1', $title);
    $sheet->mergeCells("A1:{$lastCol}1");
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $headerStyle = [
        'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true, 'size' => 11],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'B91C1C']],
    ];

    foreach ($headers as $idx => $heading) {
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($idx + 1);
        $sheet->setCellValue($colLetter . '2', $heading);
        $sheet->getColumnDimension($colLetter)->setAutoSize(true);
    }
    $sheet->getStyle("A2:{$lastCol}2")->applyFromArray($headerStyle);

    $rowNum = 3;
    foreach ($rows as $rowValues) {
        foreach ($rowValues as $idx => $val) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($idx + 1);
            $sheet->setCellValue($colLetter . $rowNum, $val);
        }
        $rowNum++;
    }

    $finalFilename = $filenamePrefix . '_' . date('Ymd_His') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . rawurlencode($finalFilename) . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}

function fetch_patient_rows(mysqli_result $res): array
{
    $rows = [];
    while ($d = mysqli_fetch_assoc($res)) {
        $rows[] = [
            $d['p_id'], $d['f_name'], $d['l_name'], $d['nic'], $d['contact'],
            $d['email'], $d['dob'], $d['gender'], $d['cancer'], $d['c_step'],
            $d['amount'], $d['donate'], $d['address'], $d['date'],
        ];
    }
    return $rows;
}

$patientHeaders = ['ID', 'First Name', 'Last Name', 'NIC', 'Contact', 'Email', 'Date of Birth', 'Gender', 'Cancer', 'Stage', 'Target (Rs.)', 'Raised (Rs.)', 'Address', 'Date'];

if (isset($_POST['patient_repo'])) {
    $res = mysqli_query($con, 'SELECT * FROM `patients` ORDER BY `id` ASC');
    $rows = $res ? fetch_patient_rows($res) : [];
    stream_xlsx_report('Cancer Patients Details', $patientHeaders, $rows, 'Patients');
}

if (isset($_POST['report_pa'])) {
    $cancer = trim((string)($_POST['cancer'] ?? ''));
    if ($cancer === '') {
        redirect_with_flash('reports.php', 'error', 'Please select a cancer type.');
    }
    $stmt = mysqli_prepare($con, 'SELECT * FROM `patients` WHERE `cancer` = ? ORDER BY `id` ASC');
    mysqli_stmt_bind_param($stmt, 's', $cancer);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rows = $res ? fetch_patient_rows($res) : [];
    mysqli_stmt_close($stmt);
    stream_xlsx_report('Cancer Patients - ' . $cancer, $patientHeaders, $rows, 'Patients_' . preg_replace('/[^A-Za-z0-9]+/', '_', $cancer));
}

if (isset($_POST['members_repo'])) {
    $res = mysqli_query($con, 'SELECT `m_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `status`, `date` FROM `members` ORDER BY `id` ASC');
    $rows = [];
    if ($res) {
        while ($d = mysqli_fetch_assoc($res)) {
            $rows[] = [$d['m_id'], $d['f_name'], $d['l_name'], $d['email'], $d['contact'], $d['nic'], $d['status'], $d['date']];
        }
    }
    stream_xlsx_report('Members Details', ['ID', 'First Name', 'Last Name', 'Email', 'Contact', 'NIC', 'Status', 'Joined'], $rows, 'Members');
}

if (isset($_POST['sponsor_repo'])) {
    $sql = "SELECT s.s_id, s.f_name, s.l_name, s.email, s.contact, s.company, COALESCE(SUM(d.amount), 0) AS total_donated, s.date
            FROM `sponsors` s
            LEFT JOIN `donations` d ON d.key_id = s.s_id AND d.status = 'sponsor'
            GROUP BY s.id
            ORDER BY s.id ASC";
    $res = mysqli_query($con, $sql);
    $rows = [];
    if ($res) {
        while ($d = mysqli_fetch_assoc($res)) {
            $rows[] = [$d['s_id'], $d['f_name'], $d['l_name'], $d['email'], $d['contact'], $d['company'], $d['total_donated'], $d['date']];
        }
    }
    stream_xlsx_report('Sponsors Details', ['ID', 'First Name', 'Last Name', 'Email', 'Contact', 'Company', 'Total Donated (Rs.)', 'Date'], $rows, 'Sponsors');
}

if (isset($_POST['report_do'])) {
    $status = trim((string)($_POST['status'] ?? 'all'));
    $rows = [];
    if ($status === 'all' || $status === '') {
        $res = mysqli_query($con, 'SELECT `id`, `key_id`, `status`, `amount`, `date` FROM `donations` ORDER BY `id` DESC');
        if ($res) {
            while ($d = mysqli_fetch_assoc($res)) {
                $rows[] = [$d['id'], $d['key_id'], $d['status'], $d['amount'], $d['date']];
            }
        }
    } else {
        $stmt = mysqli_prepare($con, 'SELECT `id`, `key_id`, `status`, `amount`, `date` FROM `donations` WHERE `status` = ? ORDER BY `id` DESC');
        mysqli_stmt_bind_param($stmt, 's', $status);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res) {
            while ($d = mysqli_fetch_assoc($res)) {
                $rows[] = [$d['id'], $d['key_id'], $d['status'], $d['amount'], $d['date']];
            }
        }
        mysqli_stmt_close($stmt);
    }
    stream_xlsx_report('Donations Report', ['ID', 'Reference Key', 'Category', 'Amount (Rs.)', 'Date'], $rows, 'Donations');
}

header('Location: reports.php');
exit();
=======

$tableHead = [
    'font'=>[
        'color'=>[
            'rgb'=>'FFFFFF'
        ],
        'bold'=>true,
        'size'=>11
    ],
    'fill'=>[
        'fillType'=> Fill::FILL_SOLID,
        'startColor'=>[
            'rgb' =>'BE0404'
        ],
        ],
        ];

//                                              Patients

if(isset($_POST['patient_repo'])){

    $filename = "Patients".time();

    $query = "SELECT * FROM patients";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
        ->getFont()
        ->setName('Arial')
        ->setSize(10);

        $spreadsheet->getActiveSheet()
        ->setCellValue('A1',"Cancer Patients Details");

        $spreadsheet->getActiveSheet()->mergeCells("A1:N1");

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);


        //color
        $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($tableHead);

        foreach (range('A', 'N') as $letra) {            
            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        }

        

        
        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'First Name');
        $sheet->setCellValue('C2', 'Last Name');
        $sheet->setCellValue('D2', 'NIC');
        $sheet->setCellValue('E2', 'Contact');
        $sheet->setCellValue('F2', 'Email');
        $sheet->setCellValue('G2', 'Date of Birth');
        $sheet->setCellValue('H2', 'Gender');
        $sheet->setCellValue('I2', 'Cancer');
        $sheet->setCellValue('J2', 'Cancer Type');
        $sheet->setCellValue('K2', 'Amount');
        $sheet->setCellValue('L2', 'Donation');
        $sheet->setCellValue('M2', 'Address');
        $sheet->setCellValue('N2', 'Date');

        $rowCount = 4;

        foreach($query_run as $data){

            

            $sheet->setCellValue('A' . $rowCount, $data['p_id']);
            $sheet->setCellValue('B' . $rowCount, $data['f_name']);
            $sheet->setCellValue('C' . $rowCount, $data['l_name']);
            $sheet->setCellValue('D' . $rowCount, $data['nic']);
            $sheet->setCellValue('E' . $rowCount, $data['contact']);
            $sheet->setCellValue('F' . $rowCount, $data['email']);
            $sheet->setCellValue('G' . $rowCount, $data['dob']);
            $sheet->setCellValue('H' . $rowCount, $data['gender']);
            $sheet->setCellValue('I' . $rowCount, $data['cancer']);
            $sheet->setCellValue('J' . $rowCount, $data['c_step']);
            $sheet->setCellValue('K' . $rowCount, $data['amount']);
            $sheet->setCellValue('L' . $rowCount, $data['donate']);
            $sheet->setCellValue('M' . $rowCount, $data['address']);
            $sheet->setCellValue('N' . $rowCount, $data['date']);
            $rowCount++;
        }
        

        $writer = new Xlsx($spreadsheet);
        $final_filename = $filename.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-disposition: attachement; filename="'.urlencode($final_filename).'"');

        $writer->save('php://output');

        header("location: reports.php");

    }

    else{

        $_SESSION['error'] = 'N0 Records';
    }


}

//==============================  members



if(isset($_POST['members_repo'])){

    $filename = "Members".time();

    $query = "SELECT * FROM members";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
        ->getFont()
        ->setName('Arial')
        ->setSize(10);

        $spreadsheet->getActiveSheet()
        ->setCellValue('A1',"Members Details");

        $spreadsheet->getActiveSheet()->mergeCells("A1:H1");

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
       


        //color
        $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($tableHead);

        foreach (range('A', 'H') as $letra) {            
            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        }

        

        
        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'First Name');
        $sheet->setCellValue('C2', 'Last Name');
        $sheet->setCellValue('D2', 'Email');
        $sheet->setCellValue('E2', 'Contact');
        $sheet->setCellValue('F2', 'NIC');
        $sheet->setCellValue('G2', 'Status');
        $sheet->setCellValue('H2', 'Date');
        

        $rowCount = 4;

        foreach($query_run as $data){

            

            $sheet->setCellValue('A' . $rowCount, $data['m_id']);
            $sheet->setCellValue('B' . $rowCount, $data['f_name']);
            $sheet->setCellValue('C' . $rowCount, $data['l_name']);
            $sheet->setCellValue('D' . $rowCount, $data['email']);
            $sheet->setCellValue('E' . $rowCount, $data['contact']);
            $sheet->setCellValue('F' . $rowCount, $data['nic']);
            $sheet->setCellValue('G' . $rowCount, $data['status']);
            $sheet->setCellValue('H' . $rowCount, $data['date']);
            
            $rowCount++;
        }
        

        $writer = new Xlsx($spreadsheet);
        $final_filename = $filename.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-disposition: attachement; filename="'.urlencode($final_filename).'"');

        $writer->save('php://output');

        header("location: reports.php");

    }

    else{

        $_SESSION['error'] = 'N0 Records';
    }


}

//======================================sponsors


if(isset($_POST['sponsor_repo'])){

    $filename = "Sponsors".time();

    $query = "SELECT * FROM sponsors";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
        ->getFont()
        ->setName('Arial')
        ->setSize(10);

        $spreadsheet->getActiveSheet()
        ->setCellValue('A1',"Sponsor Details");

        $spreadsheet->getActiveSheet()->mergeCells("A1:H1");

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        
       


        //color
        $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($tableHead);

        foreach (range('A', 'H') as $letra) {            
            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        }

        

        
        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'First Name');
        $sheet->setCellValue('C2', 'Last Name');
        $sheet->setCellValue('D2', 'Email');
        $sheet->setCellValue('E2', 'Contact');
        $sheet->setCellValue('F2', 'Company');
        $sheet->setCellValue('G2', 'Amount');
        $sheet->setCellValue('H2', 'Date');
        

        $rowCount = 4;

        foreach($query_run as $data){

            

            $sheet->setCellValue('A' . $rowCount, $data['s_id']);
            $sheet->setCellValue('B' . $rowCount, $data['f_name']);
            $sheet->setCellValue('C' . $rowCount, $data['l_name']);
            $sheet->setCellValue('D' . $rowCount, $data['email']);
            $sheet->setCellValue('E' . $rowCount, $data['contact']);
            $sheet->setCellValue('F' . $rowCount, $data['company']);
            $sheet->setCellValue('G' . $rowCount, $data['amount']);
            $sheet->setCellValue('H' . $rowCount, $data['date']);
            
            $rowCount++;
        }
        

        $writer = new Xlsx($spreadsheet);
        $final_filename = $filename.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-disposition: attachement; filename="'.urlencode($final_filename).'"');

        $writer->save('php://output');

        header("location: reports.php");

    }

    else{

        $_SESSION['error'] = 'N0 Records';
    }


}


//======================================sponsors


if(isset($_POST['report_pa'])){

    $filename = "patient".time();

    $cancer = $_POST["cancer"];

    $query = "SELECT * FROM patients WHERE cancer='$cancer'"  ;
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
        ->getFont()
        ->setName('Arial')
        ->setSize(10);

        $spreadsheet->getActiveSheet()
        ->setCellValue('A1',"Cancer Patients Details");

        $spreadsheet->getActiveSheet()->mergeCells("A1:N1");

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);


        //color
        $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($tableHead);

        foreach (range('A', 'N') as $letra) {            
            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        }

        

        
        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'First Name');
        $sheet->setCellValue('C2', 'Last Name');
        $sheet->setCellValue('D2', 'NIC');
        $sheet->setCellValue('E2', 'Contact');
        $sheet->setCellValue('F2', 'Email');
        $sheet->setCellValue('G2', 'Date of Birth');
        $sheet->setCellValue('H2', 'Gender');
        $sheet->setCellValue('I2', 'Cancer');
        $sheet->setCellValue('J2', 'Cancer Type');
        $sheet->setCellValue('K2', 'Amount');
        $sheet->setCellValue('L2', 'Donation');
        $sheet->setCellValue('M2', 'Address');
        $sheet->setCellValue('N2', 'Date');

        $rowCount = 4;

        foreach($query_run as $data){

            

            $sheet->setCellValue('A' . $rowCount, $data['p_id']);
            $sheet->setCellValue('B' . $rowCount, $data['f_name']);
            $sheet->setCellValue('C' . $rowCount, $data['l_name']);
            $sheet->setCellValue('D' . $rowCount, $data['nic']);
            $sheet->setCellValue('E' . $rowCount, $data['contact']);
            $sheet->setCellValue('F' . $rowCount, $data['email']);
            $sheet->setCellValue('G' . $rowCount, $data['dob']);
            $sheet->setCellValue('H' . $rowCount, $data['gender']);
            $sheet->setCellValue('I' . $rowCount, $data['cancer']);
            $sheet->setCellValue('J' . $rowCount, $data['c_step']);
            $sheet->setCellValue('K' . $rowCount, $data['amount']);
            $sheet->setCellValue('L' . $rowCount, $data['donate']);
            $sheet->setCellValue('M' . $rowCount, $data['address']);
            $sheet->setCellValue('N' . $rowCount, $data['date']);
            $rowCount++;
        }
        

        $writer = new Xlsx($spreadsheet);
        $final_filename = $filename.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-disposition: attachement; filename="'.urlencode($final_filename).'"');

        $writer->save('php://output');

        header("location: reports.php");

    }

    else{

        $_SESSION['error'] = 'N0 Records';
    }


}



//======================================donation


if(isset($_POST['report_do'])){

    $filename = "Donation".time();

    $status = $_POST["status"];

    $query = " SELECT A.m_id, A.f_name , A.l_name ,A.email, A.contact, A.nic , B.status, B.amount FROM members AS A
    INNER JOIN donations AS B
    ON B.key_id = A.m_id ";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
        ->getFont()
        ->setName('Arial')
        ->setSize(10);

        $spreadsheet->getActiveSheet()
        ->setCellValue('A1',"Sponsor Details");

        $spreadsheet->getActiveSheet()->mergeCells("A1:H1");

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        
       


        //color
        $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($tableHead);

        foreach (range('A', 'H') as $letra) {            
            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        }

        

        
        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'First Name');
        $sheet->setCellValue('C2', 'Last Name');
        $sheet->setCellValue('D2', 'Email');
        $sheet->setCellValue('E2', 'Contact');
        $sheet->setCellValue('F2', 'Company');
        $sheet->setCellValue('G2', 'Amount');
        $sheet->setCellValue('H2', 'Date');
        

        $rowCount = 4;

        foreach($query_run as $data){

            

            $sheet->setCellValue('A' . $rowCount, $data['m_id']);
            $sheet->setCellValue('B' . $rowCount, $data['f_name']);
            $sheet->setCellValue('C' . $rowCount, $data['l_name']);
            $sheet->setCellValue('D' . $rowCount, $data['email']);
            $sheet->setCellValue('E' . $rowCount, $data['contact']);
            $sheet->setCellValue('F' . $rowCount, $data['nic']);
            $sheet->setCellValue('G' . $rowCount, $data['status']);
            $sheet->setCellValue('H' . $rowCount, $data['amount']);
            
            $rowCount++;
        }
        

        $writer = new Xlsx($spreadsheet);
        $final_filename = $filename.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-disposition: attachement; filename="'.urlencode($final_filename).'"');

        $writer->save('php://output');

        header("location: reports.php");

    }

    else{

        $_SESSION['error'] = 'N0 Records';
    }


}



//              -------------------------------------------    Teacher

// if(isset($_POST['teacher'])){

//     $filename = "Teachers".time();

//     $query = "SELECT * FROM teacher ";
//     $query_run = mysqli_query($con, $query);

//     if(mysqli_num_rows($query_run) > 0){

//         $spreadsheet = new Spreadsheet();
//         $sheet = $spreadsheet->getActiveSheet();

//         foreach (range('A', 'I') as $letra) {            
//             $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
//         }

//         $sheet->getStyle('A1')->getFont()->setBold(true);
//         $sheet->getStyle('B1')->getFont()->setBold(true);
//         $sheet->getStyle('C1')->getFont()->setBold(true);
//         $sheet->getStyle('D1')->getFont()->setBold(true);
//         $sheet->getStyle('E1')->getFont()->setBold(true);
//         $sheet->getStyle('F1')->getFont()->setBold(true);
//         $sheet->getStyle('G1')->getFont()->setBold(true);
//         $sheet->getStyle('H1')->getFont()->setBold(true);
//         $sheet->getStyle('I1')->getFont()->setBold(true);

//         $sheet->setCellValue('A1', 'Employee No');
//         $sheet->setCellValue('B1', 'Name');
//         $sheet->setCellValue('C1', 'Contact');
//         $sheet->setCellValue('D1', 'Email');
//         $sheet->setCellValue('E1', 'Date of Birth');
//         $sheet->setCellValue('F1', 'Gender');
//         $sheet->setCellValue('G1', 'NIC');
//         $sheet->setCellValue('H1', 'Subject');
//         $sheet->setCellValue('I1', 'Address');
        

//         $rowCount = 2;

//         foreach($query_run as $data){

//             $sheet->setCellValue('A' . $rowCount, $data['emp_id']);
//             $sheet->setCellValue('B' . $rowCount, $data['f_name_i']);
//             $sheet->setCellValue('C' . $rowCount, $data['contact']);
//             $sheet->setCellValue('D' . $rowCount, $data['email']);
//             $sheet->setCellValue('E' . $rowCount, $data['dob']);
//             $sheet->setCellValue('F' . $rowCount, $data['gender']);
//             $sheet->setCellValue('G' . $rowCount, $data['nic']);
//             $sheet->setCellValue('H' . $rowCount, $data['subject']);
//             $sheet->setCellValue('I' . $rowCount, $data['address']);
//             $rowCount++;
//         }
        

//         $writer = new Xlsx($spreadsheet);
//         $final_filename = $filename.'.xlsx';

//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header('Content-disposition: attachement; filename="'.urlencode($final_filename).'"');

//         $writer->save('php://output');

//         header("location: report.php");

//     }

//     else{

//         $_SESSION['error'] = 'N0 Records';
//     }


// }

header("location: reports.php");








?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
