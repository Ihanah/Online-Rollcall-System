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
$courseid = $_SESSION["courseid"];
$professor = $_SESSION["professor"];
$class = $_SESSION["class"];
$date_time = $_SESSION["date_time"];
$cid = $_SESSION["cid"];
echo $cid;

$check_sql = "SELECT * FROM rollcall WHERE course_code = '$courseid' and account = '$account' and date_time = '$date_time'" ;
$check_rs = mysqli_query($link, $check_sql);
$check = mysqli_fetch_array($check_rs);
                                       
if($check != 0){ 
     echo "<script> alert('已完成點名!'); location.href = 'rollcall_s.php';</script>";
}

$cn = mysqli_query($link, "SELECT course_name FROM professor where course_code = '$courseid'");
$course_name = mysqli_fetch_row($cn);

// Define variables and initialize with empty values
$accountc = $usernamec = $coursec = $courseidc = $professorc = $classc = $rollcallc = "";
$accountget = $usernameget = $courseget = $courseidget = $profget = $classget = $seatget = $date_timeget = "";

$classw = mysqli_query($link, "SELECT width FROM class where all_class = '$class'");
$classwc = mysqli_fetch_array($classw);
$classwr = @$classwc[0];
//echo $classwr;
$classl = mysqli_query($link, "SELECT length FROM class where all_class = '$class'");
$classlc = mysqli_fetch_array($classl);
$classlr = @$classlc[0];
//echo $classlr;

//echo $date1;
@$del = $_GET['del'];
echo $del;
$delt = mysqli_query($link, "DELETE FROM rollcall where id = '$del'");

$msg = "";
// Processing form data when form is submitted

if (isset($_POST['seatbtn'])) {
       
    $rollcallc = $_POST['seatbtn'];
    $accountc = $_SESSION['account'];
    $usernamec = $_SESSION["username"];
    $professorc = $_SESSION['professor'];
    $courseidc = $_SESSION['courseid'];
    $coursec = $course_name[0];
    $classc = $_SESSION['class'];
    $date_time = $_SESSION["date_time"];
    $cid = $_SESSION["cid"];
    
   if(count($_FILES) > 0) {
       if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
          
           $imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
           $imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
           $sql = "INSERT INTO rollcall(account, course_code, seat, date_time, imageData, course_id)VALUES('$accountc', '$courseidc', '$rollcallc', '$date_time', '{$imgData}', '$cid')";
           $current_id = mysqli_query($link, $sql);
           if(isset($current_id)) {
               echo "<SCRIPT> //not showing me this
                    alert('已完成點名!')
                    window.location.replace('rollcall_s.php');
                    </SCRIPT>";
           }
       }
       else {
            echo "<SCRIPT> //not showing me this
            alert('請選擇檔案!')
            window.location.replace('seat_s.php');
            </SCRIPT>";
        }
   }
}
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>

    <title>座位點名-<?php echo ''.$course_name[0].'('.$courseid.')'?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel=stylesheet type="text/css" href="my_css1.css">
</head>


<body background="background1.jpg">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
<!--                                                <h1><span class="glyphicon glyphicon-user"></span> <span style="font-family: 'Microsoft JhengHei';">粉絲團 (2)</span></h1>-->
                                                <li l class='  '>
                                                    <a href='welcome_s.php'><span class='glyphicon glyphicon-book' aria-hidden='true'>
                                                        <span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;我的課程</span></span></a>
                                                </li>
                                                <li l class='  '>
                                                    <a href='history_s.php'><span class='glyphicon glyphicon-list' aria-hidden='true'>
                                                        <span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;點名紀錄</span></span></a>
                                                </li>
                                                <li l class='  '>
                                                    <a href='search_s.php'><span class='glyphicon glyphicon-search' aria-hidden='true'>
                                                        <span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;快速查詢</span></span></a>
                                                </li>
                                                <li l class='  '>
                                                    <a href='over_s.php'><span class='glyphicon glyphicon-file' aria-hidden='true'>
                                                        <span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;歷年課程</span></span></a>
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
                                                            <span style="color:#FFFFFF;">座位表</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class='fs-thumblist'>
                                                            <center>
                                                                <div style='margin-left:10px; margin-top:20px; margin-bottom:20px;'>
                                                                    <div class="main">
                                                                        <form name="frmImage" enctype="multipart/form-data" method="post" class="frmImageUpload">
                                                                            <input name="userImage" type="file" class="inputFile" onchange="openFile(event)" /><p></p>
                                                                            <script language="javascript">
                                                                                function openFile(event) {
                                                                                    var input = event.target; //取得上傳檔案
                                                                                    var reader = new FileReader(); //建立FileReader物件

                                                                                    reader.readAsDataURL(input.files[0]); //以.readAsDataURL將上傳檔案轉換為base64字串

                                                                                    reader.onload = function() { //FileReader取得上傳檔案後執行以下內容
                                                                                        var dataURL = reader.result; //設定變數dataURL為上傳圖檔的base64字串
                                                                                        $('#output').attr('src', dataURL).show(); //將img的src設定為dataURL並顯示
                                                                                    };
                                                                                }

                                                                            </script>
                                                                            
                                                                            <center><img id="output" height="150" style="display:none"></center>
                                                                            
                                                                            <div class="wrapper">
                                                                                <center>
                                                                                    <table border=1>
                                                                                        <tr>
                                                                                            <td width="8" height="10" align='center' valign="middle"></td>
                                                                                            <?php
                                                                                            for($c=1;$c<=$classwr;$c++){
                                                                                        ?>
                                                                                            <td width="8" height="10" align='center' valign="middle">
                                                                                                <?php echo $c;?>
                                                                                            </td>
                                                                                            <?php
                                                                                                }   
                                                                                            ?>

                                                                                            <div class="form-group">
                                                                                            <?php 
                                                                                                for($t=1;$t<=$classlr;$t++){
                                                                                                    echo"<tr><td width=65 align='center'>";
                                                                                                    echo '第'.$t.'排';
                                                                                                    for($g=1;$g<=$classwr;$g++){
                                                                                            ?>
                                                                                                <td width="80" align='center' valign="middle">
                                                                                                    <?php
                                                                                                    $match = ''.$t.''.$g.'';
                                                                                                    $sql = mysqli_query($link, "select seat from rollcall where course_code = '".$_SESSION["courseid"]."' && date_time = '$date_time' && seat LIKE '%".$match."%'"); 
                                                                                                    $row=mysqli_fetch_assoc($sql);
                                                                                                    $e=explode(" ",@$row["seat"]);
                                                                                                    //$row1=mysqli_fetch_assoc($sql1);               
                                                                                            ?>
                                                                                                    <?php 
                                                                                                    if(in_array($match,$e)){
                                                                                                        $idname = "select * from rollcall where course_code = '".$_SESSION["courseid"]."' && date_time = '$date_time' && seat LIKE '%".$match."%'"; 
                                                                                                        $idname_rs = mysqli_query($link, $idname);
                                                                                                        while($row = mysqli_fetch_array($idname_rs)){
                                                                                                            echo $row['account'];
                                                                                                            $usernames = mysqli_query($link, "SELECT username FROM users where account = '".$row['account']."'");
                                                                                                            $usernamesc = mysqli_fetch_array($usernames);
                                                                                                            $username = @$usernamesc[0];
                                                                                                            echo $username;
                                                                                                        }
                                                                                                    }else{
                                                                                            ?>
                                                                                                    <input type="submit" name="seatbtn" style="width:80px; height:50px; border:2px blue none; background-color:#d8e6ef;" value="<?php echo $t?><?php echo $g?>">
                                                                                                </td>
                                                                                                <?php              
                                                                                                    }
                                                                                                }
                                                                                            }       
                                                                                        ?>
                                                                                            </div>
                                                                                        </tr>
                                                                                    </table>
                                                                                </center>
                                                                                <p></p>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
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
