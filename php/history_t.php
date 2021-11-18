<?php
require_once "config.php";
// Initialize the session
session_start();
//header("content-type:text/html:charset=utf-8");
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$account = $_SESSION["account"];
$username = $_SESSION["username"];

// Processing form data when form is submitted
$hisdlc = mysqli_query($link, "SELECT time FROM opcourse where professor = '$account'");
$result = mysqli_query($link, "SELECT * FROM opcourse where professor = '$account' order by date_time desc");

$hhisdlc = mysqli_query($link, "SELECT time FROM history where professor = '$account'");
$hresult = mysqli_query($link, "SELECT * FROM history where professor = '$account'order by date_time desc");

//echo $_GET['id'];
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $_SESSION["account"] = $account; 
    $_SESSION["username"] = $username;
    header("location: seat_t.php");
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>線上點名系統-點名紀錄</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
    <link rel=stylesheet type="text/css" href="my_css.css">
</head>

<body background="background1.jpg">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="welcome_t.php">線上教室點名系統</a>
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
                    $("#menu").load("menu_t.html");

                </script>
                <div class="col-md-9">
                    <div id="fs-content" class="fs-content">
                        <div class='row'>
                            <div class='col-xs-12'>
                                <div style="border:2px #7badcb solid;">
                                    <!--                                    <div id="xbox2-inline" class="clearfix">-->
                                    <!--                                        <div class='module app-dashboard app-dashboard-show '>-->
                                    <div class="fs-block" style=''>
                                        <div class="block-title">
                                            <div style="border-width: 5px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                <span style="color:#FFFFFF;">點名紀錄</span>
                                            </div>
                                        </div>
                                        <div class="fs-block-body ">
                                            <div class="container con">
                                                <div style='margin-left:10px; margin-right:10px; margin-bottom:20px; margin-top:20px;'>
                                                    <table width="100%">
                                                        <thead>
                                                            <tr height="30px">
                                                                <th width="auto">&nbsp;項次</th>
                                                                <th width="auto">&nbsp;&nbsp;課程</th>
                                                                <th width="auto">教室</th>
                                                                <th width="auto">&nbsp;開放點名時間</th>
                                                                <th width="auto">&nbsp;點名截止時間</th>
                                                                <th width="auto">&nbsp;&nbsp;狀態</th>
                                                                <th width="auto">&nbsp;&nbsp;查看</th>
                                                                <th width="auto">&nbsp;&nbsp;刪除</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                for($i=1;$i<=mysqli_num_rows($result);$i++){
                                                                    $row=mysqli_fetch_row($result);
                                                                    @$j+=1;
                                                            ?>
                                                            <tr height="30px">
                                                                <td>
                                                                    &nbsp;
                                                                    <?php echo $j;?>
                                                                </td>

                                                                <td>
                                                                    &nbsp;
                                                                    <?php 
                                                                        $coursenames = mysqli_query($link, "SELECT course_name FROM professor where course_code = '".$row['1']."'");
                                                                        $coursenamec = mysqli_fetch_array($coursenames);
                                                                        $coursename = @$coursenamec[0];
                                                                        echo $coursename;
                                                                    ?>
                                                                    &nbsp;&nbsp;
                                                                </td>

                                                                <td>
                                                                    <?php echo $row['3'];?>
                                                                </td>

                                                                <td>
                                                                    &nbsp;
                                                                    <?php echo $row['4'];?>
                                                                </td>

                                                                <td>
                                                                    &nbsp;
                                                                    <?php  echo $row['5'];?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                        $rs=mysqli_fetch_row($hisdlc);
                                                                        $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                        $date2 = $row['5']; 
                                                                        //echo $date1;
                                                                        //echo $date2;
                                                                        //echo (strtotime($date1)-strtotime($date2));
                                                                        if((strtotime($date1)-strtotime($date2))<0) {
                                                                             echo "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";
                                                                        } 
                                                                        else {
                                                                            echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>"; 
                                                                        }
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo '<input type="button" name="id" value="查看" onclick=location.href="seat_t.php?id=' . $row[0] . '">'?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                        $drs=mysqli_fetch_row($hisdlc);
                                                                        $ddate1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                        $ddate2 = $row['5']; 
                                                                        //echo $date2;
                                                                        if((strtotime($ddate1)-strtotime($ddate2))<0) {
                                                                    ?>
                                                                    <input type="button" name="hdel" value="刪除" onclick="delForm('<?php echo $row['0']?>')">
                                                                    <script language="javascript">
                                                                        function delForm(id) {
                                                                            if (confirm("確認刪除此點名單嗎?")) {
                                                                                location.href = "opallcourse.php?del=" + id
                                                                                alert("點名單已刪除!");
                                                                            }
                                                                        }

                                                                    </script>
                                                                    <?php
                                                                        } 
                                                                        else {
                                                                            echo '<input type="button" value="刪除" disabled=disabled   style="background-color:gray;"">';    
                                                                        } 
                                                                    ?>
                                                                </td>
                                                                <?php  
                                                                    }
                                                                ?>
                                                            </tr>
                                                            <?php
                                                                for($i=1;$i<=mysqli_num_rows($hresult);$i++){
                                                                    $row=mysqli_fetch_row($hresult);
                                                                    @$j+=1;
                                                            ?>
                                                            <tr height="30px">
                                                                <td>
                                                                    &nbsp;
                                                                    <?php echo $j;?>
                                                                </td>

                                                                <td>
                                                                    &nbsp;
                                                                    <?php  
                                                                        $coursenames = mysqli_query($link, "SELECT course_name FROM professor where course_code = '".$row['1']."'");
                                                                        $coursenamec = mysqli_fetch_array($coursenames);
                                                                        $coursename = @$coursenamec[0];
                                                                        echo $coursename;
                                                                    ?>
                                                                    &nbsp;&nbsp;
                                                                </td>

                                                                <td>
                                                                    <?php echo $row['3'];?>
                                                                </td>

                                                                <td>

                                                                    <?php echo $row['4'];?>
                                                                </td>

                                                                <td>

                                                                    <?php echo $row['5'];?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                        $rs=mysqli_fetch_row($hhisdlc);
                                                                        $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                        $date2 = $row['5']; 
                                                                        if((strtotime($date1)-strtotime($date2))<0) {
                                                                            echo "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";  
                                                                        }else {
                                                                            //echo @(strtotime($link, $date1)-strtotime($link, $date2));
                                                                            echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>";
                                                                        } 
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo '<input type="button" name="id" value="查看" onclick=location.href="seat_t.php?id=' . $row[0] . '">'?>
                                                                </td>


                                                                <td>
                                                                    <?php
                                                                        $drs=mysqli_fetch_row($hhisdlc);
                                                                        $ddate1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                        $ddate2 = $row['5']; 
                                                                        if((strtotime($ddate1)-strtotime($ddate2))<0) {
                                                                    ?>
                                                                    <input type="button" name="hdel" value="刪除" onclick="delForm('<?php echo $row['0']?>')">
                                                                    <script language="javascript">
                                                                        function delForm(id) {
                                                                            if (confirm("確認刪除此點名單嗎?")) {
                                                                                location.href = "opallcourse.php?del=" + id
                                                                                alert("點名單已刪除!");
                                                                            }
                                                                        }

                                                                    </script>
                                                                    <?php
                                                                        }
                                                                        else {
                                                                            echo '<input type="button" value="刪除" disabled=disabled style="background-color:gray;" ">';     
                                                                        } 
                                                                    ?>
                                                                </td>
                                                                <?php  
                                                                    }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--                                                    </div>-->
                                                    <!--                                                </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id='page-banner'>
                    <div class=" fs-banner fs-sys-banner hidden-xs fs-banner-background-horizontal-position-center fs-banner-background-vertical-position-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="fs-banner-wrap" style='height:30px'>
                                        <div class='fs-banner-text fs-banner-title' style='color:#ffffff'>
                                            <a href='/'></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
            <div id='page-footer'>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class='fs-html fs-hint'>
                                <div class=''>
                                    <div style="text-align:center;">Copyright © 臺北市立大學 All rights reserved.<br /><a href="http://www.powercam.com.tw/">台灣數位學習科技</a>&nbsp;建置</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
-->
            </div>
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
