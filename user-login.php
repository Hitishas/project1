<?php
session_start();
require_once __DIR__ . '/include/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $puname = trim($_POST['username'] ?? '');
    $ppwd = $_POST['password'] ?? '';

    if ($puname === '' || $ppwd === '') {
        $_SESSION['errmsg'] = 'Please provide email and password.';
        header('Location: user-login.php');
        exit;
    }

    $stmt = $con->prepare('SELECT id, password FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $puname);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $uip = $_SERVER['REMOTE_ADDR'] ?? '';
    if ($user && password_verify($ppwd, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['login'] = $puname;
        $_SESSION['id'] = $user['id'];

        $status = 1;
        $logStmt = $con->prepare('INSERT INTO userlog (uid, username, userip, status) VALUES (?, ?, ?, ?)');
        $logStmt->bind_param('isss', $user['id'], $puname, $uip, $status);
        $logStmt->execute();

        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['login'] = $puname;
        $status = 0;
        $nullId = null;
        $logStmt = $con->prepare('INSERT INTO userlog (username, userip, status) VALUES (?, ?, ?)');
        $logStmt->bind_param('ssi', $puname, $uip, $status);
        $logStmt->execute();

        $_SESSION['errmsg'] = 'Invalid username or password';
        header('Location: user-login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>User Login</title>
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/styles.css">
	</head>
	<body class="login">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card mt-5">
						<div class="card-body">
							<h4 class="card-title">Sign in to your account</h4>
							<?php if (!empty($_SESSION['errmsg'])): ?>
								<div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['errmsg']); $_SESSION['errmsg']=''; ?></div>
							<?php endif; ?>
							<form method="post" action="">
								<div class="mb-3">
									<label for="username" class="form-label">Email</label>
									<input type="email" id="username" name="username" class="form-control" required>
								</div>
								<div class="mb-3">
									<label for="password" class="form-label">Password</label>
									<input type="password" id="password" name="password" class="form-control" required>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<a href="forgot-password.php">Forgot Password?</a>
									<button type="submit" name="submit" class="btn btn-primary">Login</button>
								</div>
							</form>
						</div>
					</div>
					<div class="text-center mt-2">Don't have an account? <a href="registration.php">Create an account</a></div>
				</div>
			</div>
		</div>
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>