<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");


// Insert Internal Exam
if (isset($_POST['btn_submit'])) {
    $studentname = $_POST['sel_student'];
    $semname = $_POST['sel_sem'];
    $insqry = "INSERT INTO tbl_internalexam(student_id, sem_id) VALUES('" . $studentname . "', '" . $semname . "')";
    if ($Conn->query($insqry)) {
        echo "<script>alert('Inserted successfully'); window.location='InternalExam.php';</script>";
    }
}

// Delete Internal Exam
if (isset($_GET["did"])) {
    $deleqry = "DELETE FROM tbl_internalexam WHERE internalexam_id='" . $_GET["did"] . "'";
    if ($Conn->query($deleqry)) {
        echo "<script>alert('Deleted successfully'); window.location='InternalExam.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Internal Exam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f0f4f7;
    font-family: 'Poppins', sans-serif;
    padding: 20px 0;
}
.card {
    max-width: 600px;
    margin: 30px auto;
    padding: 25px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
}
.card h2 {
    text-align: center;
    color: #4CAF50;
    margin-bottom: 20px;
}
.card select, .card input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    transition: 0.3s;
}
.card select:focus, .card input:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
    outline: none;
}
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

<!-- Internal Exam Form -->
<div class="card">
    <h2>Add Internal Exam</h2>
    <form method="post">
        <label for="sel_student">Select Student</label>
        <select name="sel_student" id="sel_student" required>
            <option value="">--Select Student--</option>
            <?php
            $select = "SELECT * FROM tbl_student s INNER JOIN tbl_class c ON s.class_id=c.class_id WHERE s.class_id='" . $_SESSION['cid'] . "'";
            $res = $Conn->query($select);
            while ($data = $res->fetch_assoc()) {
                echo "<option value='" . $data["student_id"] . "'>" . $data["student_name"] . "</option>";
            }
            ?>
        </select>

        <label for="sel_sem">Select Semester</label>
        <select name="sel_sem" id="sel_sem" required>
            <option value="">--Select Semester--</option>
            <?php
            $select = "SELECT * FROM tbl_sem";
            $res = $Conn->query($select);
            while ($data = $res->fetch_assoc()) {
                echo "<option value='" . $data["sem_id"] . "'>" . $data["sem_name"] . "</option>";
            }
            ?>
        </select>

        <div class="text-center">
            <input type="submit" name="btn_submit" value="Submit" />
        </div>
    </form>
</div>

<!-- Internal Exam List Table -->
<div class="table-wrapper">
    <h2 class="text-center mt-4">Internal Exam List</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>SL.NO</th>
                <th>Student Name</th>
                <th>Semester Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        $select = "SELECT i.*, s.student_name, c.sem_name 
                   FROM tbl_internalexam i 
                   INNER JOIN tbl_student s ON i.student_id=s.student_id 
                   INNER JOIN tbl_sem c ON i.sem_id=c.sem_id 
                   INNER JOIN tbl_class cs ON s.class_id=cs.class_id 
                   WHERE s.class_id='" . $_SESSION['cid'] . "'";
        $res = $Conn->query($select);
        while ($data = $res->fetch_assoc()) {
            $i++;
            echo "<tr>
                    <td>$i</td>
                    <td>" . htmlspecialchars($data['student_name']) . "</td>
                    <td>" . htmlspecialchars($data['sem_name']) . "</td>
                    <td>
                        <a href='InternalExam.php?did=" . $data['internalexam_id'] . "' class='btn-action'>Delete</a>
                        <a href='InternalSubject.php?sid=" . $data['internalexam_id'] . "' class='btn-action'>Subject</a>
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
