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
@$del = $_GET['del'];
echo $del;
$delt = mysqli_query($link, "DELETE FROM rollcall where id = '$del'");

if($_SERVER["REQUEST_METHOD"] == "POST"){
      
    // Prepare a select statement
    $sql = "SELECT course_code, professor, class, date_time, id FROM opcourse WHERE course_code = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_coursecode);
            
        // Set parameters
        $param_coursecode = $courseid;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            @mysqli_stmt_store_result($stmt);
            /* store result */         
            if(($second = strtotime($date1)-strtotime($date2))<0) { 
                
                 if(mysqli_stmt_num_rows($stmt) == 1){
                    
                     $check_sql = "SELECT * FROM rollcall WHERE course_code = '$courseid' and account = '$account' and date_time = '$date3'" ;
                     $check_rs = mysqli_query($link, $check_sql);
                     $check = mysqli_fetch_array($check_rs);
                                       
                     if($check == 0){ 
                         mysqli_stmt_bind_result($stmt, $course_code, $professor, $class, $date_time, $id);
                
                        if(mysqli_stmt_fetch($stmt)){
                    
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["account"] = $account; 
                            $_SESSION["username"] = $username;
                            $_SESSION["professor"] = $professor;
                            $_SESSION["courseid"] = $courseid;
                            $_SESSION["class"] = $class;
                            $_SESSION["date_time"] = $date_time;
                            $_SESSION["cid"] = $id;
                            header("location: seat_s.php");
                        }  
                         
                     }else{
                         echo "<script> alert('已完成點名!'); location.href = 'rollcall_s.php';</script>";
                        
                    } 
                }else{
                    // Display an error message if account doesn't exist
                    echo "<script> alert('本課程尚無開放點名'); location.href = 'rollcall_s.php';</script>";
                }
            }
            else{
//                 Display an error message if account doesn't exist
                echo "<script> alert('本課程尚無開放點名'); location.href = 'rollcall_s.php';</script>";
            }
        }
         else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
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
                                            <div class="fs-block " style=''>
                                                <div class="fs-block-header  clearfix">
                                                    <div class="block-title">
                                                        <div style="border-width: 5px; height: 35px; padding: 7px; text-align: center; background-color:#7badcb; font-size: 15.5px">
                                                            <span style="color:#FFFFFF;">我的課程</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class='fs-thumblist'>
                                                            <div style='margin-left:30px;margin-bottom:20px;'>
                                                                <div class="main">
                                                                    <h3><?php echo ''.$course_name[0].''?></h3>
                                                                    課程代碼: <?php echo $courseid;?>
                                                                    <span class="help-block"><?php echo $coursename_err; ?></span>
                                                                    <input type="submit" class="btn btn-primary" name="rollcall" value="線上點名">
                                                                    <P></P>
                                                                    <td align="center">
                                                                        <?php echo '<input type="button" name="id" class="btn btn-primary" value="點名紀錄" onclick=location.href="historyc_s.php?cn=' . $courseid . '">'?>
                                                                    </td>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384- wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
