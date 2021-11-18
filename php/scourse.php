<?php
require_once "config.php";
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$account = $_SESSION["account"];
$username = $_SESSION["username"];
$searchcourse = $_SESSION["searchcourse"];


$hisdlc = mysqli_query($link, "SELECT time FROM opcourse where professor = '$account' && course_name = '$searchcourse'");
$result = mysqli_query($link, "SELECT * FROM opcourse where professor = '$account' && course_name = '$searchcourse' order by date_time desc");

$hhisdlc = mysqli_query($link, "SELECT time FROM history where professor = '$username'&& course_name = '$searchcourse'");
$hresult = mysqli_query($link, "SELECT * FROM history where professor = '$username'&& course_name = '$searchcourse' order by date_time desc");



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $rollcallc = $_POST['seatbtn'];
    session_start(); 
    $_SESSION["account"] = $account; 
    $_SESSION["username"] = $username;
    $_SESSION["searchcourse"] = $rollcallc;
    header("location: seat_t.php");

    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="welcome_t.php">線上教室點名系統</a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li class="dropdown">
                        <a href=" " class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $username?><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="logout.php"><i class="fa fa-btn fa-sign-out"></i>登出</a></li>
                            <li><a href="reset-password.php"><i class="fa fa-btn fa-sign-out"></i>重設密碼</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
       
    <p> 
        
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
        <a href="opcourse.php" class="btn btn-primary" value="教師開課">教師開課</a>
        <a href="history_t.php" class="btn btn-primary" value="開課紀錄">開課紀錄</a>
<!--        <a href="opcourse.php" class="btn btn-warning">教師開課</a>-->  <p></p>
    <form>
        <p></p>
        <center>
        <table border='1'>
        <tr height="30px">
            <th height="30px" width="180">&nbsp;&nbsp;課程</th>
            <th height="30px" width="60">&nbsp;&nbsp;教室</th>
            <th height="30px" width="180">&nbsp;&nbsp;開放點名時間</th>
            <th height="30px" width="160">&nbsp;&nbsp;點名截止時間</th>
            <th height="30px" width="60">&nbsp;&nbsp;狀態</th>
            <th height="30px" width="45">&nbsp;&nbsp;查看</th>
            <th height="30px" width="45">&nbsp;&nbsp;刪除</th>
        </tr>
        
       <?php
            for($i=1;$i<=mysqli_num_rows($result);$i++){
                $row=mysqli_fetch_row($result);
        ?>
            <tr>
            
            <td  height="30px" width="180" name="course_name" value='$course_name'>
            &nbsp;&nbsp;
            <?php echo $row['2'];?>            
            </td>
                
            <td height="30px" width="60" name="class" value='$class'>
            &nbsp;&nbsp;
            <?php echo $row['4'];?>
            </td>
                
            <td height="30px" width="180" name="date_time">
            &nbsp;&nbsp;
            <?php echo $row['5']; ?>
            </td>
            
            <td  height="30px" width="180" name="time" value='$time'>
            &nbsp;&nbsp;
            <?php echo $row['6'];?>  
            </td>
                 
            <td height="30px" width="70">    
            <?php
                $rs=mysqli_fetch_row($hisdlc);
                $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                $date2 = @$rs[0]; 
                //echo $date2;
                //echo $date2;
                if((strtotime($date1)-strtotime($date2))<0) {
                    echo "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";
                    } else {
                    //echo @(strtotime($link, $date1)-strtotime($link, $date2));
                    echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>";
                } 
            ?>
            </td>
                
            <td align="center">
                <?php echo '<input type="button" name="id" value="查看" onclick=location.href="seat_t.php?id=' . $row[0] . '">'?>
            </td>
                
             <td align="center">
            <?php
                $drs=mysqli_fetch_row($hisdlc);
                $ddate1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                $ddate2 = @$rs[0]; 
                //echo $date2;
                if((strtotime($ddate1)-strtotime($ddate2))<0) {
                    echo '<input type="button" name="del" value="刪除" onclick=del=' . $row[0] . '">'; 
                } else {
                    echo '<input type="button" name="del" value="刪除" disabled=disabled   style="background-color:gray;" onclick=del=' . $row[0] . '">'; 
                    
                } 
                ?>
            </td>      
            <?php  }?>
            </tr>
            
            
            <?php
            for($i=1;$i<=mysqli_num_rows($hresult);$i++){
                $row=mysqli_fetch_row($hresult);
        ?>
            <tr>
      
            <td  height="30px" width="180" name="course_name" value='$course_name'>
            &nbsp;&nbsp;
            <?php  echo $row['2'];?>
            </td>
                
            <td height="30px" width="60" name="class" value='$class'>
            &nbsp;&nbsp;
            <?php echo $row['4'];?>
            </td>
                
            <td height="30px" width="180" name="date_time">
            &nbsp;&nbsp;
            <?php echo $row['5'];?>
            </td>
            
            <td  height="30px" width="180" name="time" value='$time'>
            &nbsp;&nbsp;
            <?php echo $row['6'];?>
            </td>
                 
            <td height="30px" width="70">    
            <?php
                $rs=mysqli_fetch_row($hhisdlc);
                $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                $date2 = @$rs[0]; 
                //echo $date2;
                //echo $date2;
                if((strtotime($date1)-strtotime($date2))<0) {
                    echo  "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";
                } else {
                    //echo @(strtotime($link, $date1)-strtotime($link, $date2));
                    echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>";
                } 
            ?>
            </td>
                
            <td align="center">
                <?php echo '<input type="button" name="id" value="查看" onclick=location.href="seat_t.php?id=' . $row[0] . '">'?>
            </td>
           
                
            <td align="center">
            <?php
                $drs=mysqli_fetch_row($hhisdlc);
                $ddate1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                $ddate2 = @$rs[0]; 
                //echo $date2;
                //echo $date2;
                if((strtotime($ddate1)-strtotime($ddate2))<0) {
                    echo '<input type="button" name="del" value="刪除"  onclick=del=' . $row[0] . '">'; 
                } else {
                    echo '<input type="button" name="del" value="刪除" disabled=disabled   style="background-color:gray;" ">';     
                } 
                ?>
            </td>
                
                
            <?php  }?>
            </tr>

            </table>
        </center>
        <p></p>

    </form>
 
    <a href="search.php" class="btn btn-danger">重新查詢</a> <p></p> 
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>