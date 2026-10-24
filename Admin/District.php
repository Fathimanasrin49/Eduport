<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php'); 
if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

$district_id="";
$district_name="";
$hid="";

if(isset($_POST['btn_submit']))
{
    $districtname=$_POST['txt_district'];
    $hid=$_POST['txt_hidden'];
    $select="select * from tbl_district where district_name='".$districtname."'";
    $ro=$Conn->query($select);
    if($da=$ro->fetch_assoc())
    {
        echo "<script>alert('Already Exist');window.location='District.php';</script>";
    }
    else
    {
        if($hid=="")
        {
            $insqry="insert into tbl_district(district_name) values('".$districtname."')";
            if($Conn->query($insqry))
            {
                echo "<script>alert('Inserted');window.location='District.php';</script>";
            }
        }
        else
        {
            $updateqry="update tbl_district set district_name='".$districtname."' where district_id='".$hid."'";
            if($Conn->query($updateqry))
            {
                echo "<script>alert('Updated');window.location='District.php';</script>";
            }
        }
    }
}

if(isset($_GET['eid']))
{
    $selectDistrict="select * from tbl_district where district_id='".$_GET["eid"]."'";
    $data_Cat=$Conn->query($selectDistrict);
    $row=$data_Cat->fetch_assoc();
    $district_id=$row['district_id'];
    $district_name=$row['district_name'];
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_district where district_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='District.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>District Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #cce6ff; }
        .card { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .card-header { font-weight: bold; font-size: 1.1rem; text-align: center; }
        .btn-primary { background-color: #007BFF; border: none; }
        .btn-danger { background-color: #DC3545; border: none; }
        .table thead { background-color: #007BFF; color: white; }
    </style>
</head>
<body>
<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            District Form
        </div>
        <div class="card-body">
            <form method="post" action="">
                <input type="hidden" name="txt_hidden" value="<?php echo $district_id ?>"/>
                <div class="mb-3">
                    <label class="form-label">District Name</label>
                    <input type="text" class="form-control" name="txt_district" value="<?php echo $district_name ?>" placeholder="Enter district name" required>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_submit" class="btn btn-success w-50">
                        <i class="bi bi-check-circle"></i> Submit
                    </button>
                    <a href="District.php" class="btn btn-secondary w-25">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            District List
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>SL.NO</th>
                        <th>District</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $select="select * from tbl_district";
                    $res=$Conn->query($select);
                    while($data=$res->fetch_assoc())
                    {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $data['district_name'] ?></td>
                            <td>
                                <a href="District.php?eid=<?php echo $data['district_id'] ?>" class="btn btn-sm btn-primary mb-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="District.php?did=<?php echo $data['district_id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this?');">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php include('Footer.php'); ?>
</body>
</html>
