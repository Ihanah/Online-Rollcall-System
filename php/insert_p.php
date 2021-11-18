<?php

include_once ("config.php"); //連線資料庫 
$action1 = @$_GET['action1']; 

if($action1=='professor'){
    $filename = $_FILES['file1']['tmp_name']; 
    if(empty($filename)) { 
        echo "<script> alert('請選擇要匯入的CSV檔案！'); location.href = 'welcome_r.php';</script>"; 
        exit; 
    } 
    $handle = fopen($filename, 'r'); 
    $result = input_csv($handle); //解析csv 
    $len_result = count($result); 
    if($len_result==0) { 
        echo '沒有任何資料！'; 
        exit; 
    } 
    for($i = 1; $i < $len_result; $i++){ //迴圈獲取各欄位值 
        
        $grade = mb_convert_encoding($result[$i][0], 'UTF-8');
        //$course_code = $result[$i][1];
        $course_name= mb_convert_encoding($result[$i][1], 'UTF-8');
        $course_code= mb_convert_encoding($result[$i][2], 'UTF-8');
        $professor = mb_convert_encoding($result[$i][3], 'UTF-8');
        $year = mb_convert_encoding($result[$i][4], 'UTF-8');
        $semester = mb_convert_encoding($result[$i][5], 'UTF-8');
     
        $data_values .= "('$grade','$course_name','$course_code', '$professor', '$year', '$semester'),"; 
    } 
    $data_values = substr($data_values,0,-1); //去掉最後一個逗號 
    fclose($handle); //關閉指標 
    $query = mysqli_query($link, "insert into professor (grade, course_name, course_code, account, year, semester) values $data_values"); //批量插入資料表中 
    if($query) { 
        echo "<script> alert('匯入成功！'); location.href = 'welcome_r.php';</script>"; 
    }else{ 
        echo "<script> alert('匯入失敗！'); location.href = 'welcome_r.php';</script>";   
    } 
}elseif ($action1=='export'){
    
}




function input_csv($handle){   
    $out = array ();   
    $n = 0;   
    while ($data = fgetcsv($handle, 10000)){   
        $num = count($data);   
        for ($i = 0; $i < $num; $i++){   
            $out[$n][$i] = $data[$i];   
        }   
        $n++;   
    }   
    return $out;   
}  

?>
