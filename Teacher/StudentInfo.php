<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
    exit();
}

$sel = "SELECT * FROM tbl_teacher WHERE teacher_id=".$_SESSION['tid'];
$row = $Conn->query($sel);
$teacherData = $row->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Student Info</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f4f6f8;
    font-family: 'Poppins', sans-serif;
    padding: 20px 0;
}

/* Heading animation */
h1 {
    text-align: center;
    color: #4CAF50;
    animation: slideIn 1.5s ease-out forwards;
}

@keyframes slideIn {
    0% { transform: translateY(-50px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}

/* Card container */
.card {
    max-width: 1000px;
    margin: 30px auto;
    padding: 20px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    animation: float 6s ease-in-out infinite;
}

/* Floating animation */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

/* Table styles */
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}
.table-hover tbody tr:hover {
    background-color: #e8f5e9;
    transition: 0.3s;
}

/* Action buttons */
.btn-action {
    text-decoration: none;
    padding: 5px 10px;
    margin: 2px;
    border-radius: 5px;
    background-color: #ffc107;
    color: #000;
    font-weight: 500;
    transition: 0.3s;
}
.btn-action:hover {
    background-color: #e0a800;
    color: #fff;
}

</style>
</head>
<body>

<div class="card">
    <h1>STUDENT INFO</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>SL.NO</th>
                    <th>STUDENT NAME</th>
                    <th>ROLL.NO</th>
                    <th>PARENT NAME</th>
                    <th>CONTACT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            $select="SELECT * FROM tbl_student s 
                     INNER JOIN tbl_parent p ON p.parent_id=s.parent_id 
                     WHERE s.class_id='".$teacherData['class_id']."' 
                     ORDER BY s.student_rollno ASC";
            $res=$Conn->query($select);
            while($student=$res->fetch_assoc())
            {
                $i++;
            ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['student_rollno']); ?></td>
                    <td><?php echo htmlspecialchars($student['parent_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['parent_contact']); ?></td>
                    <td>
                        <a href="Attendance.php?sid=<?php echo $student['student_id'] ?>" class="btn-action">Attendance</a>
                        <a href="StudentList.php?did=<?php echo $student['student_id'] ?>" class="btn-action">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
