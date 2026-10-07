<?php

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if ($username === "admin" && $password === "admin123") {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventory Exam - Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f3f6fa;color:#243147;font-family:Arial,sans-serif;margin:0}
.container{max-width:1000px;margin:auto;padding:24px}
.card{background:white;border:1px solid #dde4ed;border-radius:12px;padding:24px;margin-bottom:20px}
.form-control{display:block;box-sizing:border-box;width:100%;padding:10px;margin:8px 0 16px;border:1px solid #bbc6d3;border-radius:6px}
.btn{display:inline-block;padding:9px 16px;border:0;border-radius:6px;background:#1467d9;color:white;text-decoration:none;cursor:pointer}
.alert{padding:12px;background:#fff0d6;margin:12px 0;border-radius:6px}
.login{max-width:420px;margin:70px auto}
.muted{color:#66758a}
button,input{font:inherit}
</style>
</head>
<body>
<main class="container">
<div class="card login">
<p class="muted">PHP AND MYSQLI PRACTICAL EXAM</p>
<h1>Inventory Login</h1>
<p>Sign in to manage inventory items.</p>

<?php if ($error != ""): ?>
<div class="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post">
<label for="username">Username</label>
<input class="form-control" id="username" name="username" required autocomplete="username">

<label for="password">Password</label>
<input class="form-control" id="password" name="password" type="password" required autocomplete="current-password">

<button class="btn btn-primary" type="submit">Login</button>
</form>
</div>
</main>
</body>
</html>
