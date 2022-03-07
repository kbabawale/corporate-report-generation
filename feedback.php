<?php

function connect()
{
    $servername = "91.109.247.182";
    $username = "mtrader";
    $password = "XXXXXXXXXX!";
    $conn = new mysqli($servername, $username, $password);
    $conn->select_db("call_centre");
    return $conn;
}

function connect2()
{
    $servername = "91.109.247.182";
    $username = "mtrader";
    $password = "XXXXXXXXXX!";
    $conn = new mysqli($servername, $username, $password);
    $conn->select_db("mobiletrader");
    if ($conn)
        ;
    return $conn;
}

$conn1 = connect();
$conn2 = connect2();
function getLastFeedback($urno, $type)
{
    if (strcmp($type, "Tobacco_Retail") == 0) {
        return getLastFeedback_Tobacco($urno);
    }
    else if (strcmp($type, "J&J") == 0) {
        return getLastFeedback_J_and_J($urno);
    }
    else if (strcmp($type, "BA") == 0) {
        return getLastFeedback_BA($urno);
    }
    else if (strcmp($type, "Sahara") == 0) {
        return getLastFeedback_Sahara($urno);
    }
    else if (strcmp($type, "stocklist") == 0) {
        return getLastFeedback_Stocklist($urno);
    }

}

function getLastFeedback_Tobacco($urno)
{
    global $conn2;
    $sql = "SELECT serve_better, entry_time FROM outlet_feedback WHERE outlet_id='$urno' ORDER BY entry_time DESC LIMIT 1";
    $result = $conn2->query($sql);
    if ($value = $result->fetch_row()) {
        $page = "";
        @list($date, $time) = explode(' ', $value[1]);
        $page .= "<div style= 'border:dotted; border:thick'>
            <div style= 'color:#066; font-size:12px'>Last Call Feedback Details</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Last call date : $date $time</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Last Discussion : $value[0] </div>
        </div>";
    }
    else {
        $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:24px'>Last Call Feedback Details Not found for customer</div>";
    }
    return $page;
}

function getLastFeedback_Stocklist($urno)
{
    global $conn1;
    $sql = "SELECT feedback, rdate FROM stocklist WHERE urno='$urno' ORDER BY rdate DESC LIMIT 1";
    $result = $conn1->query($sql);
    if ($value = $result->fetch_row()) {
        $page = "";
        @list($date, $time) = explode(' ', $value[1]);
        $page .= "<div style= 'border:dotted; border:thick'>
            <div style= 'color:#066; font-size:12px'>Last Call Feedback Details</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Last call date : $date $time</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Last Discussion : $value[0] </div>
        </div>";
    }
    else {
        $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:24px'>Last Call Feedback Details Not found for customer</div>";
    }
    return $page;
}

function getLastFeedback_J_and_J($urno)
{
    global $conn1;
    $sql = "SELECT feedback, rdate FROM rigleys_wholesale_questions WHERE urno='$urno' ORDER BY rdate DESC LIMIT 1";
    $result = $conn1->query($sql);
    if ($value = $result->fetch_row()) {
        $page = "";
        @list($date, $time) = explode(' ', $value[1]);
        $page .= "<div style= 'border:dotted; border:thick'>
            <div style= 'color:#066; font-size:12px'>Last Call Feedback Details</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Last call date : $date $time</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Last Discussion : $value[0] </div>
        </div>";
    }
    else {
        $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:24px'>Last Call Feedback Details Not found for customer</div>";
    }
    return $page;
}

function getLastFeedback_BA($urno)
{
    global $conn1;
    $sql = "SELECT price, rebate, reward, feedback, rdate FROM ba_calls_update WHERE urno='$urno' ORDER BY rdate DESC LIMIT 1";

    $result = $conn1->query($sql);
    if ($value = $result->fetch_row()) {
        $page = "";
        @list($date, $time) = explode(' ', $value[4]);
        $page .= "<div style= 'border:dotted; border:thick'>
            <div style= 'color:#066; font-size:12px'>Last Call Feedback Details</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Last call date : $date $time</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Price : $value[0], Rebate : $value[1]</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:10px'>Reward : $value[2]</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Last Discussion : $value[3] </div>
        </div>";
    }
    else {
        $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:24px'>Last Call Feedback Details Not found for customer</div>";
    }
    return $page;
}

function getLastFeedback_Sahara($urno)
{
    global $conn1;
    $sql = "SELECT feedback, rdate from branding_prospects_questions WHERE urno='$urno' ORDER BY rdate DESC LIMIT 1";
    $result = $conn1->query($sql);
    if ($value = $result->fetch_row()) {
        $page = "";
        @list($date, $time) = explode(' ', $value[1]);
        $page .= "<div style= 'border:dotted; border:thick'>
            <div style= 'color:#066; font-size:12px'>Last Call Feedback Details</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C;margin-top:10px; margin-bottom:0px'>Last call date : $date $time</div>
            <div style = 'backgroundcolor:#00F;font-size:12px; color:#00C; margin-bottom:0px'>Last Discussion : $value[0] </div>
        </div>";
    }
    else {
        $page = "<div style= 'backgroundcolor: #0C6;color:#066; font-size:24px'>Last Call Feedback Details Not found for customer</div>";
    }
    return $page;
}

if (isset($_REQUEST['akeem']))
    getLastFeedback_Tobacco(123456);

?>