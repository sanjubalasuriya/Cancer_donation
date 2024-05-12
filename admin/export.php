<?php session_start();
include('../db/db.php');


require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;


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