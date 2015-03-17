<?php

//taskpars: handles the 'livni.taskpars' table. Following is the list of functions currently supported:
//oper={load, modify} note: load requires $ret global
if (!isset($params_oper)) {
    $oper = $_POST['params_oper'];
}

$task_id = $_POST['params_task_id'];
//echo "<p>TASK_ID = $task_id</p><br>"; // for debug

require "./connect.php";
if (!$link) {
    echo "Could not connect : " . mysqli_error($link);
    return;
}
if (!mysqli_select_db($link,"livni")) {
    echo mysqli_errno($link) . ": " . mysqli_error($link);
    mysqli_close($link);
    return;
}

if ($oper == "modify") {
    
}
else if ($oper == "load") {
    $ret = array();
    $query = "SELECT * FROM taskpars WHERE task_id=$task_id ORDER BY par_id ASC";
    //echo "QUERY:  $query \n       "; //for debug
    $result = mysqli_query($link, $query);
    if (!$result) {
        echo mysqli_errno($link) . ": " . mysqli_error($link);
        return;
    }

    $rows = mysqli_num_rows($result);
    $ret = array();
    if ($rows) {
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
//       $ret[]=array('caption' => $row['caption'], 'name' => $row['name'],  'type' => $row['type'],  'def_val' => $row['def_val'],  'min_val' => $row['min_val'],  'max_val' => $row['max_val']);
            $ret[] = $row;
        }
    }
}

echo json_encode($ret);

mysqli_close($link);
?>

