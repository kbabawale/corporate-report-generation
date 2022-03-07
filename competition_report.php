<?php


$start_dtt = $end_dtt = isset($_REQUEST['tran_date']) ? $_REQUEST['tran_date'] : date('Y-m-d'); //date('Y-m-d');
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

$objPHPExcel->getProperties()->setTitle("Competition Report" . date('Y-m-d'));

$objPHPExcel->getProperties()->setSubject("Competition Report" . date('Y-m-d'));

$objPHPExcel->getProperties()->setDescription("Competition Report generated automatically");


// Select current sheet 
$objPHPExcel->setActiveSheetIndex(0);
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Competition Report');

//set header text
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Company');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Unit');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Region');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Vehicle');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Rep Name');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Customer No');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Outlet Class');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Outlet Name');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Outlet Address');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Outlet Phone');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'SKU Name');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Depot');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Area');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'ED Code');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Price');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Available');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Date');


$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setSize(15);

//populate data from sql query
$DB_Server = "91.109.247.182"; // MySQL Server
$DB_Username = "mtrader"; // MySQL Username
$DB_Password = "XXXXXXXXXX"; // MySQL Password
$DB_DBName = "mobiletrader"; // MySQL Database Name
$xls_filename = 'Competition_Report' . date('Y-m-d') . '.xls'; // Define Excel (.xls) file name

$sql = "
SELECT  
p.name AS 'Company',
m.name AS 'UNIT',
l.name AS 'REGION',
o.name AS 'VEHICLE',
CONCAT(e.first_name,' ',e.last_name) AS 'Rep Name',
f.urno AS 'Customer No',
q.name AS 'Outlet Class',
f.outletname AS 'OUTLET NAME',
f.outletaddress AS 'OUTLET ADRESS',
f.contactPhone AS 'OUTLET PHONE',
g.name AS 'SKU NAME',
j.name AS 'DEPOT',
k.name AS 'AREA',
e.employee_code AS 'ED CODE',
a.pack_price AS 'PRICE',
a.available AS 'AVAILABLE',
b.date_idx AS 'Date'
FROM rep_trade_competition a, sales_route_visit b, sales_route_plan c, 
employee_outlet d, employees e, outlets f, competition g,
employee_division h, divisions_map i, depots j, areas k, regions l, divisions m, employee_vehicle n, vehicles o, companies p, outlet_class q
WHERE a.sales_route_visit_id = b.id 
AND b.sales_route_plan_id = c.id
AND c.employee_outlet_id = d.id
AND d.employee_id = e.id
AND d.outlet_id = f.id
AND a.competition_id = g.id
AND e.id = h.employee_id
AND h.division_map_id = i.id
AND i.depot_id = j.id
AND i.area_id = k.id
AND i.region_id = l.id
AND i.division_id = m.id
AND e.id = n.employee_id
AND n.vehicles_id = o.id
AND m.company_id = p.id
AND f.outletClassId = q.id
AND d.end_date LIKE '0000-00-00 00:00:00'
AND h.end_date LIKE '0000-00-00 00:00:00'
AND n.end_date LIKE '0000-00-00 00:00:00'
AND b.date_idx >= '2018-10-01'
AND b.date_idx <='2018-10-30'
AND a.pack_price != 0.00
LIMIT 99999999
";

$Connect = mysqli_connect($DB_Server, $DB_Username, $DB_Password);
// Select database
$Db = mysqli_select_db($Connect, $DB_DBName);
// Execute query
$result = mysqli_query($Connect, $sql);
// Fetch results
$count = 2;
while ($row = mysqli_fetch_row($result)) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . "$count", $row[0]);
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . "$count", $row[1]);
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . "$count", $row[2]);
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . "$count", $row[3]);
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . "$count", $row[4]);
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . "$count", $row[5]);
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . "$count", $row[6]);
    $objPHPExcel->getActiveSheet()->SetCellValue('H' . "$count", $row[7]);
    $objPHPExcel->getActiveSheet()->SetCellValue('I' . "$count", $row[8]);
    $objPHPExcel->getActiveSheet()->SetCellValue('J' . "$count", $row[9]);
    $objPHPExcel->getActiveSheet()->SetCellValue('K' . "$count", $row[10]);
    $objPHPExcel->getActiveSheet()->SetCellValue('L' . "$count", $row[11]);
    $objPHPExcel->getActiveSheet()->SetCellValue('M' . "$count", $row[12]);
    $objPHPExcel->getActiveSheet()->SetCellValue('N' . "$count", $row[13]);
    $objPHPExcel->getActiveSheet()->SetCellValue('O' . "$count", $row[14]);
    $objPHPExcel->getActiveSheet()->SetCellValue('P' . "$count", $row[15]);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q' . "$count", $row[16]);

    $count++;
} //while

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
$objWriter->save('Reports/Competition_Report' . date('Y-m-d') . '.xlsx');



//check if theres a new file generated.
if (file_exists('Reports/Competition_Report' . date('Y-m-d') . '.xlsx')) {
    return true;
}
else {
    return false;
}


?>