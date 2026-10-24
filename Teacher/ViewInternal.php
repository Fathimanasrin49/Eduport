<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if ($_SESSION['tid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

// Get teacher class
$selt = "SELECT class_id FROM tbl_teacher WHERE teacher_id='" . $_SESSION['tid'] . "'";
$tres = $Conn->query($selt);
$datat = $tres->fetch_assoc();
$tclass = $datat['class_id'];

// Selected Semester
$sem_id = isset($_POST['sel_sem']) ? $_POST['sel_sem'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport :: Internal Mark Viewer</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {background-color:#f0f4f7; font-family:'Poppins',sans-serif; padding:20px;}
.table-wrapper {max-width:1100px; margin:30px auto; overflow-x:auto;}
.table-hover tbody tr:hover {background-color:#e8f5e9; transition:0.3s;}
</style>
</head>
<body>

<h2 class="text-center mb-4">INTERNAL MARKS</h2>

<!-- Semester Selection -->
<form method="post" class="mb-4 text-center">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <select class="form-select" name="sel_sem" id="sel_sem" required>
                <option value="">Select Semester</option>
                <?php 
                $semQuery = "SELECT * FROM tbl_sem";
                $semRes = $Conn->query($semQuery);
                while ($row = $semRes->fetch_assoc()) {
                    $selected = ($row["sem_id"] == $sem_id) ? 'selected' : '';
                    echo '<option value="' . $row["sem_id"] . '" ' . $selected . '>' . $row["sem_name"] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" name="btn_submit" class="btn btn-success w-100">Submit</button>
        </div>
    </div>
</form>

<div class="table-wrapper">
<table class="table table-bordered table-hover text-center">
<thead class="table-success">
<tr>
    <th>SL.NO</th>
    <th>Student Name</th>
    <th>Roll No</th>
<?php
$subjects = [];
if (!empty($sem_id)) {
    // Get subjects of this class for the selected sem
    $subQuery = "SELECT subject_id, subject_name 
                 FROM tbl_subject 
                 WHERE class_id = '$tclass' AND sem_id='$sem_id'
                 ORDER BY subject_name";
    $subRes = $Conn->query($subQuery);

    while ($row = $subRes->fetch_assoc()) {
        $subjects[$row['subject_id']] = $row['subject_name'];
        echo "<th>{$row['subject_name']}</th>";
    }
}
?>
</tr>
</thead>
<tbody>
<?php
if (!empty($sem_id)) {
    // Get students of this class
    $studentQuery = "SELECT student_id, student_name, student_rollno 
                     FROM tbl_student 
                     WHERE class_id='$tclass' 
                     ORDER BY student_rollno";
    $studentRes = $Conn->query($studentQuery);

    $i = 0;
    while ($stud = $studentRes->fetch_assoc()) {
        $i++;
        $sid = $stud['student_id'];

        // Fetch marks per subject for this student (only this sem)
        $markQuery = "SELECT sb.subject_id, sub.internalsub_mark, sub.internalsub_total
                      FROM tbl_internalexam e
                      INNER JOIN tbl_internalsub sub ON e.internalexam_id = sub.internalexam_id
                      INNER JOIN tbl_subject sb ON sb.subject_id = sub.subject_id
                      WHERE e.student_id = '$sid' 
                        AND sb.class_id='$tclass' 
                        AND sb.sem_id='$sem_id'";
        $markRes = $Conn->query($markQuery);

        $marks = [];
        while ($markRow = $markRes->fetch_assoc()) {
            $marks[$markRow['subject_id']] = $markRow['internalsub_mark'] . "/" . $markRow['internalsub_total'];
        }

        echo "<tr>
                <td>$i</td>
                <td>{$stud['student_name']}</td>
                <td>{$stud['student_rollno']}</td>";
        foreach ($subjects as $subId => $subName) {
            echo "<td>" . ($marks[$subId] ?? '-') . "</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='20'>Please select a semester to view marks.</td></tr>";
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
