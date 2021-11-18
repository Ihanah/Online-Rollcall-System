<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include ("config.php");
$account = $_SESSION["account"];
$username = $_SESSION["username"];
$courseid = $_SESSION["coursename"];

$cn = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$courseid'");
$course_name = mysqli_fetch_row($cn);

$class = mysqli_query($link, "SELECT all_class FROM class"); 

// Define variables and initialize with empty values
$coursec = $classc = $pronamec = $courcodec = $clockc = "";
$courseget = $classget = $pronameget = $courcodeget = $clockget = "";
$date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
$result = mysqli_query($link, "SELECT * FROM opcourse where professor = '$account'");
$hisdlc = mysqli_query($link, "SELECT time FROM opcourse where professor = '$account'");

@$del = $_GET['del'];
$del = mysqli_query($link, "DELETE FROM opcourse where id = '$del'");

@$hdel = $_GET['hdel'];
$hdel = mysqli_query($link, "DELETE FROM opcourse where id = '$hdel'");

while($row1 = mysqli_fetch_array($result)){
    $rs=mysqli_fetch_row($hisdlc);
    $date1 = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
    $date2 = @$rs[0]; 
    $delcourse = @rt[0];
    $delcourse = $row1['course_code'];
    $deltime = $row1['time'];
    //echo $date2;
    //echo $date2;
    if((strtotime($date1)-strtotime($date2))<0) {
        //echo "&nbsp;&nbsp;開放中";
    } else {
        $his = mysqli_query($link, "INSERT INTO user.history select * from user opcourse where course_code = '$delcourse' && time = '$deltime'");
        $del = mysqli_query($link, "DELETE FROM opcourse where course_code = '$delcourse' && time = '$deltime'");
    } 
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //$coursec = $_POST["coursec"];
    $classc = $_POST["classc"];    
    $clockc = $_POST["clockc"];
    $date2= $_POST["clockc"];
    $pronamec = $_SESSION['account'];   
    $sql = "INSERT INTO opcourse (professor, course_code, class, time) VALUES (?, ?, ?, ?)";
    //echo $coursec;
    if($stmt = mysqli_prepare($link, $sql)){
        $check_sql = "SELECT * FROM opcourse WHERE course_code = '$courseid' " ;
            $check_rs = mysqli_query($link, $check_sql);
            $check = mysqli_fetch_array($check_rs);
                               
            if($check == 0){   
                if($classc=="請選擇" || $clockc==" "){
                    echo "<script> alert('請確認是否完整填寫');</script>";
                }else {
                
                    //echo $date1;echo $date2;
                    if(($second = strtotime($date1)-strtotime($date2))>0){
                        echo "<script> alert('截止時間有誤!');</script>";
                    
                    }else{
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssss", $profeget, $courcodeget, $classget, $clockget);
                        $classget = $classc;
                        $profeget = $pronamec;
                        $courcodeget = $courseid;
                        $clockget = $clockc;
                        echo "<script> alert('點名單已開啟!);</script>";
                        //header("location: welcome_s.php");*/
            
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                         
                            // Store data in session variables
                            $_SESSION["account"] = $account; 
                            $_SESSION["username"] = $username;
                            $_SESSION["courset"] = $courseget;
                            // Redirect to login page
                            echo "<SCRIPT> //not showing me this
                                    alert('點名單已開啟!')
                                    window.location.replace('welcome_t.php');
                            </SCRIPT>";
                            //header("location: welcome_t.php");
                        } else{
                            echo "Something went wrong. Please try again later.";
                        }                            
                    }   
                } 
            }else{
                echo "<script> alert('本課程已開放點名中!');</script>";
            }  
        // Close statement
        mysqli_stmt_close($stmt);
    }   
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>課程點名-<?php echo ''.$course_name[0].'('.$courseid.')' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap library -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.min.js"></script>
    <link href="bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="bootstrap-datetimepicker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
            height: 180px;
        }

        .table {
            /*            width: 800px;*/
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
                                                            <span style="color:#FFFFFF;">課程點名</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body">
                                                        <div class="container con">
                                                            <script type="text/javascript">
                                                                function a(s) {
                                                                    var value = document.getElementById(x).value;
                                                                    alert(value);
                                                                }

                                                            </script>
                                                            <div style=' margin-bottom:20px; margin-left:10px;'>
                                                                <table class="table table-hover">
                                                                    <tr>
                                                                        <th scope="col">課程</th>
                                                                        <th scope="col">教室</th>
                                                                        <th scope="col">點名截止時間</th>
                                                                    </tr>

                                                                    <td>
                                                                        <input type="text" class="form-control" name="coursec" value="<?php echo $course_name[0]?>" disabled>
                                                                        <!--
                                                                        <select id = "coursecid" name="coursec" onchange="a(this.id)" >
                                                                        <option value="請選擇">請選擇</option> 
                                                                        <?php while ($row = mysqli_fetch_row($course)):?> 
                                                                        <option value="<?php echo $cid[0]?>"><?php echo $cid[0]?></option> 
                                                                        <?php endwhile?> 	         
	                                                                   </select>
                                                                        -->
                                                                    </td>

                                                                    <td>
                                                                        <select class="form-control" name="classc">
                                                                            <option value="請選擇">請選擇</option>
                                                                            <?php while ($row = mysqli_fetch_row($class)):?>
                                                                            <option value="<?php echo $row[0]?>"><?php echo $row[0]?></option>
                                                                            <?php endwhile?>
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <div class="input-group date" id='datetimepicker'>
                                                                            <input type="text" class="form-control" id="datetime" name="clockc" value=" " required>
                                                                            <span class="input-group-addon">
                                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </table>
                                                                <div class="form-group">
                                                                    <center>
                                                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-th"></span> 開放點名</button>
                                                                    </center>
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

    <script src="datetimepicker.js"></script>
    <script>
        $("#datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });

    </script>

</body>

</html>
