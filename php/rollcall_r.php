<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
$coursename_err = "";

$account = $_SESSION['account'];
$username = $_SESSION["username"];
$courseid = $_SESSION["courseid"];
//echo $courseid;

$cn = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$courseid'");
$course_name = mysqli_fetch_row($cn);

$hisdtc = mysqli_query($link, "SELECT date_time FROM opcourse where course_code = '$courseid'");
$rt = mysqli_fetch_row($hisdtc);

$hisdlc = mysqli_query($link, "SELECT time FROM opcourse where course_code = '$courseid'");
$rs = mysqli_fetch_row($hisdlc);

$hisdlc = mysqli_query($link, "SELECT time FROM opcourse where course_code = '$courseid'");
$result = mysqli_query($link, "SELECT * FROM opcourse where course_code = '$courseid' order by date_time desc");

$hhisdlc = mysqli_query($link, "SELECT time FROM history where course_code = '$courseid'");
$hresult = mysqli_query($link, "SELECT * FROM history where course_code = '$courseid' order by date_time desc");

$date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
$date2 = @$rs[0];
$date3 = @$rt[0];

$del = @$_GET['del'];
echo $del;
$delc = @$_GET['delc'];
echo $delc;

$del = mysqli_query($link, "DELETE FROM stucourse where stu_id = '$del' && course_code = '$delc'");


if($_SERVER["REQUEST_METHOD"] == "POST"){
      
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["account"] = $account; 
    $_SESSION["username"] = $username;
    $_SESSION["professor"] = $professor;  
    $_SESSION["coursename"] = $courseid;
    $_SESSION["courseid"] = $course_name[0];
    $_SESSION["class"] = $class;
    $_SESSION["date_time"] = $date_time;
    header("location: opcourse.php");
                        
    // Close connection
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>教室點名系統-<?php echo ''.$course_name[0].'('.$courseid.')'?></title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/static/bootstrap-table/bootstrap-table.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.js"></script>
    <script src="/static/bootstrap-table/bootstrap-table.js"></script>
    <script src="/static/bootstrap-table/locals/bootstrap-table-zh-CN.js"></script>
    <style type="text/css">
        body {
            font-family: 微軟正黑體;
            font-weight: bold;
            font-size: 16px;
        }

        .fs-menu ul li a {
            color: #191970;
        }

        .fs-menu ul.nav li {
            color: #191970;
            background: #ffffff;
        }

        .fs-block-body {
            background: #ffffff;
        }

        .navbar-default {
            font-size: 18px;
            background: #F5F5F5;
        }

        .navbar.container.navbar-header a {
            color: white;
        }

        .navbar-default .navbar-nav>li>a,
        .dropdown>a {
            font-size: 17px;
            color: #696969;
        }

        .navbar-default .navbar-nav>li>a,
        .dropdown>ul>li>a {
            color: #696969;
        }

        .navbar-default .navbar-header>a {
            font-size: 20px;
            color: #696969;
        }

        .con {
            width: 850px;
        }

        .table {
            width: 850px;
            box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
            /* 阴影 */
            border-collapse: collapse;
            /* 取消表格边框 */
        }

        table,
        th,
        tr,
        td {
            border-bottom: 1px solid #dedede;
            /* 表格横线 */
            padding: 6px;
        }

        th {
            background-color: #628ea8;
            color: #ffffff;
        }

        tr:nth-of-type(odd) {
            background-color: #d8e6ef;
        }
        
        li { 
            line-height:25px; 
            padding 3px 10px 3px 10px;
            font-size: 17px;
        }

    </style>
</head>

<body background="background1.jpg">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="welcome_r.php">線上教室點名系統</a>
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
                                <li><a href="logout.php"><i class="fa fa-btn fa-sign-out"></i>登出</a></li>
                                <li><a href="reset-password.php"><i class="fa fa-btn fa-sign-out"></i>重設密碼</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id='page-banner'>
            <div class="fs-banner fs-sys-banner hidden-xs fs-banner-background-horizontal-position-center fs-banner-background-vertical-position-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="fs-banner-wrap" style='height:10px'>
                                <div class='fs-banner-text fs-banner-title' style='color:#ffffff'>
                                    <a href='/'></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <center><img class="banner-logo" src="banner4.png" alt="yamoo9.com" width="1140" height="320" /></center>
        <div id='page-banner'>
            <div class="fs-banner fs-sys-banner hidden-xs fs-banner-background-horizontal-position-center fs-banner-background-vertical-position-center">
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

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div style="border:2px #7badcb solid;">
                        <div class="drawer-contents-reserve ">
                            <div class="drawer-body-reserve ">
                                <div id="mbox-front" class="clearfix" role="placeable"></div>
                                <div id="mbox-inline" class="clearfix">
                                    <div class='module mod_dashboard mod_dashboard-dashboardSidebar '>
                                        <div style="border-width: 3px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                            <span style="color:#FFFFFF;">我的首頁</span>
                                        </div>
                                        <div class='fs-menu'>
                                            <ul class='nav'>
                                                <li class='  '>
                                                    <a href='welcome_r.php'>資料匯入</a>
                                                </li>
                                                <li class='  '>
                                                    <a href='manage_u.php'>使用者管理</a>
                                                </li>
                                                <li class='  '>
                                                    <a href='manage_t.php'>課程管理</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="fs-content" class="fs-content">
                        <div class='row'>
                            <div class='col-xs-12'>
                                <div style="border:2px #7badcb solid;">
                                    <div id="xbox2-inline" class="clearfix">
                                        <div class='module app-dashboard app-dashboard-show '>
                                            <div class="fs-block " style=''>
                                                <div class="fs-block-header  clearfix">
                                                    <div class="block-title">
                                                        <div style="border-width: 5px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                            <span style="color:#FFFFFF;">課程管理</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class="container con">
                                                            <div class="main">
                                                                <div style='margin-top:10px; margin-bottom:20px; margin-left:10px; margin-right:10px;'>
                                                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                                        <h2><?php echo ''.$course_name[0].'('.$courseid.')'?>
                                                                            <a href="#edit<?php echo $courseid;?>" data-toggle="modal">
                                                                                <button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-list' aria-hidden='true'></span> 課程名單</button>
                                                                            </a>
                                                                        </h2>
                                                                        <div id="edit<?php echo $courseid;?>" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <form method="post" class="form-horizontal" role="form">
                                                                                <div class="modal-dialog">
                                                                                    <!-- Modal content-->
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header" height = "100px">
<!--                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                                                                            <h3>課程名單</h3>
                                                                                            <h4><?php echo ''.$course_name[0].'('.$courseid.')'?></h4>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <table>
                                                                                                <tr height="30px">
                                                                                                    <th height="30px" width="50">項次</th>
                                                                                                    <th height="30px" width="160">&nbsp;&nbsp;學號</th>
                                                                                                    <th height="30px" width="110">&nbsp;&nbsp;姓名</th>
                                                                                                    <th height="30px" width="110">&nbsp;&nbsp;系級</th>
                                                                                                    <th height="30px" width="80">缺席次數</th>
                                                                                                    <th height="30px" width="60">&nbsp;&nbsp;刪除</th>
                                                                                                </tr>
                                                                                                <?php 
                                                                                                    $stulist = mysqli_query($link, "SELECT * FROM stucourse where course_code = '$courseid'");  
                                                                                                    for($i=1;$i<=mysqli_num_rows($stulist);$i++){
                                                                                                        $row=mysqli_fetch_row($stulist);
                                                                                                        $stuid = $row['3'];
                                                                                                        //echo $stuid;
                                                                                                        $stuidc = mysqli_query($link, "SELECT username FROM users where account = '$stuid'");
                                                                                                        $stuidr = mysqli_fetch_array($stuidc);
                                                                                                        $stuidg = @$stuidr[0];
                                                                                                        //echo $stuidg;
                                                                                                        $studep = mysqli_query($link, "SELECT department FROM users where account = '$stuid'");
                                                                                                        $studepr = mysqli_fetch_array($studep);
                                                                                                        $studepg = @$studepr[0];
                                                                                                        //echo $stuidg;
                                                                                                ?>

                                                                                                <tr>
                                                                                                    <td height="30px" width="40">
                                                                                                        &nbsp;&nbsp;<?php echo $i?>
                                                                                                    </td>

                                                                                                    <td height="30px" width="160">
                                                                                                        &nbsp;&nbsp;<?php echo $row['3']?>
                                                                                                    </td>

                                                                                                    <td height="30px" width="110">
                                                                                                        &nbsp;&nbsp;<?php echo $stuidg?>
                                                                                                    </td>

                                                                                                    <td height="30px" width="110">
                                                                                                        &nbsp;&nbsp;<?php echo $studepg?>
                                                                                                    </td>

                                                                                                    <td height="30px" width="80">
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                        <?php
                                                                                                            $itime = mysqli_query($link, "SELECT * FROM history where course_code = '$courseid'");
                                                                                                            $itimec = mysqli_num_rows($itime);
                                                                                                            //echo $itimec;
                                                                                                            $otime = mysqli_query($link, "SELECT * FROM opcourse where course_code = '$stuid'");
                                                                                                            $otimec = mysqli_num_rows($otime);
                                                                                                            //echo $itimec;
                                                                                                            $stutime = mysqli_query($link, "SELECT * FROM rollcall where course_code = '$courseid' and account = '$stuid'");
                                                                                                            $stutimec = mysqli_num_rows($stutime);
                                                                                                            //echo $stutimec;
                                                                                        
                                                                                                            echo $otimec+$itimec-$stutimec;   
                                                                                                        ?>
                                                                                                    </td>
                                                                                                    
                                                                                                    <td>
                                                                                                        <input type="button" name="hdel" value="刪除" onclick="delForm('<?php echo $stuid?>', '<?php echo $courseid?>')">
                                                                                                        <script language="javascript">
                                                                                                            function delForm(id, cid) {
                                                                                                                if (confirm("確認刪除此使用者嗎?")) {
                                                                                                                    location.href = "rollcall_r.php?del=" + id + "&delc=" + cid
                                                                                                                    alert("使用者已刪除!");
                                                                                                                }
                                                                                                            }
                                                                                                        </script>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php 
                                                                                                    }
                                                                                                ?>
                                                                                            </table>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </form>

                                                                    <table>
                                                                        <tr height="35px">
                                                                            <th height="30px" width="170">&nbsp;&nbsp;課程</th>
                                                                            <th height="30px" width="90">&nbsp;&nbsp;教室</th>
                                                                            <th height="30px" width="190">&nbsp;&nbsp;開放點名時間</th>
                                                                            <th height="30px" width="190">&nbsp;&nbsp;點名截止時間</th>
                                                                            <th height="30px" width="80">&nbsp;&nbsp;狀態</th>
                                                                            <th height="30px" width="70">&nbsp;&nbsp;查看</th>
                                                                        </tr>

                                                                        <?php
                                                                            for($i=1;$i<=mysqli_num_rows($result);$i++){
                                                                                $row=mysqli_fetch_row($result);
                                                                        ?>

                                                                        <tr>
                                                                            <td height="30px" width="170">
                                                                                &nbsp;&nbsp;
                                                                                <?php 
                                                                                    $coursenames = mysqli_query($link, "SELECT course_name FROM professor where course_code = '".$row['1']."'");
                                                                                    $coursenamec = mysqli_fetch_array($coursenames);
                                                                                    $coursename = @$coursenamec[0];
                                                                                    echo $coursename;
                                                                                ?>
                                                                            </td>

                                                                            <td height="30px" width="90">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['3'];?>
                                                                            </td>

                                                                            <td height="30px" width="190">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['4']; ?>
                                                                            </td>

                                                                            <td height="30px" width="190">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['5'];?>
                                                                            </td>

                                                                            <td height="30px" width="80">
                                                                                <?php
                                                                                    $rs=mysqli_fetch_row($hisdlc);
                                                                                    $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                                    $date2 = @$rs[0]; 
                                                                                    //echo $date2;
                                                                                    //echo $date2;
                                                                                    if((strtotime($date1)-strtotime($date2))<0) {
                                                                                        echo  "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";
                                                                                    } 
                                                                                    else {
                                                                                        //echo @(strtotime($link, $date1)-strtotime($link, $date2));
                                                                                        echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>";
                                                                                    } 
                                                                                ?>
                                                                            </td>

                                                                            <td align="center">
                                                                                <?php echo '<input type="button" name="id" value="查看" onclick=location.href="seat_u.php?id=' . $row[0] . '">'?>
                                                                            </td>

                                                                            <?php  
                                                                                }
                                                                            ?>
                                                                        </tr>

                                                                        <?php
                                                                            for($i=1;$i<=mysqli_num_rows($hresult);$i++){
                                                                                $row=mysqli_fetch_row($hresult);
                                                                            ?>
                                                                        <tr>

                                                                            <td height="30px" width="170">
                                                                                &nbsp;&nbsp;
                                                                                <?php  
                                                                                    $coursenames = mysqli_query($link, "SELECT course_name FROM professor where course_code = '".$row['1']."'");
                                                                                    $coursenamec = mysqli_fetch_array($coursenames);
                                                                                    $coursename = @$coursenamec[0];
                                                                                    echo $coursename;
                                                                                ?>
                                                                            </td>

                                                                            <td height="30px" width="90">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['3'];?>
                                                                            </td>

                                                                            <td height="30px" width="190">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['4'];?>
                                                                            </td>

                                                                            <td height="30px" width="190">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['5'];?>
                                                                            </td>

                                                                            <td height="30px" width="80">
                                                                                <?php
                                                                                    $rs=mysqli_fetch_row($hhisdlc);
                                                                                    $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
                                                                                    $date2 = @$rs[0]; 
                                                                                    //echo $date2;
                                                                                    //echo $date2;
                                                                                    if((strtotime($date1)-strtotime($date2))<0) {
                                                                                        echo  "<font color=blue>"."&nbsp;&nbsp;開放中"."</font>";
                                                                                    } 
                                                                                    else {
                                                                                        //echo @(strtotime($link, $date1)-strtotime($link, $date2));
                                                                                        echo "<font color=gray>"."&nbsp;&nbsp;已結束"."</font>";
                                                                                    } 
                                                                                ?>
                                                                            </td>

                                                                            <td align="center">
                                                                                <?php echo '<input type="button" name="id" value="查看" onclick=location.href="seat_u.php?id=' . $row[0] . '">'?>
                                                                            </td>
                                                                            <?php  
                                                                                }
                                                                            ?>
                                                                        </tr>
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
            </div>
            <div id='page-banner'>
                <div class="fs-banner fs-sys-banner hidden-xs fs-banner-background-horizontal-position-center fs-banner-background-vertical-position-center">
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
                                        <div style="text-align:center;">臺北市立大學 資訊科學系 <a href="http://www.powercam.com.tw/">台灣數位學習科技</a>&nbsp;建置</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
-->

        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='js/jquery-1.10.2.min.js'></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
