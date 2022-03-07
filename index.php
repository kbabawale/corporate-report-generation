<?php 

/**
 * The report object takes 5 boolean arguments
 *
 * 1st for Tobacco (SW & SE)
 * 2nd for Johnson & Johnson
 * 3rd for Mars & Wrigleys
 * 4th for Horeca & Modern Trade
 * 5th for Gallo Wholesalers
 *
 * Example
 * -----------------------
 * 
 * $report = new Report(true, true, true, true, true); //for all 5 divisions
 *
 * $report = new Report(false, true, true, true, true); //excluding tobacco
 * 
 * 
 *
 * 
 */



try{
    ob_start();

    if(file_exists('report.php')){
        require('report.php');
    }else{
        throw new Exception("report.php file doesnt exist");
    }

    $report = new Report(true, true, true, true, false);
    $mess = $report->getMessages();

    foreach($mess as $mess1){
        echo $mess1."<br />";
    }
    
}catch(Exception $e){
    ob_end_clean(); 
    echo '<b>Error Message: (index.php)</b>'.' '.$e->getMessage().'<br />';
}

ob_end_flush();

?>