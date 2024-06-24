<?php  
require_once "class/Database.php";
require_once "class/User.php";
$pdo = Database::getInstance()->getConnection();
$userName = "";
$password ="";
$checked = false;

// Check if the login form has been submitted
if(isset($_POST["login"])){
    // Get the values entered by the user in the form
	$username = $_POST["userName"];
	$password = $_POST["password"];

	$authenticationResult = User::authenticate($pdo,$username, $password);

    // Check the authentication result
    if (is_array($authenticationResult)) {
        // Authentication successful
        $_SESSION["username"] = $username;
        echo "Xin chào " . $username . ". Bạn đã đăng nhập thành công. <a href='index.php'>Về trang chủ</a>";
        die();
    } else {
        // Authentication failed, display error message
        echo $authenticationResult . " <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
}

// Check if the username and password cookies exist
if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])){
	$userName = $_COOKIE["username"];
	$password = $_COOKIE["password"];
	$checked = true;
}	
?>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="menu-account">
				<h3><span>Tài khoản</span></h3>
				<ul>
					<li><a href="index.php?view=login"><i class="fa fa-sign-in"></i>Đăng nhập</a></li>
					<li><a href="index.php?view=createid"><i class="fa fa-key"></i>Đăng ký</a></li>
					<li><a href=""><i class="fa fa-key"></i>Quên mật khẩu</a></li>
				</ul>
			</div>                    
		</div>
		<div class="col-md-9">
			<script src="/app/services/accountServices.js"></script>
			<script src="/app/controllers/accountController.js"></script>
			<div class="login-content clearfix ng-scope" ng-controller="accountController" ng-init="initController()">
				<h1 class="title"><span>Đăng nhập hệ thống</span></h1>
				<div class="col-md-6 col-md-offset-3 col-xs-12 col-sm-12 col-xs-offset-0 col-sm-offset-0">
					<form method="post">
						<div class="form-group">
							<label for="Email" class="col-sm-4 control-label">Tài khoản</label>
							<div class="col-sm-8">
								<input class="form-control ng-pristine ng-untouched ng-valid-email ng-invalid ng-invalid-required" ng-model="Email" ng-required="true" required="required" type="text" value="<?php echo $userName ?>" id="userName" name="userName" >
							</div>
						</div>
						<div class="form-group">
							<label for="Password" class="col-sm-4 control-label">Mật khẩu</label>
							<div class="col-sm-8">
								<input class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" ng-model="Password" ng-required="true" required="required" type="password" value="<?php echo $password ?>"  id="password" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<button type="submit" class="btn btn-default" name="login">Đăng nhập</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
