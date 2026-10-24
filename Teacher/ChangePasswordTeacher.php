<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if (!isset($_SESSION['tid']) || $_SESSION['tid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

if (isset($_POST['btn_password'])) {
    $select = "SELECT * FROM tbl_teacher WHERE teacher_id='" . $_SESSION['tid'] . "'";
    $Teacherdata = $Conn->query($select);
    $Teacherrow = $Teacherdata->fetch_assoc();

    $password = $Teacherrow['teacher_password'];
    $old = $_POST['txt_old'];
    $new = $_POST['txt_new'];
    $retype = $_POST['txt_retype'];

    if ($password == $old) {
        if ($new == $retype) {
            $updateqry = "UPDATE tbl_teacher SET teacher_password='" . $new . "' WHERE teacher_id='" . $_SESSION['tid'] . "'";
            if ($Conn->query($updateqry)) {
                echo "<script>alert('Password updated successfully'); window.location='TeacherProfile.php';</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match'); window.location='TeacherChangePassword.php';</script>";
        }
    } else {
        echo "<script>alert('Old password is incorrect'); window.location='TeacherChangePassword.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Change Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
}
.card {
    max-width: 450px;
    margin: 50px auto;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    background-color: #fff;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #4CAF50;
}
input[type="password"] {
    border-radius: 8px;
}
.btn-primary {
    width: 100%;
    border-radius: 8px;
}
</style>
</head>
<body>

<div class="card">
    <h2>Change Password</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="txt_old" class="form-label">Old Password</label>
            <input type="password" class="form-control" name="txt_old" id="txt_old" placeholder="Enter old password" required>
        </div>
        <div class="mb-3">
            <label for="txt_new" class="form-label">New Password</label>
            <input type="password" class="form-control" name="txt_new" id="txt_new" placeholder="Enter new password" 
                   required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                   title="Must contain at least one number, one uppercase & lowercase letter, and at least 8 characters">
        </div>
        <div class="mb-3">
            <label for="txt_retype" class="form-label">Re-Type New Password</label>
            <input type="password" class="form-control" name="txt_retype" id="txt_retype" placeholder="Re-enter new password" required>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-primary" name="btn_password" value="Change Password">
            <a href="TeacherProfile.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
