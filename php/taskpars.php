<?php

//taskpars: handles the 'livni.taskpars' table. Following is the list of functions currently supported:
//oper={load, modify} note: load requires $ret global
if (!isset($params_oper)) {
    $oper = $_POST['params_oper'];
}

$task_id = $_POST['params_task_id'];

require "./connect.php";
if (!$link) {
    echo "Could not connect : " . mysql_error();
    return;
}
if (!mysql_select_db("livni", $link)) {
    echo mysql_errno($link) . ": " . mysql_error($link);
    mysql_close($link);
    return;
}

if ($oper == "modify") {
    
} elseif ($oper == "load") {
    $ret = array();
    $query = "SELECT * FROM taskpars WHERE task_id=$task_id ORDER BY par_id ASC";
    $result = mysql_query($link, $query);
    if (!$result) {
        echo mysql_errno($link) . ": " . mysql_error($link);
        return;
    }

    $rows = mysql_num_rows($result);
    $ret = array();
    if ($rows) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
//       $ret[]=array('caption' => $row['caption'], 'name' => $row['name'],  'type' => $row['type'],  'def_val' => $row['def_val'],  'min_val' => $row['min_val'],  'max_val' => $row['max_val']);
            $ret[] = $row;
        }
    }
}

echo json_encode($ret);

mysql_close($link);
?>

