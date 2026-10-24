<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

$student_id = isset($_GET['sid']) ? $_GET['sid'] : null;
$sem_id = isset($_POST['sel_sem']) ? $_POST['sel_sem'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Main Exam Mark Viewer</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    padding: 20px 0;
}
h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #4CAF50;
}
.card {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}
.table-hover tbody tr:hover {
    background-color: #e8f5e9;
    transition: 0.3s;
}
.no-data {
    text-align: center;
    color: #888;
}
</style>
</head>
<body>

<div class="card">
    <h2>Main Exam Marks</h2>

    <!-- Semester Selection Form -->
    <form method="post" class="mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-4">
                <select class="form-select" name="sel_sem" id="sel_sem" required>
                    <option value="">Select Semester</option>
                    <?php 
                    $select = 'SELECT * FROM tbl_sem';
                    $res = $Conn->query($select);
                    while ($data = $res->fetch_assoc()) {
                        $selected = ($data["sem_id"] == $sem_id) ? 'selected' : '';
                        echo '<option value="' . $data["sem_id"] . '" ' . $selected . '>' . $data["sem_name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Submit</button>
            </div>
        </div>
    </form>

    <!-- Marks Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-success">
                <tr>
                    <th rowspan="2">SL.NO</th>
                    <th rowspan="2">COURSE</th>
                    <th colspan="2">EXTERNAL</th>
                    <th colspan="2">INTERNAL</th>
                    <th rowspan="2">TOTAL</th>
                    <th rowspan="2">MAX</th>
                    <th rowspan="2">GRADE</th>
                    <th rowspan="2">RESULT</th>
                </tr>
                <tr>
                    <th>ESA</th>
                    <th>MAX</th>
                    <th>ISA</th>
                    <th>MAX</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if ($student_id) {
                $i = 0;
                $query = "
                    SELECT 
                        sb.subject_name,
                        m.mainexamsub_mark AS esa_mark,
                        m.mainexamsub_total AS esa_max,
                        s.internalsub_mark AS isa_mark,
                        s.internalsub_total AS isa_max,
                        (m.mainexamsub_mark + s.internalsub_mark) AS total,
                        (m.mainexamsub_total + s.internalsub_total) AS total_max,
                        CASE 
                            WHEN (m.mainexamsub_mark + s.internalsub_mark) >= 90 THEN 'A+'
                            WHEN (m.mainexamsub_mark + s.internalsub_mark) >= 80 THEN 'A'
                            WHEN (m.mainexamsub_mark + s.internalsub_mark) >= 70 THEN 'B+'
                            WHEN (m.mainexamsub_mark + s.internalsub_mark) >= 60 THEN 'B'
                            WHEN (m.mainexamsub_mark + s.internalsub_mark) >= 50 THEN 'C'
                            ELSE 'F'
                        END AS grade,
                        CASE 
                            WHEN (m.mainexamsub_mark + s.internalsub_mark) >= 50 THEN 'PASS'
                            ELSE 'FAIL'
                        END AS result
                    FROM tbl_mainexam e
                    INNER JOIN tbl_mainexamsub m ON e.mainexam_id = m.mainexam_id
                    INNER JOIN tbl_internalexam i ON e.student_id = i.student_id AND e.sem_id = i.sem_id
                    INNER JOIN tbl_internalsub s ON i.internalexam_id = s.internalexam_id AND m.subject_id = s.subject_id
                    INNER JOIN tbl_subject sb ON sb.subject_id = m.subject_id
                    WHERE e.student_id = '$student_id'";

                if (!empty($sem_id)) {
                    $query .= " AND e.sem_id = '$sem_id'";
                }

                $res = $Conn->query($query);

                if ($res && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo htmlspecialchars($row['subject_name']) ?></td>
                            <td><?php echo $row['esa_mark'] ?></td>
                            <td><?php echo $row['esa_max'] ?></td>
                            <td><?php echo $row['isa_mark'] ?></td>
                            <td><?php echo $row['isa_max'] ?></td>
                            <td><?php echo $row['total'] ?></td>
                            <td><?php echo $row['total_max'] ?></td>
                            <td><?php echo $row['grade'] ?></td>
                            <td><?php echo $row['result'] ?></td>
                        </tr>
                        <?php 
                    }
                } else {
                    echo "<tr><td colspan='10' class='no-data'>No marks available for this student.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='no-data'>Student ID not provided.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
