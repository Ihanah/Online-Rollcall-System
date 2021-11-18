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
$courseid = @$_SESSION["courseid"];
    
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

$del = @$_GET['del'];
echo $del;


$del = mysqli_query($link, "DELETE FROM professor where id = '$del'");
 
$scourse = mysqli_query($link, "SELECT course_name FROM professor where account = '$account' && year = '$yearget' && semester = '$sem'");
$scourse_code = mysqli_query($link, "SELECT course_code FROM professor where account = '$account' && year = '$yearget' && semester = '$sem'");
$grade = mysqli_query($link, "SELECT grade FROM professor where account = '$account' && year = '$yearget' && semester = '$sem'");
//$courseid = @$_POST["searchbtn"];
    

if(isset($_POST["searchbtn"])){
    if($_POST["searchbtn"]=="查詢"){
        $_SESSION["courseid"] = $_POST["getid"];
        header("location: manage_t.php");
    }
    else {
        $_SESSION["courseid"] = $_POST["searchbtn"];
        header("location: rollcall_r.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>教室點名系統-我的課程</title>
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
    <script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
    <script src='script.js' type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            width: 900px;
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
            list-style: none;
        }

        .modal-li li {
            height: 45px;
            line-height: 45px;
        }

        .text-input {
            display: inline-block;
            width: 80%;
            margin-left: 10px;
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
                    $("#menu").load("menu_r.html");

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
                                                            <span style="color:#FFFFFF;">課程管理</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class="container con">
                                                            <div class="main">
                                                                <div style='margin-top:10px; margin-bottom:20px; margin-left:10px; margin-right:10px;'>
                                                                    <label for="fname">課程代碼:</label>
                                                                    <input type="text" id="fname" name="getid">
                                                                    <input type="submit" name="searchbtn" value="查詢">
                                                                    <p></p>
                                                                    <table id="example" class="display nowrap" cellspacing="0" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="auto">&nbsp;&nbsp;項次</th>
                                                                                <th width="auto">&nbsp;&nbsp;學年</th>
                                                                                <th width="auto">&nbsp;學期</th>
                                                                                <th width="auto">&nbsp;課程名稱</th>
                                                                                <th width="auto">&nbsp;課程代碼</th>
                                                                                <!--<th height="30px" width="200">&nbsp;&nbsp;密碼</th>-->
                                                                                <th width="auto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;班級</th>
                                                                                <th width="auto">&nbsp;&nbsp;開課教師</th>
                                                                                <th width="auto">&nbsp;&nbsp;編輯</th>
                                                                            </tr>
                                                                        </thead>


                                                                        <tbody>
                                                                            <?php
                                                                                $sql = "SELECT * FROM professor where course_code = '$courseid'";
                                                                                $result = $link->query($sql);
                                                                                if ($result->num_rows > 0) {
                                                                                // output data of each row
                                                                                    while($row = $result->fetch_assoc()) {
                                                                                        $id = $row['id'];
                                                                                        $year = $row['year'];
                                                                                        $sem = $row['semester'];
                                                                                        $name = $row['course_name'];
                                                                                        $code = $row['course_code'];
                                                                                        $grade = $row['grade'];
                                                                                        $pro = $row['account'];
                                                                                        @$i+=1;
                                                                                        //echo $id;  
                                                                            ?>
                                                                            <tr height="30px">
                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $i;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;
                                                                                    <?php echo $year;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $sem;?>
                                                                                </td>

                                                                                <td>
                                                                                    <button name="searchbtn" type="submit" style="background-color: transparent; border:0; color:#327196;" value="<?php echo $code?>"><?php echo $name?></button>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $code;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $grade;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php
                                                                                        $pro_name = $pro;
                                                                                        $proname = mysqli_query($link, "SELECT username FROM users where account = '$pro_name'");
                                                                                        $pronamer = mysqli_fetch_array($proname);
                                                                                        $pronameg = @$pronamer[0];
                                                                                        echo $pronameg;
                                                                                    ?>
                                                                                </td>

                                                                                <td>
                                                                                    <a href="#edit<?php echo $id;?>" data-toggle="modal">
                                                                                        <button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> 編輯</button>
                                                                                    </a>
                                                                                </td>
                                                                                <div id="edit<?php echo $id;?>" class="modal fade" role="dialog">
                                                                                    <form method="post" class="form-horizontal" role="form">
                                                                                        <div class="modal-dialog">
                                                                                            <!-- Modal content-->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                    <h3><span class='glyphicon glyphicon-book' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;課程資訊</span></span></h3>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <center>
                                                                                                        <input type="hidden" name="edit_id" value="<?php echo $id?>" placeholder="ID" required>
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;學年:
                                                                                                        <input type="text" name="edit_year" value="<?php echo $year?>" placeholder="學年" required>
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;學期:
                                                                                                        <input type="text" name="edit_sem" value="<?php echo $sem?>" placeholder="學期" required><br>
                                                                                                        課程名稱: <input type="text" name="edit_name" value="<?php echo $name?>" placeholder="課程名稱" required>
                                                                                                        課程代碼: <input type="text" name="edit_code" value="<?php echo $code?>" placeholder="課程代碼" required><br>
                                                                                                        開課班級: <input type="text" name="edit_grade" value="<?php echo $grade?>" placeholder="開課班級" required>
                                                                                                        開課教師: <input type="text" name="edit_pro" value="<?php echo $pro?>" placeholder="開課教師" required>
                                                                                                    </center>
                                                                                                </div>
                                                                                                <div class="modal-footer">

                                                                                                    <button type="button" name="hdel" class="btn btn-danger" onclick="delForm('<?php echo $id?>')">
                                                                                                        <span class="glyphicon glyphicon-trash"></span>刪除</button>

                                                                                                    <button type="submit" class="btn btn-primary" name="update_item"><span class="glyphicon glyphicon-edit"></span>更改</button>

                                                                                                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>取消</button>
                                                                                                </div>
                                                                                                <script language="javascript">
                                                                                                    function delForm(id) {
                                                                                                        if (confirm("確認刪除此課程嗎?")) {
                                                                                                            location.href = "manage_t.php?del=" + id
                                                                                                            alert("課程已刪除!");
                                                                                                        }
                                                                                                    }

                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>

                                                                                <?php  
                                                                                    }   
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                            <?php
                                                                                $sql = "SELECT * FROM professor";
                                                                                $result = $link->query($sql);
                                                                                if ($result->num_rows > 0) {
                                                                                // output data of each row
                                                                                    while($row = $result->fetch_assoc()) {
                                                                                        $id = $row['id'];
                                                                                        $year = $row['year'];
                                                                                        $sem = $row['semester'];
                                                                                        $name = $row['course_name'];
                                                                                        $code = $row['course_code'];
                                                                                        $grade = $row['grade'];
                                                                                        $pro = $row['account'];
                                                                                        @$i+=1;
                                                                                    //echo $id;
                                                                                ?>
                                                                            <tr height="30px">
                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $i;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;
                                                                                    <?php  echo $year;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $sem;?>
                                                                                </td>

                                                                                <td>
                                                                                    <button name="searchbtn" type="submit" style="background-color: transparent; border:0; color:#327196;" value="<?php echo $code;?>"><?php echo $name?></button>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $code;?>
                                                                                </td>

                                                                                <!--
                                                                                <td height="30px" width="200" name="time" value='$time'>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $grade;?>
                                                                                </td>
-->
                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $grade;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php
                                                                                        $pro_name = $pro;
                                                                                        $proname = mysqli_query($link, "SELECT username FROM users where account = '$pro_name'");
                                                                                        $pronamer = mysqli_fetch_array($proname);
                                                                                        $pronameg = @$pronamer[0];
                                                                                        echo $pronameg;
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#edit<?php echo $id;?>" data-toggle="modal">
                                                                                        <button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> 編輯</button>
                                                                                    </a>
                                                                                </td>
                                                                                <center>
                                                                                    <div id="edit<?php echo $id;?>" class="modal fade" role="dialog">
                                                                                        <form method="post" class="form-horizontal" role="form">
                                                                                            <div class="modal-dialog">
                                                                                                <!-- Modal content-->
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                        <h3><span class='glyphicon glyphicon-book' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;課程資訊</span></span></h3>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <center>
                                                                                                            <input type="hidden" name="edit_id" value="<?php echo $id?>" placeholder="ID" required>

                                                                                                            <i class="fa fa-calendar"><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">開課學年:</span></i>
                                                                                                            <input type="text" name="edit_yaer" value="<?php echo $year?>" placeholder="學年" required>

                                                                                                            <i class="fa fa-pencil-square-o"><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">開課學期:</span></i>
                                                                                                            <input type="text" name="edit_sem" value="<?php echo $sem?>" placeholder="學期" required><br>
                                                                                                            <p></p>

                                                                                                            <i class="fa fa-university"><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">課程名稱:</span></i>
                                                                                                            <input type="text" name="edit_name" value="<?php echo $name?>" placeholder="課程名稱" required>

                                                                                                            <i class="fa fa-tasks"><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">課程代碼:</span></i>
                                                                                                            <input type="text" name="edit_code" value="<?php echo $code?>" placeholder="課程代碼" required><br>
                                                                                                            <p></p>


                                                                                                            <i class="fa fa-book"><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;"> 開課班級:&nbsp;</span></i><input type="text" name="edit_grade" value="<?php echo $grade?>" placeholder="開課班級" required>

                                                                                                            <i class="fa fa-graduation-cap"><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">開課教師:&nbsp;</span></i><input type="text" name="edit_pro" value="<?php echo $pro?>" placeholder="開課教師" required>
                                                                                                        </center>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">

                                                                                                        <button type="button" name="hdel" class="btn btn-danger" onclick="delForm('<?php echo $id?>')">
                                                                                                            <span class="glyphicon glyphicon-trash"></span>刪除</button>

                                                                                                        <button type="submit" class="btn btn-primary" name="update_item">
                                                                                                            <span class="glyphicon glyphicon-edit"></span>更改</button>

                                                                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                                                                            <span class="glyphicon glyphicon-remove-circle"></span>取消</button>
                                                                                                    </div>
                                                                                                    <script language="javascript">
                                                                                                        function delForm(id) {
                                                                                                            if (confirm("確認刪除此課程嗎?")) {
                                                                                                                location.href = "manage_t.php?del=" + id
                                                                                                                alert("課程已刪除!");
                                                                                                            }
                                                                                                        }

                                                                                                    </script>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </center>
                                                                            </tr>


                                                                            <?php  
                                                                                    } 
                                                                                    //Update Items
                                                                                    if(isset($_POST['update_item'])){
                                                                                        $edit_id = $_POST['edit_id'];
                                                                                        echo $edit_id;
                                                                                        $edit_year = $_POST['edit_year'];
                                                                                        $edit_sem = $_POST['edit_sem'];
                                                                                        $edit_name = $_POST['edit_name'];
                                                                                        echo $edit_name;
                                                                                        $edit_code = $_POST['edit_code'];
                                                                                        $edit_grade = $_POST['edit_grade'];
                                                                                        $edit_pro = $_POST['edit_pro'];
                                                                                
                                                                                        $update = "UPDATE professor SET 
                                                                                        year='$edit_year',
                                                                                        semester='$edit_sem',
                                                                                        course_name='$edit_name',
                                                                                        course_code='$edit_code',
                                                                                        grade='$edit_grade',
                                                                                        account='$edit_pro'
                                                                                        WHERE id='$edit_id' ";
                                                                                        if ($link->query($update) === TRUE) {
                                                                                            echo '<script>window.location.href="manage_t.php"</script>';
                                                                                        } else {
                                                                                            echo "Error updating record: " . $conn->error;
                                                                                        }
                                                                                    }
                                                                                    
                                                                                }
                                                                            ?>
                                                                        </tbody>
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
    <script src='js/jquery-1.10.2.min.js'></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
