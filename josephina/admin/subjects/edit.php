<?php
session_start();
include "../../config/database.php";
if(!isset($_SESSION['role']) || $_SESSION["role"] !== "admin"){
    header("location: ../../index.php");
    exit();
}
$id = isset($_GET["id"]) ? intval($_GET["id"]) :0;
$result = mysqli_query($conn, "SELECT * FROM subjects WHERE id=$id");
$subject = mysqli_fetch_assoc($result);

if(!$subject){
    die("Subject Not Found!");
}
$message = "";
if(isset($_POST['update'])){
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $units = $_POST['units'];

    $sql = "UPDATE subjects SET subject_code = '$subject_code', subject_name = '$subject_name', units = '$units' 
        WHERE id = $id";
    
    if(mysqli_query($conn, $sql)){
        header("location: index.php");
        $message = "Update Successfully!";
    }
    else{
        $message = "Could not Update!";
    }}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Subject Form</title>
    <!-- Bootstrap CSS -->
    <link
        href="../../assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">
    <!-- Main Container -->
    <div
        class="container py-5"
        style="max-width: 700px;">
        <!-- Subject Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2>Subject Form</h2>
                <?php if($message != ""){?>
                    <div class = "alert alert-danger"><?php echo $message; ?></div>
                <?php } ?>
                <form method = "POST">

                    <!-- Subject Code -->
                    <div class="mb-3">
                        <label class="form-label" >
                            Subject Code
                        </label>

                        <input class="form-control" name = "subject_code" value = "<?php echo htmlspecialchars($subject['subject_code']);?>">
                    </div>
                    <!-- Subject Name -->
                    <div class="mb-3">
                        <label class="form-label" >
                            Subject Name
                        </label>

                        <input class="form-control" name = "subject_name" value = "<?php echo htmlspecialchars($subject['subject_name']);?>">
                    </div>
                    <!-- Units -->
                    <div class="mb-3">
                        <label class="form-label" >
                            Units
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name = "units"
                            value = "<?php echo htmlspecialchars($subject['units']);?>"
                        >
                    </div>
                    <!-- Form Actions -->
                    <button
                        type="submit"
                        class="btn btn-primary"
                        name = "update"
                    >
                        Update Subject
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
