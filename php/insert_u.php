<?php

include_once ("config.php"); //連線資料庫 
$action0 = @$_GET['action0']; 

if ($action0 == 'user'){ //匯入CSV  
    $filename = $_FILES['file0']['tmp_name']; 
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
        
        $authority = $result[$i][0];
        $account = iconv('utf-8', 'gb2312', $result[$i][1]);
        $username= mb_convert_encoding($result[$i][2], 'UTF-8');
        $password = iconv('utf-8', 'gb2312', $result[$i][3]);
     
        $data_values .= "('$authority','$account','$username','$password'),"; 
    } 
    $data_values = substr($data_values,0,-1); //去掉最後一個逗號 
    fclose($handle); //關閉指標 
    $query = mysqli_query($link, "insert into users (authority,account,username,password) values $data_values"); //批量插入資料表中 
    if($query) { 
        echo "<script> alert('匯入成功！'); location.href = 'welcome_r.php';</script>"; 
    }else{ 
        echo "<script> alert('匯入失敗！'); location.href = 'welcome_r.php';</script>";  
    } 
} 
elseif ($action0=='export'){
    
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


