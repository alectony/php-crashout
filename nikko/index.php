<?php

session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

require_once "config/database.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
    if ($_POST["action"] === "delete") {
        $id = intval($_POST["id"]);

        $sql = "DELETE FROM inventory WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "Item deleted successfully.";
        } else {
            $error = "Failed to delete item.";
        }

        $stmt->close();
    }
}

$sql = "SELECT id, item_name, quantity, price FROM inventory ORDER BY id ASC";
$result = $conn->query($sql);

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventory Exam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f3f6fa;color:#243147;font-family:Arial,sans-serif;margin:0}
.container{max-width:1000px;margin:auto;padding:24px}
.card{background:white;border:1px solid #dde4ed;border-radius:12px;padding:24px;margin-bottom:20px}
.btn{display:inline-block;padding:9px 16px;border:0;border-radius:6px;background:#1467d9;color:white;text-decoration:none;cursor:pointer}
.btn-danger{background:#c53644}
.btn-secondary{background:#66758a}
.table{width:100%}
.alert{padding:12px;margin:12px 0;border-radius:6px}
.alert-success{background:#d1e7dd;color:#0f5132}
.alert-danger{background:#f8d7da;color:#842029}
.topbar{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:20px}
.muted{color:#66758a}
button,input{font:inherit}
</style>
</head>
<body>
<main class="container">

<div class="topbar">
<div>
<p class="muted">PHP AND MYSQLI</p>
<h1>Inventory Manager</h1>
</div>
<div>
<span class="me-2">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
<a class="btn btn-secondary" href="logout.php">Logout</a>
</div>
</div>

<?php if ($message != ""): ?>
<div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($error != ""): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<a class="btn btn-primary mb-3" href="create.php">Add Item</a>

<div class="card">
<h2>Inventory List</h2>
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr>
<th>ID</th>
<th>Item Name</th>
<th>Quantity</th>
<th>Price</th>
<th>Actions</th>
</tr>
</thead>
<tbody>

<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row["id"]; ?></td>
<td><?php echo htmlspecialchars($row["item_name"]); ?></td>
<td><?php echo $row["quantity"]; ?></td>
<td>₱<?php echo number_format($row["price"], 2); ?></td>
<td>
<a class="btn btn-primary btn-sm" href="create.php?edit=<?php echo $row["id"]; ?>">Edit</a>

<form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
<button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-center">No inventory items found.</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>
</div>
</main>
</body>
</html>

<?php $conn->close(); ?>
