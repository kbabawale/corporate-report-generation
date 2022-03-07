
<?php
 
 //$con = mysqli_connect("mysql.feruke.com","feruke_usd2jpy2","usd2jpy2my1db","feruke_my1db");
  //$con = mysqli_connect("mysql-admin_my1db.foressfunds.com","mt4","mt4","admin_my1db");
  $con = mysqli_connect("localhost","fxmicro","fx_mt4","fx_my1db");

 
 if (mysqli_connect_errno()) 
  {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
 if (array_key_exists('p', $_POST))
  {
   $str=explode(',',$_POST['p'],7);
	 $sql="INSERT INTO trade_history (ticket, profit, sym, broker, equity, period, accounttype)
	 VALUES ('$str[0]', '$str[1]', '$str[2]', '$str[3]', '$str[4]', '$str[5]', '$str[6]')";
	 
	 if (!mysqli_query($con,$sql)) 
	  {
     die('Error: ' . mysqli_error($con));
    }
   echo "1 Record Added";
	}
 
  else if (array_key_exists('d', $_POST))
       {
	 $str=explode(',',$_POST['d'],1);
	 $sql="DELETE FROM trade_history WHERE Ticket='$str[0]'";
	 if (!mysqli_query($con,$sql)) 
	  {
     die('Error: ' . mysqli_error($con));
          }
   echo "1 Record Deleted";
       }
	 
	
 mysqli_close($con);
?> 