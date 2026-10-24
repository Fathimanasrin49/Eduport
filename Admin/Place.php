<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');
if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

if(isset($_POST['btn_submit']))
{
    $placename=$_POST['txt_name'];
    $pincode=$_POST['txt_code'];
    $district=$_POST['txt_district'];

    $select="select * from tbl_place where place_name='".$placename."' and district_id='".$district."'";
    $ro=$Conn->query($select);
    if($da=$ro->fetch_assoc())
    {
        echo "<script>alert('Already Exist');window.location='Place.php';</script>";
    }
    else
    {
        $insqry="insert into tbl_place(place_name,place_code,district_id)values('".$placename."','".$pincode."','".$district."')";
        if($Conn->query($insqry))
        {
            echo "<script>alert('Inserted');window.location='Place.php';</script>";
        }
    }
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_place where place_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='Place.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Place Management</title>
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

    <!-- Place Form -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Add Place
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Place Name</label>
                        <input type="text" name="txt_name" class="form-control" placeholder="Enter place name" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="txt_code" class="form-control" placeholder="Enter pincode" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">District</label>
                        <select name="txt_district" class="form-select" required>
                            <option value="">Select District</option>
                            <?php
                            $select='select * from tbl_district';
                            $res=$Conn->query($select);
                            while($data=$res->fetch_assoc())
                            {
                                echo "<option value='".$data["district_id"]."'>".$data["district_name"]."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_submit" class="btn btn-success w-50">
                        <i class="bi bi-check-circle"></i> Submit
                    </button>
                    <a href="Place.php" class="btn btn-secondary w-25">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Place List -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Place List
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>SL.NO</th>
                        <th>Place Name</th>
                        <th>Pincode</th>
                        <th>District</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $select="select * from tbl_place p inner join tbl_district d on p.district_id=d.district_id";
                    $res=$Conn->query($select);
                    while($data=$res->fetch_assoc())
                    {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $data['place_name']; ?></td>
                            <td><?php echo $data['place_code']; ?></td>
                            <td><?php echo $data['district_name']; ?></td>
                            <td>
                                <a href="Place.php?did=<?php echo $data['place_id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this place?');">
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
