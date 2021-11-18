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

$Year= date("Y");
$Month= date("m");
//$year = $getYear-1911;
//echo $year;
//echo $Month;

if($Month >= 2 && $Month <= 7){
    $yearget = $Year-1912;
    $sem = 2;
}
else if($Month == 1){
    $yearget = $Year-1912;
    $sem = 1;
}
else{
    $yearget = $Year-1911;
    $sem = 1;
}


$getyear = @$_POST['year'];
$getsem = @$_POST['sem'];

$over = mysqli_query($link, "SELECT * FROM professor where account = '$account' && year = '$getyear' & semester = '$getsem'");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start(); 
    $_SESSION["account"] = $account; 
    $_SESSION["username"] = $username;
    $_SESSION["courset"] = $_POST["courbtn"];
    header("location: rollcall_t.php");

    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>線上點名系統-快速查詢</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel=stylesheet type="text/css" href="my_css.css">
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
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
                                                            <span style="color:#FFFFFF;">歷年課程</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class="container con">
                                                            <div style='margin-left:30px;margin-top:20px;margin-bottom:20px;'>
                                                                <script type="text/javascript">
                                                                    function a(s) {
                                                                        var value = document.getElementById(x).value;
                                                                        alert(value);
                                                                    }

                                                                </script>

                                                                <!--
                                                            <select name="year" id="year">
                                                                <?php
                                                                    for($i=107; $i <= $yearget; $i++){
                                                                        echo '<option value="' ,$i ,'">', $i, '</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                            學年度第
                                                            <select name="sem" id="sem">
                                                                <?php
                                                                    for($i=1; $i <= 2; $i++){
                                                                        echo '<option value="' ,$i ,'">', $i, '</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                            學期
                                                            <input type="submit" name="searchbtn" value="查詢">
-->
                                                                <form>

                                                                    <table>
                                                                        <tr height="30px">
                                                                            <th height="30px" width="80">&nbsp;&nbsp;學年</th>
                                                                            <th height="30px" width="80">&nbsp;&nbsp;學期</th>
                                                                            <th height="30px" width="180">&nbsp;&nbsp;課程代碼</th>
                                                                            <th height="30px" width="180">&nbsp;&nbsp;課程名稱</th>
                                                                            <th height="30px" width="180">&nbsp;&nbsp;班級</th>
                                                                        </tr>

                                                                        <?php
                                                                                for($i=1;$i<=mysqli_num_rows($over);$i++){
                                                                                    $row=mysqli_fetch_row($over);
                                                                            ?>
                                                                        <tr>
                                                                            <td height="30px" width="80" name="course_code" value='$course_name'>
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['1'];?>
                                                                            </td>
                                                                            <td height="30px" width="80" name="course_code" value='$course_name'>
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['2'];?>
                                                                            </td>
                                                                            <td height="30px" width="180" name="course_code" value='$course_name'>
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['4'];?>
                                                                            </td>

                                                                            <td height="30px" width="60" name="course_name" value='$class'>
                                                                                &nbsp;
                                                                                <button name="courbtn" type="submit" style="background-color: transparent; border:0; color:#4169E1;" value="<?php echo $row['4']?>"><?php echo $row['3']?></button>
                                                                                <!--                                                                                <?php echo $row['3'];?>-->
                                                                            </td>

                                                                            <td height="30px" width="180" name="grade">
                                                                                &nbsp;&nbsp;
                                                                                <?php echo $row['5']; ?>
                                                                            </td>


                                                                            <?php  }?>
                                                                        </tr>
                                                                    </table>
                                                                </form>
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
