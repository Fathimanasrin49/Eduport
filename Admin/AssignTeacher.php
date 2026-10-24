<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php'); 

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_teacher where teacher_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo '<script>alert("Deleted"); window.location="Teacher.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport::Teacher List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background-color: #cce6ff; /* Light blue background */
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .table thead {
        background-color: #007BFF;
        color: white;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
</style>
</head>

<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Teacher List</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>SL.NO</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Proof</th>
                        <th>Certificate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                $select='SELECT * FROM tbl_teacher';
                $res=$Conn->query($select);
                while($data=$res->fetch_assoc())
                {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $data['teacher_name']; ?></td>
                        <td><?php echo $data['teacher_email']; ?></td>
                        <td>
                            <img src="../Assets/Files/Teacherimage/<?php echo $data['teacher_photo']; ?>" 
                                 class="img-thumbnail" width="70" height="70">
                        </td>
                        <td>
                            <img src="../Assets/Files/Teacherproof/<?php echo $data['teacher_proof']; ?>" 
                                 class="img-thumbnail" width="70" height="70">
                        </td>
                        <td>
                            <img src="../Assets/Files/Teachercertificate/<?php echo $data['teacher_certificate']; ?>" 
                                 class="img-thumbnail" width="70" height="70">
                        </td>
                        <td>
                            <a href="Assign.php?tid=<?php echo $data['teacher_id']; ?>" 
                               class="btn btn-success btn-sm mb-1">
                                <i class="bi bi-person-plus"></i> Assign
                            </a>
                            <a href="Teacher.php?did=<?php echo $data['teacher_id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this teacher?');">
                               <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('Footer.php'); ?>
