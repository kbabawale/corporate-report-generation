<?php 


try{
    ob_start();

    class Util{

        //methods to generate reports and save in 'Reports' directory 

        //Tobacco
        public static function prepareExcel1(){
            include_once('prepareExcel1.php');
        }//prepareExcel1


        //J&J
        public static function prepareExcel2(){
            include_once('prepareExcel2.php');
        }//prepareExcel2

        //M&R
        public static function prepareExcel3(){
            include_once('prepareExcel3.php');
        }//prepareExcel3


        //HMT
        public static function prepareExcel4(){
            include_once('prepareExcel4.php');
        }//prepareExcel4


        //Gallo Wholesalers
        public static function prepareExcel5(){
            include_once('prepareExcel5.php');
        }//prepareExcel5

        //Competition
        public static function prepareExcel6(){
            include_once('competition_report.php');
        }//prepareExcel6

    }//class

}catch(Exception $e){
    ob_end_clean(); 
    echo '<b>Error Message: (util.php)</b>'.' '.$e->getMessage().'<br />';
}

ob_end_flush();

?>