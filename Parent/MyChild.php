<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if (!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: My Child Info</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    padding: 20px 0 0 0;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #4CAF50;
}

.table {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
}

.table tr:hover {
    background-color: #e8f5e9;
    transition: 0.3s;
}

img {
    border-radius: 50%;
    transition: transform 0.3s;
}

img:hover {
    transform: scale(1.1);
}

/* Actions Box Styling */
.actions-box {
    display: inline-block;
    background-color: #fff3e0; /* light highlight color */
    padding: 5px 10px;
    border-radius: 8px;
    box-shadow: 0px 3px 10px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.actions-box a {
    margin: 0 4px;
    color: #4a4e4aff;
    font-weight: 500;
    text-decoration: none;
}

.actions-box a:hover {
    color: #0e0e0eff;
    text-decoration: underline;
}

/* Footer Styling */
footer {
    background-color: #8B4513; /* nice brown */
    color: #fff;
    padding: 20px 0;
    text-align: center;
    margin-top: auto;
    width: 100%;
}

footer a {
    color: #FFD700;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}
</style>
</head>

<body>
<div class="container flex-grow-1">
    <h2>My Child Info</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-success">
                <tr>
                    <th>SI.NO</th>
                    <th>NAME</th>
                    <th>CLASS</th>
                    <th>ROLL NO</th>
                    <th>ADDRESS</th>
                    <th>PHOTO</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $select = "SELECT * FROM tbl_student s 
                           INNER JOIN tbl_class c ON c.class_id = s.class_id 
                           INNER JOIN tbl_teacher t ON t.class_id = s.class_id  
                           WHERE parent_id='" . $_SESSION['uid'] . "'";
                $res = $Conn->query($select);

                while ($data = $res->fetch_assoc()) {
                    $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($data['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['student_rollno']); ?></td>
                    <td><?php echo htmlspecialchars($data['student_address']); ?></td>
                    <td>
                        <img src="../Assets/Files/Studentimage/<?php echo $data['student_photo']; ?>" width="70" height="70" alt="Student Photo">
                    </td>
                    <td>
                        <div class="actions-box">
                            <a href="Leave.php?sid=<?php echo $data['student_id']; ?>">Apply Leave</a> |
                            <a href="ReportParent.php?tid=<?php echo $data['teacher_id']; ?>">Report</a> |
                            <a href="ViewInternalMark.php?sid=<?php echo $data['student_id']; ?>">Internal Mark</a> |
                            <a href="ViewMainMark.php?sid=<?php echo $data['student_id']; ?>">Main Exam</a> |
                            <a href="ViewAttendanceReport.php?sid=<?php echo $data['student_id']; ?>">Attendance</a>
                        </div>
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
