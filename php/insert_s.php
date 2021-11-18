<?php

include_once ("config.php"); //連線資料庫 
$action2 = @$_GET['action2']; 

if($action2=='student'){
    $filename = $_FILES['file2']['tmp_name']; 
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
        
        $year = iconv('utf-8', 'gb2312', $result[$i][0]);
        $sem = mb_convert_encoding($result[$i][1], 'UTF-8');
        $stu_id = mb_convert_encoding($result[$i][2], 'UTF-8');
        $course_code = mb_convert_encoding($result[$i][3], 'UTF-8');
     
        $data_values .= "('$year', '$sem', '$stu_id', '$course_code'),"; 
    } 
    $data_values = substr($data_values,0,-1); //去掉最後一個逗號 
    fclose($handle); //關閉指標 
    $query = mysqli_query($link, "insert into stucourse (year, semester, stu_id, course_code) values $data_values"); //批量插入資料表中 
    if($query) { 
        echo "<script> alert('匯入成功！'); location.href = 'welcome_r.php';</script>"; 
    }else{ 
        echo "<script> alert('匯入失敗！'); location.href = 'welcome_r.php';</script>";   
    } 
}
elseif ($action2=='export'){
    
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


