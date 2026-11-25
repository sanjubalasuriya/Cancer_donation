<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
