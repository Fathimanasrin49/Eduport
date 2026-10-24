<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if (!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

$student_id = isset($_GET['sid']) ? $_GET['sid'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    padding: 20px 0 0 0;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #4CAF50;
}

.card {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #e8f5e9;
    transition: 0.3s;
}

.btn-action {
    background-color: #ffc107;
    color: #000;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
}

.btn-action:hover {
    background-color: #e0a800;
    color: #fff;
}

/* Sticky footer styling */
footer {
    background-color: #8B4513; /* brown */
    color: #fff;
    text-align: center;
    padding: 20px 0;
    margin-top: auto;
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
<div class="flex-grow-1">
    <div class="card">
        <h2>Attendance List</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>SL.NO</th>
                        <th>MONTH</th>
                        <th>PERCENTAGE</th>
                        <th>LEAVE</th>
                        <th>TOTAL DAYS</th>
                        <th>SEM</th>
                      
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $select = "SELECT a.*, s.sem_name FROM tbl_attendance a 
                           INNER JOIN tbl_sem s ON a.sem_id = s.sem_id 
                           WHERE a.student_id = '$student_id'";
                $res = $Conn->query($select);
                if ($res && $res->num_rows > 0) {
                    while($data = $res->fetch_assoc())
                    {
                        $i++;
                        $classattended = $data['attendance_total'] - $data['attendance_leave'];
                        $percentage = ($data['attendance_total'] > 0) ? round(($classattended / $data['attendance_total']) * 100, 2) : 0;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($data['attendance_month']); ?></td>
                            <td><?php echo $percentage; ?>%</td>
                            <td><?php echo htmlspecialchars($data['attendance_leave']); ?></td>
                            <td><?php echo htmlspecialchars($data['attendance_total']); ?></td>
                            <td><?php echo htmlspecialchars($data['sem_name']); ?></td>
                            <!-- <td>
                                <a href="Attendance.php?did=<?php echo $data['attendance_id']; ?>&sid=<?php echo $student_id; ?>" class="btn-action">Delete</a>
                            </td> -->
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No attendance records available.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



</body>
</html>

<?php
include("Foot.php");
?>
