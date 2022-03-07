<?php 

$start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:date('Y-m-d');//date('Y-m-d');
$time_start = microtime(true);

/** PHPExcel */
include_once 'Classes/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */ 
include_once 'Classes/PHPExcel/Writer/Excel2007.php'; 

// Create new PHPExcel object 
$objPHPExcel = new PHPExcel(); 

// Setting Excel file properties 
// Change the properties detail as per your requirement 
$objPHPExcel->getProperties()->setCreator("Kolapo Babawale"); 
$objPHPExcel->getProperties()->setLastModifiedBy("Kolapo Babawale (softwaredeveloper2.ho@greatbrandsng.com)"); 
$objPHPExcel->getProperties()->setTitle("Gallo Wholesalers Report".date('Y-m-d')); 
$objPHPExcel->getProperties()->setSubject("Gallo Wholesalers Report".date('Y-m-d')); 
$objPHPExcel->getProperties()->setDescription("Gallo Wholesalers Report generated automatically"); 

// Select current sheet 
$objPHPExcel->setActiveSheetIndex(0);
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Gallo Wholesalers Report');

//set header text
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'S/N');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'URNO');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Already Stock Our Brands');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Which One');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Where Do You Purchase From');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Feedback From Wine Sales');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Feedback From Sparkling Wine Sales');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Feedback From Grant Sales');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Feedback From Three Barrel Sales');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'How Do We Increase Sales');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'How Often Do You Purchase');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Are Our Services Satisfactory');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Are You Pleased With Our Rep\'s Visit');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Call Feedback');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Action Taken');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Call Status');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Date');


$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setSize(15);

//populate data from sql query
$DB_Server = "91.109.247.182"; // MySQL Server
$DB_Username = "mtrader"; // MySQL Username
$DB_Password = "gtXeAg0dtBB!"; // MySQL Password
$DB_DBName = "call_centre"; // MySQL Database Name
$xls_filename = 'Gallo_Wholesalers'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name

$sql = "SELECT
(@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS SN,
a.urno AS 'urno',
a.already_stock_our_brands AS 'Region',
a.which_one_already AS 'Channel',
a.where_purchase_from AS 'Depot',
a.wine_sales_feedback AS 'Outlet Class',
a.sparkling_wine_sales_feedback AS 'Customer No',
a.grants_sales_feedback AS 'Outlet Address',
a.three_barrel_sales_feedback AS 'Contact Phone',
a.how_to_increase_sales AS 'Outlet Name',
a.you_purchase_how_often AS 'Do You Know The Current Price Of Our Product?',
a.satisfactory_service AS 'Do You Know About Your Monthly Rebate?',
a.pleased_with_our_rep_visit AS 'Do You Know About Your Reward?',
a.feedback AS 'How Often Does Your Rep Visit Your Outlet?',
a.action_taken AS 'Is There Any Shortage On Delivery Of Your Order?',
a.call_status AS 'Why Have You Not Bought This Month?',
a.sdate AS 'Date'
FROM gallo_wholesalers_questions a
      WHERE a.sdate = '$start_dtt'
      and a.user_name = 'Shotuyo Omobolanle'
";

$Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password);
// Select database
$Db = @mysqli_select_db($Connect, $DB_DBName);
// Execute query
$result = @mysqli_query($Connect, $sql);
// Fetch results
$count = 2;$sn = 1;
while ($row=mysqli_fetch_row($result)){
    $objPHPExcel->getActiveSheet()->SetCellValue('A'."$count", $sn);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'."$count", $row[1]);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'."$count", $row[2]);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'."$count", $row[3]);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'."$count", $row[4]);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'."$count", $row[5]);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'."$count", $row[6]);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'."$count", $row[7]);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'."$count", $row[8]);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'."$count", $row[9]);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'."$count", $row[10]);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'."$count", $row[11]);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'."$count", $row[12]);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'."$count", $row[13]);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'."$count", $row[14]);
    $objPHPExcel->getActiveSheet()->SetCellValue('P'."$count", $row[15]);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'."$count", $row[16]);
    ++$sn;
    $count++;
}//while

// In my case this line didn't make much of a difference
//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
// Iterating all the sheets
/** @var PHPExcel_Worksheet $sheet */
foreach ($objPHPExcel->getAllSheets() as $sheet) {
    // Iterating through all the columns
    // The after Z column problem is solved by using numeric columns; thanks to the columnIndexFromString method
    for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
        $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
    }
}

// Create a write object to save the the excel 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 

// save to a file
$objWriter->save('Reports/Gallo_Wholesalers'.date('Y-m-d').'.xlsx'); 


// //check if theres a new file generated.
// if(file_exists('Reports/Gallo_Wholesalers'.date('Y-m-d').'.xlsx')){
//     return true;
// }else{
//     return false;
// }


?>