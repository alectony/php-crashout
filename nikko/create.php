<?php

session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

require_once "config/database.php";

$item_name = "";
$quantity = "";
$price = "";
$edit_id = "";
$is_edit = false;
$error = "";

if (isset($_GET["edit"])) {
    $edit_id = intval($_GET["edit"]);

    $sql = "SELECT id, item_name, quantity, price FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        $item_name = $row["item_name"];
        $quantity = $row["quantity"];
        $price = $row["price"];
        $is_edit = true;
    } else {
        $error = "Item not found.";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"];

    $item_name = trim($_POST["item_name"]);
    $quantity = intval($_POST["quantity"]);
    $price = floatval($_POST["price"]);

    if ($item_name === "") {
        $error = "Item name is required.";
    } elseif ($quantity < 0) {
        $error = "Quantity cannot be negative.";
    } elseif ($price < 0) {
        $error = "Price cannot be negative.";
    } else {

        if ($action === "update") {
            $id = intval($_POST["id"]);

            $sql = "UPDATE inventory SET item_name = ?, quantity = ?, price = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sidi", $item_name, $quantity, $price, $id);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Failed to update item.";
            }

            $stmt->close();

        } elseif ($action === "save") {
            $sql = "INSERT INTO inventory (item_name, quantity, price) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sid", $item_name, $quantity, $price);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Failed to add item.";
            }

            $stmt->close();
        }
    }
}

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
.form-control{display:block;box-sizing:border-box;width:100%;padding:10px;margin:8px 0 16px;border:1px solid #bbc6d3;border-radius:6px}
.btn{display:inline-block;padding:9px 16px;border:0;border-radius:6px;background:#1467d9;color:white;text-decoration:none;cursor:pointer}
.btn-secondary{background:#66758a}
.alert{padding:12px;background:#fff0d6;margin:12px 0;border-radius:6px}
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
<a class="btn btn-secondary" href="logout.php">Logout</a>
</div>

<div class="card">

<?php if ($is_edit): ?>
<h2>Edit Item</h2>
<?php else: ?>
<h2>Add Item</h2>
<?php endif; ?>

<?php if ($error != ""): ?>
<div class="alert"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post">

<?php if ($is_edit): ?>
<input type="hidden" name="action" value="update">
<input type="hidden" name="id" value="<?php echo $edit_id; ?>">
<?php else: ?>
<input type="hidden" name="action" value="save">
<?php endif; ?>

<div class="row">

<div class="col-md-6">
<label for="item_name">Item Name</label>
<input class="form-control" id="item_name" name="item_name" maxlength="100"
value="<?php echo htmlspecialchars($item_name); ?>" required>
</div>

<div class="col-md-3">
<label for="quantity">Quantity</label>
<input class="form-control" id="quantity" name="quantity" type="number"
min="0" max="2147483647" step="1"
value="<?php echo htmlspecialchars($quantity); ?>" required>
</div>

<div class="col-md-3">
<label for="price">Price</label>
<input class="form-control" id="price" name="price" type="number"
min="0" max="99999999.99" step="0.01"
value="<?php echo htmlspecialchars($price); ?>" required>
</div>

</div>

<?php if ($is_edit): ?>
<button class="btn btn-primary" type="submit">Update Item</button>
<?php else: ?>
<button class="btn btn-primary" type="submit">Add Item</button>
<?php endif; ?>

<a class="btn btn-secondary" href="index.php">Cancel</a>

</form>
</div>
</main>
</body>
</html>

<?php $conn->close(); ?>
