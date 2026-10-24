<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

$academicyear_id = "";
$academicyear_year = "";
$hid = "";

if(isset($_POST['btn_submit']))
{
    $academicyearname = $_POST['txt_year'];
    $hid = $_POST['txt_hidden'];

    $select = "select * from tbl_academicyear where academicyear_year='".$academicyearname."'";
    $ro = $Conn->query($select);

    if($da = $ro->fetch_assoc())
    {
        echo "<script>alert('Already Exist');window.location='AcademicYear.php';</script>";
    }
    else
    {
        if($hid=="")
        {
            $insqry = "insert into tbl_academicyear(academicyear_year) values('".$academicyearname."')";
            if($Conn->query($insqry))
            {
                echo "<script>alert('Inserted');window.location='AcademicYear.php';</script>";
            }
        }
        else
        {
            $updateqry = "update tbl_academicyear set academicyear_year='".$academicyearname."' where academicyear_id='".$hid."'";
            if($Conn->query($updateqry))
            {
                echo "<script>alert('Updated');window.location='AcademicYear.php';</script>";
            }
        }
    }
}

if(isset($_GET['eid']))
{
    $selectAcademicYear = "select * from tbl_academicyear where academicyear_id='".$_GET["eid"]."'";
    $data_Cat = $Conn->query($selectAcademicYear);
    $row = $data_Cat->fetch_assoc();
    $academicyear_id = $row['academicyear_id'];
    $academicyear_year = $row['academicyear_year'];
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_academicyear where academicyear_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='AcademicYear.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Academic Year</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #dff1ff, #b3daff);
    font-family: 'Segoe UI', sans-serif;
}
.main-card {
    max-width: 900px;
    margin: 30px auto;
    border-radius: 15px;
    box-shadow: 0px 6px 18px rgba(0,0,0,0.1);
    background: #fff;
}
.card-header {
    border-radius: 15px 15px 0 0;
    font-weight: 600;
    font-size: 18px;
}
.btn-primary {
    background-color: #0056b3;
    border: none;
}
.btn-primary:hover {
    background-color: #007bff;
}
.table thead {
    background: #0056b3;
    color: #fff;
}
</style>
</head>

<body>
<div class="main-card">
    <div class="card-header bg-primary text-white text-center">
        Manage Academic Year
    </div>
    <div class="card-body p-4">
        <!-- Form -->
        <form method="post" class="mb-4">
            <input type="hidden" name="txt_hidden" value="<?php echo $academicyear_id ?>"/>
            <div class="mb-3">
                <label class="form-label fw-bold">Academic Year</label>
                <input type="text" name="txt_year" class="form-control"
                       value="<?php echo $academicyear_year ?>"
                       placeholder="Eg: 2024-2025" required>
            </div>
            <button type="submit" name="btn_submit" class="btn btn-success w-100">Submit</button>

        </form>

        <!-- List -->
        <h5 class="fw-bold mb-3">Academic Year List</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>SL.NO</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                $select="select * from tbl_academicyear";
                $res=$Conn->query($select);
                if($res->num_rows > 0){
                    while($data=$res->fetch_assoc()){
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td class="fw-bold"><?php echo $data['academicyear_year'] ?></td>
                    <td>
                        <a href="AcademicYear.php?eid=<?php echo $data['academicyear_id'] ?>" 
                           class="btn btn-sm btn-warning">
                           <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="AcademicYear.php?did=<?php echo $data['academicyear_id'] ?>" 
                           class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                           <i class="bi bi-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php } } else { ?>
                    <tr><td colspan="3" class="text-muted">No Academic Years Added</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

<?php include('Footer.php'); ?>
