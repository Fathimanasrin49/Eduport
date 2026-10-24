<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

if(isset($_POST['btn_submit']))
{
    $class=$_POST['sel_class'];
    $upqry="UPDATE tbl_teacher SET class_id='".$class."' WHERE teacher_id='".$_GET['tid']."'";
    if($Conn->query($upqry))
    {
        echo '<script>alert("Assigned"); window.location="AssignTeacher.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport::Assign Teacher</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Assign Teacher to Class</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="sel_class" class="form-label">Class</label>
                    <select class="form-select" id="sel_class" name="sel_class" required>
                        <option value="">Select Class</option>
                        <?php
                        $sel="SELECT * FROM tbl_class";
                        $res=$Conn->query($sel);
                        while($data=$res->fetch_assoc())
                        {
                            echo '<option value="'.$data['class_id'].'">'.$data['class_name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('Footer.php'); ?>
