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
$getid = @$_SESSION["courseid"];
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
$delu = mysqli_query($link, "DELETE FROM users where account = '$del'");
$delc = mysqli_query($link, "DELETE FROM stucourse where stu_id = '$del'");

if(isset($_POST["searchbtn"])){
    if($_POST["searchbtn"]=="查詢"){
        $_SESSION["courseid"] = $_POST["getid"];
        header("location: manage_u.php");
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
     <link rel=stylesheet type="text/css" href="my_css.css">
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
                                                            <span style="color:#FFFFFF;">使用者</span>
                                                        </div>
                                                    </div>
                                                    <div class="fs-block-body ">
                                                        <div class="container con">
                                                            <div class="main">
                                                                <div style='margin-top:10px; margin-bottom:20px; margin-left:10px; margin-right:10px;'>
                                                                    <label for="fname">帳號:</label>
                                                                    <input type="text" id="fname" name="getid">
                                                                    <input type="submit" name="searchbtn" value="查詢">
                                                                    <p></p>
                                                                    <table width="100%">
                                                                        <thead>
                                                                            <tr height="30px">
                                                                                <th width="auto">&nbsp;&nbsp;項次</th>
                                                                                <th width="auto">&nbsp;權限</th>
                                                                                <th width="auto">&nbsp;&nbsp;系所</th>
                                                                                <th width="auto">&nbsp;&nbsp;帳號</th>
                                                                                <th width="auto">&nbsp;&nbsp;姓名</th>
                                                                                <!--                                                                    
                                                                                <th height="30px" width="200">&nbsp;&nbsp;密碼</th>-->
                                                                                <th width="auto">&nbsp;&nbsp;創建日期</th>
                                                                                <th width="auto">&nbsp;&nbsp;編輯</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tableId">

                                                                            <?php
                                                                                $sql = "SELECT * FROM users where account='$getid'";
                                                                                $result = $link->query($sql);
                                                                                if ($result->num_rows > 0) {
                                                                                // output data of each row
                                                                                    while($row = $result->fetch_assoc()) {
                                                                                    $id = $row['id'];
                                                                                    $auth = $row['authority'];
                                                                                    $dep = $row['department'];
                                                                                    $acc = $row['account'];
                                                                                    $name = $row['username'];
                                                                                    $time = $row['created_at'];
                                                                                    @$i+=1;   
                                                                            ?>
                                                                            <tr height="30px">

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $i;?>
                                                                                </td>


                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $auth;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $dep;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $acc;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $name;?>
                                                                                </td>

                                                                                <!--
                                                                                <td height="30px" width="200" name="time" value='$time'>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $row['5'];?>
                                                                                </td>
-->

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $time;?>
                                                                                </td>

                                                                                <td>
                                                                                    <a href="#edit<?php echo $id;?>" data-toggle="modal">
                                                                                        <button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> 編輯</button>
                                                                                    </a>
                                                                                </td>
                                                                                <center>
                                                                                    <div id="edit<?php echo $id;?>" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                        <form method="post" class="form-horizontal" role="form">
                                                                                            <div class="modal-dialog">
                                                                                                <!-- Modal content-->
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                        <h3><span class='glyphicon glyphicon-user' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;使用者資料</span></span></h3>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <center>
                                                                                                            <input type="hidden" name="edit_id" value="<?php echo $id?>" placeholder="ID" required>

                                                                                                            <span class='glyphicon glyphicon-tags' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;權限: </span></span>
                                                                                                            <input type="text" name="edit_auth" value="<?php echo $auth?>" placeholder="權限" required>

                                                                                                            <span class='glyphicon glyphicon-education' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;系所: </span></span>
                                                                                                            <input type="text" name="edit_dep" value="<?php echo $dep?>" placeholder="系所" required><br>
                                                                                                            <p></p>

                                                                                                            <span class='glyphicon glyphicon-barcode' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;帳號: </span></span>
                                                                                                            <input type="text" name="edit_acc" value="<?php echo $acc?>" placeholder="帳號" required>

                                                                                                            <span class='glyphicon glyphicon-pencil' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;姓名: </span></span>
                                                                                                            <input type="text" name="edit_name" value="<?php echo $name?>" placeholder="姓名" required><br>
                                                                                                        </center>

                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <?php echo '<input type="button" name="del" value="刪除" data-dismiss="modal" onclick= location.href="manage_u.php?del=' . $id . '">'; ?>
                                                                                                        <input type="button" name="hdel" value="刪除" class="btn btn-danger" onclick="delForm('<?php echo $id?>')">
                                                                                                        <script language="javascript">
                                                                                                            function delForm(id) {
                                                                                                                if (confirm("確認刪除此使用者嗎?")) {
                                                                                                                    location.href = "manage_u.php?del=" + id
                                                                                                                    alert("使用者已刪除!");
                                                                                                                }
                                                                                                            }

                                                                                                        </script>

                                                                                                        <button type="submit" class="btn btn-primary" name="update_item"><span class="glyphicon glyphicon-edit"></span>更改</button>
                                                                                                        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>取消</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </center>
                                                                                <?php  
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </tr>

                                                                            <?php
                                                                                $sql = "SELECT * FROM users";
                                                                                $result = $link->query($sql);
                                                                                if ($result->num_rows > 0) {
                                                                                // output data of each row
                                                                                    while($row = $result->fetch_assoc()) {
                                                                                    $id = $row['id'];
                                                                                    $auth = $row['authority'];
                                                                                    $dep = $row['department'];
                                                                                    $acc = $row['account'];
                                                                                    $name = $row['username'];
                                                                                    $time = $row['created_at'];
                                                                                    @$i+=1;
                                                                            ?>
                                                                            <tr height="30px">

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $i;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $auth;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $dep;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php echo $acc;?>
                                                                                </td>

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $name;?>
                                                                                </td>

                                                                                <!--
                                                                                <td height="30px" width="200" name="time" value='$time'>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $row['5'];?>
                                                                                </td>
-->

                                                                                <td>
                                                                                    &nbsp;&nbsp;
                                                                                    <?php  echo $time;?>
                                                                                </td>

                                                                                <td>
                                                                                    <a href="#edit<?php echo $id;?>" data-toggle="modal">
                                                                                        <button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> 編輯</button>
                                                                                    </a>
                                                                                </td>
                                                                                <center>
                                                                                    <div id="edit<?php echo $id;?>" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                        <form method="post" class="form-horizontal" role="form">
                                                                                            <div class="modal-dialog">
                                                                                                <!-- Modal content-->
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                        <h3><span class='glyphicon glyphicon-user' aria-hidden='true'>
                                                                                                            <span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;&nbsp;使用者資料</span></span>
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                    <div class="modal-body">

                                                                                                        <center>
                                                                                                            <input type="hidden" name="edit_id" value="<?php echo $id?>" placeholder="ID" required>

                                                                                                            <span class='glyphicon glyphicon-tags' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;權限: </span></span>
                                                                                                            <input type="text" name="edit_auth" value="<?php echo $auth?>" placeholder="權限" required>

                                                                                                            <span class='glyphicon glyphicon-education' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;系所: </span></span>
                                                                                                            <input type="text" name="edit_dep" value="<?php echo $dep?>" placeholder="系所" required><br>
                                                                                                            <p></p>

                                                                                                            <span class='glyphicon glyphicon-barcode' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;帳號: </span></span>
                                                                                                            <input type="text" name="edit_acc" value="<?php echo $acc?>" placeholder="帳號" required>

                                                                                                            <span class='glyphicon glyphicon-pencil' aria-hidden='true'><span style="font-family: 'Microsoft JhengHei'; font-weight: bold;">&nbsp;姓名: </span></span>
                                                                                                            <input type="text" name="edit_name" value="<?php echo $name?>" placeholder="姓名" required><br>
                                                                                                        </center>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">


                                                                                                        <button type="button" name="hdel" class="btn btn-danger" onclick="delForm('<?php echo $acc?>')">
                                                                                                            <span class="glyphicon glyphicon-trash"></span>刪除</button>
                                                                                                        <button type="submit" name="update_item" class="btn btn-warning">
                                                                                                            <span class="glyphicon glyphicon-edit"></span>更改</button>
                                                                                                        <button type="button" data-dismiss="modal" class="btn btn-primary">
                                                                                                            <span class="glyphicon glyphicon-remove-circle"></span>取消</button>

                                                                                                        <script language="javascript">
                                                                                                            function delForm(id) {
                                                                                                                if (confirm("確認刪除此使用者嗎?")) {
                                                                                                                    location.href = "manage_u.php?del=" + id
                                                                                                                    alert("使用者已刪除!");
                                                                                                                }
                                                                                                            }

                                                                                                        </script>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </center>
                                                                            </tr>

                                                                            <?php 
                                                                                    }
                                                                                    if(isset($_POST['update_item'])){
                                                                                        $edit_id = $_POST['edit_id'];
                                                                                        $edit_auth = $_POST['edit_auth'];
                                                                                        $edit_dep = $_POST['edit_dep'];
                                                                                        $edit_acc = $_POST['edit_acc'];
                                                                                        $edit_name = $_POST['edit_name'];
                                                                                
                                                                                        $update = "UPDATE users SET 
                                                                                        authority='$edit_auth',
                                                                                        department='$edit_dep',
                                                                                        account='$edit_acc',
                                                                                        username='$edit_name'
                                                                                
                                                                                        WHERE id='$edit_id' ";
                                                                                        if ($link->query($update) === TRUE) {
                                                                                            echo '<script>window.location.href="manage_u.php"</script>';
                                                                                        } else {
                                                                                            echo "Error updating record: " . $link->error;
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
