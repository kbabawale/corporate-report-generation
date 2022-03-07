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
$objPHPExcel->getProperties()->setTitle("Tobacco Report".date('Y-m-d')); 
$objPHPExcel->getProperties()->setSubject("Tobacco Report".date('Y-m-d')); 
$objPHPExcel->getProperties()->setDescription("Tobacco Report generated automatically"); 

// Select current sheet 
$objPHPExcel->setActiveSheetIndex(0);
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Tobacco_SW');

//add logo
$gdImage = imagecreatefromjpeg('Reports/interdistributionlogo.jpg');
// Add a drawing to the worksheet
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('logo');
$objDrawing->setDescription('logo');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setHeight(70);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->SetCellValue('E2', "Call Center Summary");
$objPHPExcel->getActiveSheet()->SetCellValue('E4', "Report Date: ".date('d/m/Y'));

$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setSize(17);

$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);

//set header text
$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'S/N');
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Channels');
$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Regions');
$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Customer Codes');
$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Customer Names');
$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Address');
$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Phone No.');
$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Rep Name');
$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Depot');
$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Rep Visit');
$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Used Last TLP');
$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Selling Competition');
$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'How do you rate our service');
$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'How do we serve you better');
$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Time');
$objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Agent');

$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFont()->setSize(15);

//populate data from sql query
$DB_Server = "91.109.247.182"; // MySQL Server
$DB_Username = "mtrader"; // MySQL Username
$DB_Password = "gtXeAg0dtBB!"; // MySQL Password
$DB_DBName = "mobiletrader"; // MySQL Database Name
$DB_TBLName = "outlet_feedback"; // MySQL Table Name

$sql = "SELECT (@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS SN,
c.name AS Channels,
 i.name AS Region, 
 b.urNo AS customer_code, 
 b.outletName AS customer_name,
 b.outletAddress AS customer_address, 
 b.contactPhone AS customer_phone, 
 (SELECT CONCAT(last_name,' ',first_name) FROM employees WHERE id = e.employee_id) AS rep_name,
h.name AS customer_location,
visit_freq,
tlp_use, 
competition_sell, 
service_rate, 
serve_better, 
DATE_FORMAT(a.entry_time,'%r') AS call_time,
CONCAT(d.last_name,' ',d.first_name) AS cc_agent 
FROM outlet_feedback a, outlets b, vehicles c, employees d, employee_outlet e, employee_division f, divisions_map g, depots h, regions i
WHERE 
a.outlet_id = b.id 
AND a.vehicles_id = c.id
AND a.employee_id = d.id
AND b.id = e.outlet_id 
AND e.end_date LIKE '0000-00-00 00:00:00'
AND e.employee_id = f.employee_id 
AND f.end_date LIKE '0000-00-00 00:00:00'
AND f.division_map_id = g.id 
AND g.depot_id = h.id
AND g.region_id = i.id
AND a.entry_time BETWEEN '$start_dtt' AND DATE_ADD('$end_dtt',INTERVAL 1 DAY)
AND a.employee_id = '3317'         
ORDER BY a.entry_time
";

$Connect = mysqli_connect($DB_Server, $DB_Username, $DB_Password);
// Select database
$Db = mysqli_select_db($Connect, $DB_DBName);
// Execute query
$result = mysqli_query($Connect, $sql);
// Fetch results
$count = 6; $sn=1;
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
    
    ++$sn;
    $count++;
}//while

//End of sheet one
//############################################################################

// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('Tobacco_SE');

//Add data
//add logo
$gdImage = imagecreatefromjpeg('Reports/interdistributionlogo.jpg');
// Add a drawing to the worksheet
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('logo');
$objDrawing->setDescription('logo');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setHeight(70);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->SetCellValue('E2', "Call Center Summary");
$objPHPExcel->getActiveSheet()->SetCellValue('E4', "Report Date: ".date('d/m/Y'));

$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setSize(17);

$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);

//set header text
$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'S/N');
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Channels');
$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Regions');
$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Customer Codes');
$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Customer Names');
$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Address');
$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Phone No.');
$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Rep Name');
$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Depot');
$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Rep Visit');
$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Used Last TLP');
$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Selling Competition');
$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'How do you rate our service');
$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'How do we serve you better');
$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Time');
$objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Agent');


$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFont()->setSize(15);

//populate data from sql query
$DB_Server = "91.109.247.182"; // MySQL Server
$DB_Username = "mtrader"; // MySQL Username
$DB_Password = "gtXeAg0dtBB!"; // MySQL Password
$DB_DBName = "mobiletrader"; // MySQL Database Name
$DB_TBLName = "outlet_feedback"; // MySQL Table Name

$sql = "SELECT (@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS SN,
c.name AS Channels,
 i.name AS Region, 
 b.urNo AS customer_code, 
 b.outletName AS customer_name,
 b.outletAddress AS customer_address, 
 b.contactPhone AS customer_phone, 
 (SELECT CONCAT(last_name,' ',first_name) FROM employees WHERE id = e.employee_id) AS rep_name,
h.name AS customer_location,
visit_freq,
tlp_use, 
competition_sell, 
service_rate, 
serve_better, 
DATE_FORMAT(a.entry_time,'%r') AS call_time,
CONCAT(d.last_name,' ',d.first_name) AS cc_agent 
FROM outlet_feedback a, outlets b, vehicles c, employees d, employee_outlet e, employee_division f, divisions_map g, depots h, regions i
WHERE 
a.outlet_id = b.id 
AND a.vehicles_id = c.id
AND a.employee_id = d.id
AND b.id = e.outlet_id 
AND e.end_date LIKE '0000-00-00 00:00:00'
AND e.employee_id = f.employee_id 
AND f.end_date LIKE '0000-00-00 00:00:00'
AND f.division_map_id = g.id 
AND g.depot_id = h.id
AND g.region_id = i.id
AND a.entry_time BETWEEN '$start_dtt' AND DATE_ADD('$end_dtt',INTERVAL 1 DAY)
AND a.employee_id = '3318'         
ORDER BY a.entry_time
";

$Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password);
// Select database
$Db = @mysqli_select_db($Connect, $DB_DBName);
// Execute query
$result = @mysqli_query($Connect, $sql);
// Fetch results
$count = 6;$sn = 1;
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
$objWriter->save(dirname(__FILE__).'/Reports/Tobacco_Call_Center_Summary_'.date('Y-m-d').'.xlsx'); 

//check if theres a new file generated.
// if(file_exists(dirname(__FILE__).'/Reports/Tobacco_Call_Center_Summary_'.date('Y-m-d').'.xlsx')){
//     return true;
// }else{
//     return false;
// }


?>