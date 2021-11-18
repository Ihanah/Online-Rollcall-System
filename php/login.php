<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["authority"] == 1){
        header("location: welcome_t.php");

    }else if($_SESSION["authority"] == 2){
        header("location: welcome_s.php");
 
    }else if($_SESSION["authority"] == 0){
        header("location: welcome_r.php");
    }
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$account = $password = "";
$account_err = $password_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if account is empty
    if(empty(trim($_POST["account"]))){
        $account_err = "Please enter id.";
    } else{
        $account = trim($_POST["account"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "請輸入密碼!";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($account_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT authority, id, account, username, password FROM users WHERE account = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_account);
            
            // Set parameters
            $param_account = $account;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // 檢查用戶名是否存在，如果是，則驗證密碼
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt,$authority, $id, $account, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // 密碼正確，因此開始新的 session
                             
                            //學生權限
                            if($authority == 1){
                                session_start();                           
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["account"] = $account;  
                                $_SESSION["username"] = $username;
                                $_SESSION["authority"] = $authority;
                                header("location: welcome_t.php");
                            
                            //教師權限
                            }else if($authority == 2){
                                session_start();
                            
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["account"] = $account;  
                                $_SESSION["username"] = $username;
                                $_SESSION["authority"] = $authority;
                                header("location: welcome_s.php");
                                
                            //管理員權限    
                            }else{
                                session_start();
                            
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["account"] = $account;  
                                $_SESSION["username"] = $username;
                                $_SESSION["authority"] = $authority;
                                header("location: welcome_r.php");
                            }
                            // Redirect user to welcome page

                        } else{
                            // Display an error message if password is not valid
                            $password_err = "密碼錯誤請確認後重新輸入";
                        }
                    }
                } else{
                    // Display an error message if account doesn't exist
                    $account_err = "此帳號不存在請重新輸入";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
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
    <title>線上座位點名系統-登入</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        body {
            font-family: 微軟正黑體;
            font-weight: bold;
            font-size: 15.5px;
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
            color: white
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

    </style>
</head>

<body background="background1.jpg">

    <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="welcome_t.php">線上座位點名系統</a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li class="dropdown">
                            
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
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <!--                    <p>Please fill in your credentials to login.</p>-->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($account_err)) ? 'has-error' : ''; ?>">
                                <div class="form-group">
                                    <label>帳號</label>
                                    <input type="text" name="account" class="form-control" value="<?php echo $account; ?>">
                                    <span class="help-block"><?php echo $account_err; ?></span>
                                </div>
                            </div>
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <div class="form-group">
                                    <label>密碼</label>
                                    <input type="password" name="password" class="form-control">
                                    <span class="help-block"><?php echo $password_err; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <center>
                                <input type="submit" class="btn btn-primary" value="登入">
                                    </center>
                            </div>
                            <!--                        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
