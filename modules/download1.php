
<?php
if(isset($_POST["download"])){
    require 'app.php';
    $start_date = secure_parameter($_POST["range1"]);
    $end_date = secure_parameter($_POST["range2"]);
    $chart_heading1 = secure_parameter($_POST["chart_heading1"]);
    $chart_heading2 = secure_parameter($_POST["chart_heading2"]);
    $file_name = $chart_heading1.'_'.$chart_heading2;
    $column1 = secure_parameter($_POST["column_name1"]);
    $column2 = secure_parameter($_POST["column_name2"]);
    require 'db.php';
    $output = "";
    $sql = "SELECT * FROM api_data WHERE (date_now BETWEEN '$start_date' AND '$end_date')";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res)){
        $output .= '
            <table class="table" border="1">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>'.$chart_heading1.'</th>
                    <th>'.$chart_heading2.'</th>
                </tr>
        ';
        while ($row = mysqli_fetch_array($res)){
            $time = get_time($row["date_now"]);
            $date = get_date($row["date_now"]);
            $output .= '
                <tr>
                    <td>'.$date.'</td>
                    <td>'.$time.'</td>
                    <td>'.$row[$column1].'</td>
                    <td>'.$row[$column2].'</td>
                </tr>
        ';
        }
        $output .=" </table>";
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment; filename=".$file_name.".xls");
        echo $output;
    }
    else{
        echo '
            <p class="display-3">No Record Found!</p>
        ';
    }
}

function get_date($timestamp){
    $new_time = explode(" ",$timestamp);
    return $new_time[0];
}
function get_time($timestamp){
    $new_time = explode(" ",$timestamp);
    return date("g:i a", strtotime($new_time[1]));
}

?>
