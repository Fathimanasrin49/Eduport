<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if ($_SESSION['tid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Eduport:: View Leave</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    h1 { margin: 20px 0; }
    .table-wrapper { overflow-x: auto; margin: auto; width: 95%; }
</style>
</head>
<body>
<h1 class="text-center">VIEW LEAVE</h1>

<div class="container mb-4">
    <form method="post" class="row g-3 align-items-center justify-content-center">
        <div class="col-auto">
            <label for="month" class="col-form-label">Select Month:</label>
        </div>
        <div class="col-auto">
            <select name="month" id="month" class="form-select">
                <option value="">--All--</option>
                <?php
                for ($m = 1; $m <= 12; $m++) {
                    $monthName = date("F", mktime(0,0,0,$m,1));
                    $selected = (isset($_POST['month']) && $_POST['month'] == $m) ? "selected" : "";
                    echo "<option value='$m' $selected>$monthName</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" name="btnSearch" class="btn btn-primary">View</button>
        </div>
    </form>
</div>

<div class="table-wrapper">
    <table class="table table-bordered table-hover text-center">
        <thead class="table-success">
            <tr>
                <th>SL.NO</th>
                <th>STUDENT NAME</th>
                <th>REASON</th>
                <th>DATE</th>
                <th>FOR DATE</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        $monthFilter = "";
        if (isset($_POST['month']) && $_POST['month'] != "") {
            $monthFilter = " AND MONTH(l.leave_date)='" . $_POST['month'] . "'";
        }

        $select = "SELECT * 
                   FROM tbl_leave l
                   INNER JOIN tbl_student s ON s.student_id = l.student_id
                   INNER JOIN tbl_teacher t ON t.class_id = s.class_id
                   WHERE t.teacher_id='" . $_SESSION['tid'] . "' $monthFilter
                   ORDER BY l.leave_date DESC";

        $res = $Conn->query($select);
        if ($res->num_rows > 0) {
            while ($data = $res->fetch_assoc()) {
                $i++;
                echo "<tr>
                        <td>$i</td>
                        <td>{$data['student_name']}</td>
                        <td>{$data['leave_reason']}</td>
                        <td>{$data['leave_date']}</td>
                        <td>{$data['leave_fordate']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No leaves found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include("Foot.php");
?>
