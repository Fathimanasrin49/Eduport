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
<title>Eduport :: Internal Mark Viewer</title>
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
    max-width: 900px;
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
</style>
</head>
<body>

<div class="card">
    <h2>Internal Marks</h2>

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
                <button type="submit" name="btn_submit" class="btn btn-success w-100">Submit</button>
            </div>
        </div>
    </form>

    <!-- Internal Marks Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-success">
                <tr>
                    <th>SL.NO</th>
                    <th>COURSE</th>
                    <th>MARK</th>
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
                        s.internalsub_mark AS mark,
                        s.internalsub_total AS max_mark
                    FROM tbl_internalexam e
                    INNER JOIN tbl_internalsub s ON e.internalexam_id = s.internalexam_id
                    INNER JOIN tbl_subject sb ON sb.subject_id = s.subject_id
                    WHERE e.student_id = '$student_id'";

                if (!empty($sem_id)) {
                    $query .= " AND sb.sem_id = '$sem_id'";
                }

                $res = $Conn->query($query);

                if ($res && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo htmlspecialchars($row['subject_name']) ?></td>
                            <td><?php echo $row['mark'] ?></td>
                            <td><?php echo $row['max_mark'] ?></td>
                        </tr>
                        <?php 
                    }
                } else {
                    echo "<tr><td colspan='4'>No internal marks available for this student.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Student ID not provided.</td></tr>";
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
