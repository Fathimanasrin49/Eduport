<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if ($_SESSION['tid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

// Get teacher's class
$selt = "SELECT class_id FROM tbl_teacher WHERE teacher_id='" . $_SESSION['tid'] . "'";
$tres = $Conn->query($selt);
$datat = $tres->fetch_assoc();
$tclass = $datat['class_id'];

// Selected Semester
$sem_id = isset($_POST['sel_sem']) ? $_POST['sel_sem'] : '';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Eduport::Main Exam Mark Viewer</title>
<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    h1 { margin: 20px 0; }
    body {background:#f7f9fb; font-family:'Poppins', sans-serif;}
    .table-wrapper { overflow-x: auto; margin: auto; width: 95%; }
</style>
</head>
<body>
<h1 class="text-center">MAIN EXAM MARK LIST</h1>

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
            <button type="submit" name="btn_submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </div>
</form>

<div class="table-wrapper">
<?php
if (!empty($sem_id)) {

    // Fetch subjects for this class & semester
    $subQuery = "SELECT subject_id, subject_name 
                 FROM tbl_subject 
                 WHERE class_id='$tclass' AND sem_id='$sem_id'
                 ORDER BY subject_name";
    $subRes = $Conn->query($subQuery);

    $subjects = [];
    while ($row = $subRes->fetch_assoc()) {
        $subjects[$row['subject_id']] = $row['subject_name'];
    }

    // Table header
    echo '<table class="table table-bordered table-hover text-center">';
    echo '<thead class="table-success">
            <tr>
                <th>SL.NO</th>
                <th>STUDENT NAME</th>
                <th>ROLL NO</th>';
    foreach ($subjects as $subName) {
        echo "<th>$subName</th>";
    }
    echo '</tr></thead><tbody>';

    // Fetch students of this class
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
        $markQuery = "SELECT s.subject_id, ms.mainexamsub_mark, ms.mainexamsub_total
                      FROM tbl_mainexam m
                      INNER JOIN tbl_mainexamsub ms ON m.mainexam_id = ms.mainexam_id
                      INNER JOIN tbl_subject s ON s.subject_id = ms.subject_id
                      WHERE m.student_id='$sid' 
                        AND s.class_id='$tclass' 
                        AND s.sem_id='$sem_id'";
        $markRes = $Conn->query($markQuery);

        $marks = [];
        while ($markRow = $markRes->fetch_assoc()) {
            $marks[$markRow['subject_id']] = $markRow['mainexamsub_mark'] . "/" . $markRow['mainexamsub_total'];
        }

        // Print row
        echo "<tr>
                <td>$i</td>
                <td>{$stud['student_name']}</td>
                <td>{$stud['student_rollno']}</td>";
        foreach ($subjects as $subId => $subName) {
            echo "<td>" . ($marks[$subId] ?? '-') . "</td>";
        }
        echo "</tr>";
    }

    echo '</tbody></table>';
} else {
    echo "<div class='alert alert-info text-center'>Please select a semester to view marks.</div>";
}
?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include("Foot.php");
?>
