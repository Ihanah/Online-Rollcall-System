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
$courseid = $_SESSION['courset'];

$cn = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$courseid'");
$course_name = mysqli_fetch_row($cn);

$hisdtc = mysqli_query($link, "SELECT date_time FROM opcourse where course_code = '$courseid'");
$rt = mysqli_fetch_row($hisdtc);

$hisdlc = mysqli_query($link, "SELECT time FROM opcourse where course_code = '$courseid'");
$rs = mysqli_fetch_row($hisdlc);

$date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
$date2 = @$rs[0];
$date3 = @$rt[0];

//echo $date1;


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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
    <link rel=stylesheet type="text/css" href="my_css1.css">

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
                                                <div class="fs-block-header  clearfix">
                                                    <div class="block-title">
                                                        <div style="border-width: 5px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                            <span style="color:#FFFFFF;">課程</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div style='margin-left:30px;margin-bottom:20px;'>
                                                            <div class="container con">
                                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                                    <h2><?php echo ''.$course_name[0].'('.$courseid.')'?></h2>
                                                                    <p></p>
                                                                    <span class="help-block"><?php echo $coursename_err; ?></span>
                                                                    <input type="submit" class="btn btn-primary" name="rollcall" value="線上點名">
                                                                </form>
                                                                <?php echo '<input type="button" name="id" class="btn btn-primary" value="點名紀錄" onclick=location.href="myscourse.php?cid=' . $courseid . '">'?>
                                                                <?php echo '<input type="button" name="id" class="btn btn-primary" value="課程名單" onclick=location.href="list.php?list=' . $courseid . '">'?>
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
