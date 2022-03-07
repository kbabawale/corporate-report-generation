<?php
   
    function callTarget($urno, $type, $category){
		if(strcmp($type, "Tobacco_Retail")==0){
            return getTotal_Tobacco($urno);
        }else if(strcmp($type, "J&J")==0){
            return getTotal_J_and_J($urno);
        }else if(strcmp($type, "BA")==0){
            return getTotal_BA($urno);
        }else if(strcmp($type, "Sahara")==0){
            return getTotal_Sahara($urno, $category);
        }
    }

    function getTotal_Tobacco($urno){
		global $conn2;
        $sql = "SELECT count(call_status) FROM outlet_feedback WHERE employee_id='$urno' and entry_idx= curdate()";
		$result = $conn2->query($sql);
        if($value=$result->fetch_row()){
        $value1 = $value[0];
        $page="";
           $page .= "<div style= 'border:dotted; border:thick'>
            <div style= 'color:#066; font-size:12px'>Call Target Details</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Expected Call Today: 70 calls</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Total Call make today: $value1 calls</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Minimum Left over call:".(70-$value1)." calls</div>
        </div>";
        }else {
            $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:12px'>No call has been made today</div>";
        }
        return $page;
    } 

    function getTotal_J_and_J($urno){
		global $conn1;
        $sql = "SELECT count(call_status) from ba_calls_update WHERE user_id='$urno'  and sdate= curdate()";
        $result = $conn1->query($sql);
        if($value=$result->fetch_row()){
            $value1 = $value[0];
            $page="";
               $page .= "<div style= 'border:dotted; border:thick'>
                <div style= 'color:#066; font-size:12px'>Call Target Details</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Expected Call Today: 70 calls</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Total Call make today: $value1 calls</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Minimum Left over call:".(70-$value1)." calls</div>
            </div>";
            }else {
                $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:12px'>No call has been made today</div>";
        }
        return $page;
    }

    function getTotal_BA($urno){
		global $conn1;
        $sql = "SELECT count(call_status) from ba_calls_update WHERE user_id='$urno'  and sdate= curdate()";
        $result = $conn1->query($sql);
        if($value=$result->fetch_row()){
            $value1 = $value[0];
            $page="";
               $page .= "<div style= 'border:dotted; border:thick'>
                <div style= 'color:#066; font-size:12px'>Call Target Details</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Expected Call Today: 70 calls</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Total Call make today: $value1 calls</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Minimum Left over call:".(70-$value1)." calls</div>
            </div>";
            }else {
                $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:12px'>No call has been made today</div>";
        }
        return $page;
    } 

    function getTotal_Sahara($urno, $category){
		global $conn1;
        $sql = "SELECT count(call_status) from $category WHERE user_id='$urno'  and sdate= curdate()";
        $result = $conn1->query($sql);
        if($value=$result->fetch_row()){
            $value1 = $value[0];
            $page="";
               $page .= "<div style= 'border:dotted; border:thick'>
                <div style= 'color:#066; font-size:12px'>Call Target Details</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Expected Call Today: 70 calls</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Total Call make today: $value1 calls</div>
                <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Minimum Left over call:".(70-$value1)." calls</div>
            </div>";
            }else {
                $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:12px'>No call has been made today</div>";
        }
        return $page;
    } 

    
?>