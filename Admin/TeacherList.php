<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php'); 

if(isset($_GET["did"])) {
    $deleqry="DELETE FROM tbl_teacher WHERE teacher_id='".$_GET["did"]."'";
    if($Conn->query($deleqry)) {
        ?>
        <script>
            alert("Teacher deleted successfully");
            window.location="TeacherList.php";
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport :: Teacher List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background-color: #cce6ff; /* Light blue background */
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .card-header {
        font-weight: bold;
        font-size: 1.1rem;
        text-align: center;
    }
    .table thead {
        background-color: #007BFF;
        color: white;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
    .img-thumbnail {
        border-radius: 8px;
    }
</style>
</head>

<body>
<div class="container my-4">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="Adminhome.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Teacher List Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Teacher List</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>SI.NO</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Proof</th>
                        <th>Certificate</th>
                        <th>Class</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                $select='SELECT * FROM tbl_teacher t 
                         LEFT JOIN tbl_class c ON c.class_id=t.class_id 
                         INNER JOIN tbl_course cs ON cs.course_id = c.course_id 
                         INNER JOIN tbl_department d ON cs.department_id = d.department_id';
                $res=$Conn->query($select);
                while($data=$res->fetch_assoc()) {
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
                        <td><?php echo $data['class_name']?></td>
                        <td><?php echo $data['department_name']?></td>
                        <td>
                            <a href="TeacherList.php?did=<?php echo $data['teacher_id']; ?>" 
                               class="btn btn-sm btn-danger"
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('Footer.php'); ?>
