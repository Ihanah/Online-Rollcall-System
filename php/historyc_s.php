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

$scourse = mysqli_query($link, "SELECT course_code FROM stucourse where stu_id = '$account'" );
$scourse_code = mysqli_query($link, "SELECT course_code FROM stucourse where stu_id = '$account'");


$hhisdlc = mysqli_query($link, "SELECT time FROM rollcall where professor = '$username'");

$result = mysqli_query($link, "SELECT * FROM rollcall where account = '$account' order by date_time desc");

$cn = $_GET['cn'];
//echo $cn;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start(); 
    $_SESSION["account"] = $account; 
    $_SESSION["username"] = $username;
    header("location: rollcall_s.php");

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>線上點名系統-快速查詢</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
    <link rel=stylesheet type="text/css" href="my_css.css">
</head>

<body background="background1.jpg">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div id="test"></div>
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="welcome_s.php">線上教室點名系統</a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li class="dropdown">
                            <a href=" " class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo $username?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="logout.php"><span class='glyphicon glyphicon-log-out' aria-hidden='true'>
                                            <span style="font-family: 'Microsoft JhengHei'; font-weight: bold; font-size: 15px;"><i class="fa fa-btn fa-sign-out"></i>登出</span></span></a></li>

                                <li><a href="reset-password.php"><span class='glyphicon glyphicon-lock' aria-hidden='true'>
                                            <span style="font-family: 'Microsoft JhengHei'; font-weight: bold; font-size: 15px;"><i class="fa fa-btn fa-sign-out"></i>重設密碼</span></span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="header"><?php echo $username?></div>
        <script>
            $("#header").load("header_s.html");

        </script>

        <div class="container">
            <div class="row">
                <div id="menu"></div>
                <script>
                    $("#menu").load("menu_s.html");

                </script>
                <div class="col-md-9">
                    <div id="fs-content" class="fs-content">
                        <div class='row'>
                            <div class='col-xs-12'>
                                <div style="border:2px #7badcb solid;">
                                    <div id="xbox2-inline" class="clearfix">
                                        <div class='module app-dashboard app-dashboard-show '>
                                            <div class="fs-block" style=''>
                                                <div class="fs-block-header  clearfix">
                                                    <div class="block-title">
                                                        <div style="border-width: 5px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                            <span style="color:#FFFFFF;">紀錄查詢</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class="container con">
                                                            <div style='margin-left:10px;margin-right:10px;margin-top:20px;margin-bottom:20px;'>
                                                                <table width="100%">
                                                                    <tr height="30px">
                                                                        <th width="auto">&nbsp;&nbsp;項次</th>
                                                                        <th width="auto">&nbsp;&nbsp;課程</th>
                                                                        <th width="auto">&nbsp;&nbsp;教室</th>
                                                                        <th width="auto">&nbsp;&nbsp;點名時間</th>
                                                                        <th width="auto">&nbsp;&nbsp;點名截止時間</th>
                                                                        <th width="auto">&nbsp;&nbsp;狀態</th>
                                                                        <th width="auto">&nbsp;&nbsp;點名</th>
                                                                        <th width="auto">&nbsp;&nbsp;修改</th>
                                                                    </tr>

                                                                    <?php 
                                                                        $ihisdtc = mysqli_query($link, "SELECT date FROM opcourse where course_code = '$cn'");
                                                                        $ihisdlc = mysqli_query($link, "SELECT time FROM opcourse where course_code = '$cn'");
                                                                        $iresult = mysqli_query($link, "SELECT * FROM opcourse where course_code = '$cn'");  
                                                                        while($irow = mysqli_fetch_array($iresult)){
                                                                            @$i+=1;
                                                                    ?>

                                                                    <tr height="30px">
                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $i ?>
                                                                        </td>
                                                                        
                                                                        <td>
                                                                            &nbsp;
                                                                            <button name="courbtn" type="submit" style="background-color: transparent; border:0; color:#4169E1;" value="<?php echo $irow['course_code']?>">
                                                                                <?php 
                                                                                    $coursenames = mysqli_query($link, "SELECT course_name FROM professor where course_code = '".$irow['course_code']."'");
                                                                                    $coursenamec = mysqli_fetch_array($coursenames);
                                                                                    $coursename = @$coursenamec[0];
                                                                                    echo $coursename;
                                                                                ?>
                                                                            </button>
                                                                        </td>

                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $irow['class']?>
                                                                        </td>

                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $irow['date_time']?>
                                                                        </td>

                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $irow['time']?>
                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                                $irs=mysqli_fetch_row($ihisdlc);
                                                                                $idate1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                                $idate2 = @$irs[0]; 
                                                                                //echo $date2;
                                                                                //echo $date2;
                                                                                if((strtotime($idate1)-strtotime($idate2))<0) {
                                                                                    echo "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";  
                                                                                }else {
                                                                                    //echo @(strtotime($link, $date1)-strtotime($link, $date2));
                
                                                                                    echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>";
                                                                                } 
                                                                            ?>
                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                            $icheck_sql = "SELECT account FROM rollcall WHERE course_code = '".$irow['course_code']."' and date_time = '".$irow['date_time']."' and account = '$account'" ;
                                                                            $icheck_rs = mysqli_query($link, $icheck_sql);
                                                                            $icheck = mysqli_fetch_array($icheck_rs);
                                                                            if($icheck == 0){   
                                                                                echo "<font color=red>"."&nbsp;&nbsp;未點名"."</font>" ;
                                                                            }else{
                                                                                echo "<font color=gray>"."&nbsp;&nbsp;已點名"."</font>";     
                                                                            }
                                                                        ?>
                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                            $result = mysqli_query($link, "SELECT * FROM rollcall WHERE course_code = '".$irow['course_code']."' and date_time = '".$irow['date_time']."' and account = '$account'");
                                                                            $row=mysqli_fetch_row($result);
                                                                            $drs=mysqli_fetch_row($ihisdlc);
                                                                            $idate1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                            $idate2 = @$irs[0]; 
                                                                            if((strtotime($idate1)-strtotime($idate2))<0) {
                                                                                echo '<input type="button" name="hdel" value="修改"   onclick=location.href="rollcall_s.php?del=' . @$row[0] . '">';
                    
                                                                            } else {
                                                                                echo '<input type="button" value="修改" disabled=disabled   style="background-color:gray;"">';    
                                                                            } 
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php       
                                                                    }
                                                                 ?>

                                                                    <?php 
                                                                        $hisdtc = mysqli_query($link, "SELECT date_time FROM history where course_code = '$cn' order by date_time desc");
                                                                        $hisdlc = mysqli_query($link, "SELECT time FROM history where course_code = '$cn'");
                                                                        $result = mysqli_query($link, "SELECT * FROM history where course_code = '$cn'order by date_time desc");
                
                                                                        while($row = mysqli_fetch_array($result)){
                                                                            @$i+=1;
                                                                    ?>

                                                                    <tr height="30px">
                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $i?>
                                                                        </td>
                                                                        
                                                                        <td>
                                                                            &nbsp;
                                                                            <button name="courbtn" type="submit" style="background-color: transparent; border:0; color:#4169E1;" value="<?php echo $row['course_code']?>">
                                                                                <?php 
                                                                                    $coursenames = mysqli_query($link, "SELECT course_name FROM professor where course_code = '".$row['course_code']."'");
                                                                                    $coursenamec = mysqli_fetch_array($coursenames);
                                                                                    $coursename = @$coursenamec[0];
                                                                                    echo $coursename;
                                                                                ?>
                                                                            </button>
                                                                        </td>

                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $row['class']?>
                                                                        </td>

                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $row['date_time']?>
                                                                        </td>

                                                                        <td>
                                                                            &nbsp;&nbsp;<?php echo $row['time']?>
                                                                        </td>

                                                                        <td>
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

                                                                        <td>
                                                                            <?php
                                                                            $check_sql = "SELECT account FROM rollcall WHERE course_code = '".$row['course_code']."' and date_time = '".$row['date_time']."' and account = '$account'" ;
                                                                            $check_rs = mysqli_query($link, $check_sql);
                                                                            $check = mysqli_fetch_array($check_rs);
                                                                            if($check == 0){   
                                                                                 echo "<font color=red>"."&nbsp;&nbsp;未點名"."</font>" ;
                                                                            }else{
                                                                                echo "<font color=gray>"."&nbsp;&nbsp;已點名";     
                                                                            }
                                                                        ?>
                                                                        </td>

                                                                        <td>
                                                                            <?php 
                                                                            echo '<input type="button" value="修改" disabled=disabled   style="background-color:gray;"">';
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php       
                                                                    }
                                                                ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer"></div>
            <script>
                $("#footer").load("footer.html");

            </script>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="datetimepicker.js"></script>
    <script>
        $("#datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });

    </script>


</body>

</html>
