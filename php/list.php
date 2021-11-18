<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include ("config.php");
$account = $_SESSION['account'];
$username = $_SESSION["username"];

$list = $_GET['list'];
echo $list;
$course_name = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$list'");
$course_namer = mysqli_fetch_array($course_name);
$course_nameg = @$course_namer[0];

$courselistid = mysqli_query($link, "SELECT id FROM stucourse where course_code = '$list'");
//$courselistname = mysqli_query($link, "SELECT username FROM stucourse where course_name = '$list'");

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $courseid = $_POST['courbtn'];
    session_start();     
    $_SESSION["account"] = $account; 
    $_SESSION["username"] = $username;
    $_SESSION["courset"] = $courseid;  
    header("location: rollcall_s.php");    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>教室點名系統-我的課程</title>
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
                                    <div id="xbox2-inline" class="clearfix">
                                        <div class='module app-dashboard app-dashboard-show '>
                                            <div class="fs-block " style=''>
                                                <div class="fs-block-header  clearfix">
                                                    <div class="block-title">
                                                        <div style="border-width: 5px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                            <span style="color:#FFFFFF;">課程名單</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class="container con">
                                                            <div class="main">
                                                                <div style='margin-top:10px; margin-bottom:20px; margin-left:10px; margin-right:10px;'>
                                                                    <h2><?php echo $course_nameg?></h2>
                                                                    <h4>課程代碼: <?php echo $list?></h4>
                                                                    <p></p>
                                                                    <table width="100%">
                                                                        <tr height="35px">
                                                                            <th>&nbsp;&nbsp;項次</th>
                                                                            <th>&nbsp;&nbsp;學號</th>
                                                                            <th>&nbsp;&nbsp;姓名</th>
                                                                            <th>&nbsp;&nbsp;系級</th>
                                                                            <th>&nbsp;&nbsp;缺席次數</th>

                                                                        </tr>
                                                                        <?php 
                                                                            $stulist = mysqli_query($link, "SELECT * FROM stucourse where course_code = '$list'");  
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

                                                                        <tr height="35px">
                                                                            <td>
                                                                                &nbsp;&nbsp;<?php echo $i?>
                                                                            </td>

                                                                            <td>
                                                                                &nbsp;&nbsp;<?php echo $row['3']?>
                                                                            </td>

                                                                            <td>
                                                                                &nbsp;&nbsp;<?php echo $stuidg?>
                                                                            </td>

                                                                            <td>
                                                                                &nbsp;&nbsp;<?php echo $studepg?>
                                                                            </td>

                                                                            <td>
                                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <?php
                                                                                    $itime = mysqli_query($link, "SELECT * FROM history where course_code = '$list'");
                                                                                    $itimec = mysqli_num_rows($itime);
                                                                                    //echo $itimec;
                                                                                    
                                                                                    $otime = mysqli_query($link, "SELECT * FROM opcourse where course_code = '$list'");
                                                                                    $otimec = mysqli_num_rows($otime);
                                                                                    //echo $itimec;
                                                                                        
                                                                                    $stutime = mysqli_query($link, "SELECT * FROM rollcall where course_code = '$list' and account = '$stuid'");
                                                                                    $stutimec = mysqli_num_rows($stutime);
                                                                                    //echo $stutimec;
                                                                                        
                                                                                    echo $otimec+$itimec-$stutimec;
                                                                                        
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
</body>

</html>
