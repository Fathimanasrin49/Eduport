<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
    exit();
}

if(isset($_POST['btn_submit']))
{
    $month=$_POST['txt_month'];
    $leave=$_POST['txt_leave'];
    $total=$_POST['txt_total'];
    $sem=$_POST['txt_sem'];

    $insqry=("INSERT INTO tbl_attendance(attendance_month,attendance_leave,attendance_total,sem_id,student_id)
               VALUES('".$month."','".$leave."','".$total."','".$sem."','".$_GET['sid']."')");
    if($Conn->query($insqry))
    {
        ?>
        <script>
            alert("Inserted Successfully");
            window.location="Attendance.php?sid=<?php echo $_GET['sid']?>";
        </script>
        <?php
    }
}

if(isset($_GET["did"]))
{
    $deleqry="DELETE FROM tbl_attendance WHERE attendance_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        ?>
        <script>
            alert("Deleted Successfully");
            window.location="Attendance.php?sid=<?php echo $_GET['sid']?>";
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport::Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f0f4f7;
    font-family: 'Poppins', sans-serif;
    padding: 20px 0;
}

/* Floating card animation */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

.card {
    max-width: 600px;
    margin: 20px auto;
    padding: 25px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    animation: float 6s ease-in-out infinite;
}

/* Form Inputs */
.card input, .card select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    transition: 0.3s;
}
.card input:focus, .card select:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
    outline: none;
}

/* Submit Button */
.card input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}
.card input[type="submit"]:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

/* Table Styling */
.table-wrapper {
    max-width: 900px;
    margin: 30px auto;
    overflow-x: auto;
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
    padding: 5px 12px;
    border-radius: 5px;
    text-decoration: none;
}
.btn-action:hover {
    background-color: #e0a800;
    color: #fff;
}
</style>
</head>
<body>

<!-- Attendance Form -->
<div class="card">
    <h2 class="text-center">Add Attendance</h2>
    <form method="post">
        <label for="txt_month">Month</label>
        <select name="txt_month" id="txt_month" required>
            <option value="">--Select Month--</option>
            <?php
            $months = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
            foreach($months as $m){
                echo "<option value='$m'>$m</option>";
            }
            ?>
        </select>

        <label for="txt_leave">Leave No.</label>
        <input type="number" name="txt_leave" id="txt_leave" placeholder="Enter number of leave taken" required />

        <label for="txt_total">Total Working Days</label>
        <input type="number" name="txt_total" id="txt_total" placeholder="Enter number of total working days" required />

        <label for="txt_sem">Semester</label>
        <select name="txt_sem" id="txt_sem" required>
            <option value="">Select Semester</option>
            <?php
            $select='SELECT * FROM tbl_sem';
            $res=$Conn->query($select);
            while($data=$res->fetch_assoc())
            {
                echo "<option value='".$data["sem_id"]."'>".$data["sem_name"]."</option>";
            }
            ?>
        </select>

        <div class="text-center">
            <input type="submit" name="btn_submit" value="Submit" />
        </div>
    </form>
</div>

<!-- Attendance List Table -->
<div class="table-wrapper">
    <h2 class="text-center mt-4">Attendance List</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>SL.NO</th>
                <th>Month</th>
                <th>Percentage</th>
                <th>Leave</th>
                <th>Total Days</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        $select="SELECT a.*, s.sem_name FROM tbl_attendance a 
                 INNER JOIN tbl_sem s ON a.sem_id=s.sem_id 
                 WHERE a.student_id='".$_GET['sid']."'";
        $res=$Conn->query($select);
        while($data=$res->fetch_assoc())
        {
            $i++;
            $classattended=$data['attendance_total'] - $data['attendance_leave'];
            $percentage=($data['attendance_total']>0)?round(($classattended/$data['attendance_total'])*100,2):0;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo htmlspecialchars($data['attendance_month']); ?></td>
                <td><?php echo $percentage; ?>%</td>
                <td><?php echo htmlspecialchars($data['attendance_leave']); ?></td>
                <td><?php echo htmlspecialchars($data['attendance_total']); ?></td>
                <td><?php echo htmlspecialchars($data['sem_name']); ?></td>
                <td>
                    <a href="Attendance.php?did=<?php echo $data['attendance_id']?>&sid=<?php echo $_GET['sid']?>" class="btn-action">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
