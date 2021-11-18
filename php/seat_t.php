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


$id = $_GET['id'];
//echo $id;

$course_code = mysqli_query($link, "SELECT course_code FROM history where id = '$id'");
$course_codec = mysqli_fetch_row($course_code);
$course_coder = @$course_codec[0];

$course_name = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$course_coder'");
$course_namec = mysqli_fetch_row($course_name);
$course_namer = @$course_namec[0];

$class = mysqli_query($link, "SELECT class FROM history where id = '$id'");
$classc = mysqli_fetch_row($class);
$classr = @$classc[0];
//echo $classr;

$date_time = mysqli_query($link, "SELECT date_time FROM history where id = '$id'");
$date_timec = mysqli_fetch_array($date_time);
$date_timer = @$date_timec[0];

$time = mysqli_query($link, "SELECT time FROM history where id = '$id'");
$timec = mysqli_fetch_array($time);
$timer = @$timec[0];

$icourse_code = mysqli_query($link, "SELECT course_code FROM opcourse where id = '$id'");
$icourse_codec = mysqli_fetch_row($icourse_code);
$icourse_coder = @$icourse_codec[0];

$icourse_name = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$icourse_coder'");
$icourse_namec = mysqli_fetch_row($icourse_name);
$icourse_namer = @$icourse_namec[0];

$iclass = mysqli_query($link, "SELECT class FROM opcourse where id = '$id'");
$iclassc = mysqli_fetch_row($iclass);
$iclassr = @$iclassc[0];
//echo $classr;

$idate_time = mysqli_query($link, "SELECT date_time FROM opcourse where id = '$id'");
$idate_timec = mysqli_fetch_array($idate_time);
$idate_timer = @$idate_timec[0];

$itime = mysqli_query($link, "SELECT time FROM opcourse where id = '$id'");
$itimec = mysqli_fetch_array($itime);
$itimer = @$itimec[0];

//echo $account;
//echo $username;

$stu_num = mysqli_query($link, "SELECT * FROM stucourse where course_code = '$course_coder'");
@$result=mysqli_query($link, $stu_num);
@$num=mysqli_num_rows($stu_num);
//echo $num;

$stucome_num = mysqli_query($link, "SELECT * FROM rollcall where course_code = '$course_coder' and date_time = '$date_timer'");
@$resultcome=mysqli_query($link, $stucome_num);
$comenum=mysqli_num_rows($stucome_num);
//echo $comenum;

$istu_num = mysqli_query($link, "SELECT * FROM stucourse where course_code = '$icourse_coder'");
@$iresult=mysqli_query($link, $istu_num);
@$inum=mysqli_num_rows($istu_num);
//echo $inum;

$istucome_num = mysqli_query($link, "SELECT * FROM rollcall where course_code = '$icourse_coder' and date_time = '$idate_timer'");
@$iresultcome=mysqli_query($link, $istucome_num);
$icomenum=mysqli_num_rows($istucome_num);

$classw = mysqli_query($link, "SELECT width FROM class where all_class = '$classr'");
$classwc = mysqli_fetch_array($classw);
$classwr = @$classwc[0];
//echo $classwr;
$classl = mysqli_query($link, "SELECT length FROM class where all_class = '$classr'");
$classlc = mysqli_fetch_array($classl);
$classlr = @$classlc[0];
//echo $classlr;

$iclassw = mysqli_query($link, "SELECT width FROM class where all_class = '$iclassr'");
$iclasswc = mysqli_fetch_array($iclassw);
$iclasswr = @$iclasswc[0];
//echo $classwr;
$iclassl = mysqli_query($link, "SELECT length FROM class where all_class = '$iclassr'");
$iclasslc = mysqli_fetch_array($iclassl);
$iclasslr = @$iclasslc[0];
//echo $classlr;



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
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
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
    <style>
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

        .clearfix {
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
            width: 820px;
        }

        .table {
            width: 800px;
            text-align: center;
        }

        table,
        th,
        tr,
        td {
            font-size: 14px;
            font-weight: bold;
        }

        .img {
            width: 85px;
            height: 120px;
            overflow: hidden;
            /*            background: #f80;*/
        }

        li {
            line-height: 25px;
            padding 3px 10px 3px 10px;
            font-size: 17px;
        }

    </style>
</head>

<body background="background1.jpg">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div id="test"></div>
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
                                    <div id="xbox2-inline" class="clearfix">
                                        <div class='module app-dashboard app-dashboard-show '>
                                            <div class="fs-block" style=''>
                                                <div class="fs-block-header clearfix">
                                                    <div class="block-title">
                                                        <div style="border-width: 5px; width: 845px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                            <span style="color:#FFFFFF;">座位點名單</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body">
                                                        <div style='margin-top:20px; margin-bottom:20px; margin-left:10px; margin-right:10px;'>
                                                            <div class="container con">
                                                                <center>
                                                                    <td>
                                                                        <div class="wrapper">
                                                                            <?php
                                                                                $check_sql = "SELECT id FROM opcourse WHERE id = '$id'";
                                                                                $check_rs = mysqli_query($link, $check_sql);
                                                                                $check = mysqli_fetch_array($check_rs);
                                                                                if($check == 0){ 
                                                                            ?>
                                                                            課程名稱:&nbsp;<?php echo $course_namer ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            教室:&nbsp;<?php echo $classr ?>&nbsp;&nbsp; <br>
                                                                            開放點名時間:&nbsp;<?php echo $date_timer ?>&nbsp;&nbsp; <br>
                                                                            點名結束時間:&nbsp;<?php echo $timer ?>&nbsp;&nbsp; <br>
                                                                            應到人數:&nbsp;<?php echo $num ?>&nbsp;&nbsp;&nbsp;
                                                                            實到人數:&nbsp;<?php echo $comenum ?>&nbsp;&nbsp;
                                                                            <a href="#edit<?php echo $id;?>" data-toggle="modal">
                                                                                <button type='button' style="background-color: transparent; border:0; color:#4169E1;"> 缺席名單</button>
                                                                            </a>

                                                                            <center>
                                                                                <div id="edit<?php echo $id;?>" class="modal fade" role="dialog">
                                                                                    <form method="post" class="form-horizontal" role="form">
                                                                                        <div class="modal-dialog">
                                                                                            <!-- Modal content-->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                    <h3><span class='glyphicon glyphicon-remove' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;缺席名單</span></span></h3>
                                                                                                    <?php echo $course_namer ?> (<?php echo $timer ?>)
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <table width="100%">
                                                                                                        <thead>
                                                                                                            <tr height="35px">
                                                                                                                <th width="auto">&nbsp;項次</th>
                                                                                                                <th width="auto">&nbsp;&nbsp;學號</th>
                                                                                                                <th width="auto">&nbsp;&nbsp;姓名</th>
                                                                                                                <th width="auto">&nbsp;系級</th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody id="tableId">
                                                                                                            <?php
                                                                                    
                                                                                                                $scourse_code = mysqli_query($link, "SELECT stucourse.* FROM stucourse WHERE stucourse.course_code='$course_coder' && stucourse.stu_id NOT IN (SELECT rollcall.account FROM rollcall where rollcall.date_time='$date_timer')");
                                                                                                                for($i=1;$i<=mysqli_num_rows($scourse_code);$i++){
                                                                                                                    $row=mysqli_fetch_row($scourse_code);
                                                                                                            ?>
                                                                                                            <tr height="40px">
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php echo $i;?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php echo $row['3'];?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php  
                                                                                                                        $usernames = mysqli_query($link, "SELECT username FROM users where account = '".$row['3']."'");
                                                                                                                        $usernamec = mysqli_fetch_array($usernames);
                                                                                                                        $username = @$usernamec[0];
                                                                                                                        echo $username;
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php  
                                                                                                                        $departments = mysqli_query($link, "SELECT department FROM users where account = '".$row['3']."'");
                                                                                                                        $departmentc = mysqli_fetch_array($departments);
                                                                                                                        $department = @$departmentc[0];
                                                                                                                        echo $department;
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <?php  
                                                                                                        }
                                                                                                    ?>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </center>

                                                                            <table border=1 height="500" style="text-align:center;" font-size="17px;">
                                                                                <tr>
                                                                                    <td width="50" height="10" align='center' valign="middle"></td>
                                                                                    <?php
                                                                                        for($c=1;$c<=$classwr;$c++){
                                                                                    ?>
                                                                                    <td width="55" height="10" align='center' valign="middle">
                                                                                        <?php echo $c;?>
                                                                                    </td>
                                                                                    <?php
                                                                                        }   
                                                                                    ?>

                                                                                    <div class="form-group">
                                                                                        <?php 
                                                                                            for($t=1;$t<=$classlr;$t++){
                                                                                                echo"<tr><td width=40 align='center'>";
                                                                                                echo '第'.$t.'排';
                                                                                                for($g=1;$g<=$classwr;$g++){
                                                                                        ?>

                                                                                        <td width="85" height="60" align='center' valign="middle">
                                                                                            <?php
                                                                                                $match = ''.$t.''.$g.'';
                                                                                                $sql = mysqli_query($link, "select seat from rollcall where course_code = '$course_coder' && date_time = '$date_timer' && seat LIKE '%".$match."%'"); 
                                                                                                $row=mysqli_fetch_assoc($sql);
                                                                                                $e=explode(" ",@$row["seat"]);
                                                                                                //$row1=mysqli_fetch_assoc($sql1);               
                                                                                                if(in_array($match,$e)){
                                                                                                    $idname = "select * from rollcall where course_code = '$course_coder' && date_time = '$date_timer' && seat LIKE '%".$match."%'"; 
                                                                                                    $idname_rs = mysqli_query($link, $idname);
                                                                                                    while($row = mysqli_fetch_array($idname_rs)){
                                                                                            ?>
                                                                                            <button type="button" style="width:85px; height:60px; border:blue none;background-color:#E6E6FA;" data-toggle="modal" data-target="#exampleModal_<?php echo $row['account']?>">
                                                                                                <?php 
                                                                                                    echo $row['account'];
                                                                                                    $usernames = mysqli_query($link, "SELECT username FROM users where account = '".$row['account']."'");
                                                                                                    $usernamesc = mysqli_fetch_array($usernames);
                                                                                                    $username = @$usernamesc[0];
                                                                                                    echo $username;
                                                                                                ?>
                                                                                            </button>

                                                                                            <div class="modal fade" id="exampleModal_<?php echo $row['account']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <center>
                                                                                                                <h3 class="modal-title" id="exampleModalLabel"><?php echo $row['account']?>&nbsp;&nbsp;<?php echo $username?></h3>
                                                                                                            </center>

                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <center>
                                                                                                                <?php 
                                                                                                                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['imageData'] ).'" height="300"/>';
                                                                                                                ?>
                                                                                                            </center>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <?php       
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }       
                                                                                        ?>
                                                                                    </div>
                                                                                </tr>
                                                                            </table>
                                                                            <p></p>
                                                                            <?php
                                                                                }
                                                                                else{
                                                                            ?>

                                                                            課程名稱:&nbsp;<?php echo $icourse_namer ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            教室:&nbsp;<?php echo $iclassr ?>&nbsp;&nbsp; <br>
                                                                            開放點名時間:&nbsp;<?php echo $idate_timer ?>&nbsp;&nbsp; <br>
                                                                            點名結束時間:&nbsp;<?php echo $itimer ?>&nbsp;&nbsp; <br>
                                                                            應到人數:&nbsp;<?php echo $inum ?>&nbsp;&nbsp;&nbsp;
                                                                            實到人數:&nbsp;<?php echo $icomenum ?>&nbsp;&nbsp;
                                                                            <a href="#edit<?php echo $id;?>" data-toggle="modal">
                                                                                <button type='button' style="background-color: transparent; border:0; color:#4169E1;"> 缺席名單</button>
                                                                            </a>

                                                                            <center>
                                                                                <div id="edit<?php echo $id;?>" class="modal fade" role="dialog">
                                                                                    <form method="post" class="form-horizontal" role="form">
                                                                                        <div class="modal-dialog">
                                                                                            <!-- Modal content-->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                    <h3><span class='glyphicon glyphicon-remove' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;缺席名單</span></span></h3>
                                                                                                    <?php echo $icourse_namer ?> (<?php echo $itimer ?>)
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <table width="100%">
                                                                                                        <thead>
                                                                                                            <tr height="35px">
                                                                                                                <th width="auto">&nbsp;項次</th>
                                                                                                                <th width="auto">&nbsp;&nbsp;學號</th>
                                                                                                                <th width="auto">&nbsp;&nbsp;姓名</th>
                                                                                                                <th width="auto">&nbsp;系級</th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody id="tableId">
                                                                                                            <?php
                                                                                    
                                                                                                                $iscourse_code = mysqli_query($link, "SELECT stucourse.* FROM stucourse WHERE stucourse.course_code='$icourse_coder' && stucourse.stu_id NOT IN (SELECT rollcall.account FROM rollcall where rollcall.date_time='$idate_timer')");
                                                                                                                for($i=1;$i<=mysqli_num_rows($iscourse_code);$i++){
                                                                                                                    $row=mysqli_fetch_row($iscourse_code);
                                                                                                            ?>
                                                                                                            <tr height="40px">
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php echo $i;?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php echo $row['3'];?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php  
                                                                                                                        $usernames = mysqli_query($link, "SELECT username FROM users where account = '".$row['3']."'");
                                                                                                                        $usernamec = mysqli_fetch_array($usernames);
                                                                                                                        $username = @$usernamec[0];
                                                                                                                        echo $username;
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    &nbsp;
                                                                                                                    <?php  
                                                                                                                        $departments = mysqli_query($link, "SELECT department FROM users where account = '".$row['3']."'");
                                                                                                                        $departmentc = mysqli_fetch_array($departments);
                                                                                                                        $department = @$departmentc[0];
                                                                                                                        echo $department;
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <?php  
                                                                                                        }
                                                                                                    ?>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </center>

                                                                            <table border=1 height="500" style="text-align:center;">
                                                                                <tr>
                                                                                    <td width="50" height="10" align='center' valign="middle"></td>
                                                                                    <?php
                                                                                        for($c=1;$c<=$iclasswr;$c++){
                                                                                    ?>
                                                                                    <td width="55" height="10" align='center' valign="middle">
                                                                                        <?php echo $c;?>
                                                                                    </td>
                                                                                    <?php
                                                                                        }   
                                                                                    ?>

                                                                                    <div class="form-group">
                                                                                        <?php 
                                                                                            for($t=1;$t<=$iclasslr;$t++){
                                                                                                echo"<tr><td width=40 align='center'>";
                                                                                                echo '第'.$t.'排';
                                                                                                for($g=1;$g<=$iclasswr;$g++){
                                                                                        ?>
                                                                                        <td width="85" height="60" align='center' valign="middle">
                                                                                            <?php
                                                                                                $match = ''.$t.''.$g.'';
                                                                                                $sql = mysqli_query($link, "select seat from rollcall where course_code = '$icourse_coder' && date_time = '$idate_timer' && seat LIKE '%".$match."%'"); 
                                                                                                $row=mysqli_fetch_assoc($sql);
                                                                                                $e=explode(" ",@$row["seat"]);
                                                                                                //$row1=mysqli_fetch_assoc($sql1);               
                                                                                            ?>
                                                                                            <?php 
                                                                                                if(in_array($match,$e)){
                                                                                                    $idname = "select * from rollcall where course_code = '$icourse_coder' && date_time = '$idate_timer' && seat LIKE '%".$match."%'"; 
                                                                                                    $idname_rs = mysqli_query($link, $idname);        
                                                                                                    while($row = mysqli_fetch_array($idname_rs)){
                                                                                                ?>
                                                                                            <button type="button" style="width:85px; height:60px; border:blue none; background-color:#E6E6FA;" data-toggle="modal" data-target="#exampleModal_<?php echo $row['account']?>">
                                                                                                <?php 
                                                                                                    echo $row['account'];
                                                                                                    $usernames = mysqli_query($link, "SELECT username FROM users where account = '".$row['account']."'");
                                                                                                    $usernamesc = mysqli_fetch_array($usernames);
                                                                                                    $username = @$usernamesc[0];
                                                                                                    echo $username;
                                                                                                ?>
                                                                                            </button>
                                                                                            <div class="modal fade" id="exampleModal_<?php echo $row['account']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <center>
                                                                                                                <h3 class="modal-title" id="exampleModalLabel"><?php echo $row['account']?>&nbsp;&nbsp;<?php echo $username?></h3>
                                                                                                            </center>

                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <center>
                                                                                                                <?php 
                                                                                                                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['imageData'] ).'" height="300"/>';
                                                                                                                ?>
                                                                                                            </center>

                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <?php       
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }       
                                                                                        ?>
                                                                                    </div>
                                                                                </tr>
                                                                            </table>
                                                                            <p></p>
                                                                            <?php
                                                                                    }
                                                                                ?>
                                                                        </div>
                                                                    </td>
                                                                </center>
                                                                <div id='div_session_write'> </div>
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

        $('#myModal').on('shown.bs.modal', function() {
            $('#myInput').trigger('focus')
        });

        $(document).ready(function() {
            $('.DeleteRecord').on("click", function(e) {
                e.preventDefault();
                //perform the url load  then
                $(this).closest('td').find('#myModal').modal({
                    keyboard: true
                }, 'show');
                return false;
            });
        });

    </script>
</body>

</html>
