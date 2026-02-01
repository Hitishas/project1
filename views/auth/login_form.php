<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Hotel Management</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="login-container">
    <h1>Hotel Management - Login</h1>
    <?php if (!empty($error)): ?>
        <div class="error">Invalid credentials, try again.</div>
    <?php endif; ?>
    <form method="post" action="/controllers/auth.php?action=login">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <p class="help">Default admin: create via SQL seed or register manually.</p>
</div>
<script src="/assets/js/app.js"></script>
</body>
</html>
