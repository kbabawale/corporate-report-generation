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
$objPHPExcel->getProperties()->setTitle("Horeca & Modern Trade Report".date('Y-m-d')); 
$objPHPExcel->getProperties()->setSubject("Horeca & Modern Trade Report".date('Y-m-d')); 
$objPHPExcel->getProperties()->setDescription("Horeca & Modern Trade Report generated automatically"); 

// Select current sheet 
$objPHPExcel->setActiveSheetIndex(0);
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Horeca & Modern Trade Report');

//set header text
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Call Duration');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Contact Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'URNO');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Region');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Channel');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Depot');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Outlet Type');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Outlet Class');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Customer Number');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Outlet Address');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Contact Phone');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Outlet Name');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Do You Know The Current Price Of Our Product?');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Do You Know About Your Monthly Rebate?');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Do You Know About Your Reward?');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'How Often Does Your Rep Visit Your Outlet?');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Is There Any Shortage On Delivery Of Your Order?');
$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Why Have You Not Bought This Month?');
$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'How Can We Serve You Better?');
$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Feedback');
$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Rep Name');
$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Action Taken');
$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Call Status');
$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Date');

$objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getFont()->setSize(15);

//populate data from sql query
$DB_Server = "91.109.247.182"; // MySQL Server
$DB_Username = "mtrader"; // MySQL Username
$DB_Password = "gtXeAg0dtBB!"; // MySQL Password
$DB_DBName = "call_centre"; // MySQL Database Name
$xls_filename = 'Horeca_And_Modern_Trade'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name

$sql = "SELECT
(SELECT TIMEDIFF(a.rdate, a.call_starttime)) AS 'Call Duration',
a.contactname AS 'Contact Name',
a.urno AS 'urno',
a.region AS 'Region',
a.channel AS 'Channel',
a.depot AS 'Depot',
a.outlet_type_name AS 'Outlet Type',
a.outlet_class_name AS 'Outlet Class',
a.cust_no AS 'Customer No',
a.outletaddress AS 'Outlet Address',
a.contactphone AS 'Contact Phone',
a.outletname AS 'Outlet Name',
a.price AS 'Do You Know The Current Price Of Our Product?',
a.rebate AS 'Do You Know About Your Monthly Rebate?',
a.reward AS 'Do You Know About Your Reward?',
a.visit_your_outlets AS 'How Often Does Your Rep Visit Your Outlet?',
a.delivery AS 'Is There Any Shortage On Delivery Of Your Order?',
a.stock_order AS 'Why Have You Not Bought This Month?',
a.serve_better AS 'How Can We Serve You Better?',
a.feedback AS 'Feedback',
a.repname AS 'Rep Name',
a.action_taken AS 'Action Taken',
a.call_status AS 'Call Status',
a.rdate AS 'Date'
FROM ba_calls_update a
      WHERE a.sdate = '$start_dtt'
      and a.user_name = 'Mathias Catherine'
      ORDER BY a.rdate
";

$Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password);
// Select database
$Db = @mysqli_select_db($Connect, $DB_DBName);
// Execute query
$result = @mysqli_query($Connect, $sql);
// Fetch results
$count = 2;
while ($row=mysqli_fetch_row($result)){
    $objPHPExcel->getActiveSheet()->SetCellValue('A'."$count", $row[0]);
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
    $objPHPExcel->getActiveSheet()->SetCellValue('R'."$count", $row[17]);
    $objPHPExcel->getActiveSheet()->SetCellValue('S'."$count", $row[18]);
    $objPHPExcel->getActiveSheet()->SetCellValue('T'."$count", $row[19]);
    $objPHPExcel->getActiveSheet()->SetCellValue('U'."$count", $row[20]);
    $objPHPExcel->getActiveSheet()->SetCellValue('V'."$count", $row[21]);
    $objPHPExcel->getActiveSheet()->SetCellValue('W'."$count", $row[22]);
    $objPHPExcel->getActiveSheet()->SetCellValue('X'."$count", $row[23]);
    
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
$objWriter->save('Reports/Horeca_And_Modern_Trade'.date('Y-m-d').'.xlsx'); 


//check if theres a new file generated.
if(file_exists('Reports/Horeca_And_Modern_Trade'.date('Y-m-d').'.xlsx')){
    return true;
}else{
    return false;
}


?>