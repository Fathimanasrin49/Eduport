<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if ($_SESSION['tid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

// ====== FETCH REQUIRED DETAILS ======

// Get selected Main Exam
$SelIn = "SELECT * FROM tbl_mainexam WHERE mainexam_id='" . $_GET['mid'] . "'";
$resI = $Conn->query($SelIn);
$rowI = $resI->fetch_assoc();
$semId = $rowI['sem_id'];

// Get teacher + course details
$SelC = "SELECT * FROM tbl_teacher t 
         INNER JOIN tbl_class c ON t.class_id=c.class_id 
         INNER JOIN tbl_course cs ON cs.course_id=c.course_id 
         WHERE t.teacher_id='" . $_SESSION['tid'] . "'";
$resC = $Conn->query($SelC);
$rowC = $resC->fetch_assoc();
$courseId = $rowC['course_id'];

// ====== SAVE MARKS ======
if (isset($_POST['btn_submit'])) {
    foreach ($_POST['marks'] as $subjectId => $markData) {
        $mark = $markData['mark'];
        $total = $markData['total'];

        if ($mark !== '' && $total !== '') {
            // Check if record already exists
            $checkQry = "SELECT * FROM tbl_mainexamsub 
                         WHERE mainexam_id='" . $_GET['mid'] . "' 
                         AND subject_id='$subjectId'";
            $checkRes = $Conn->query($checkQry);

            if ($checkRes->num_rows > 0) {
                // Update existing record
                $updateQry = "UPDATE tbl_mainexamsub 
                              SET mainexamsub_mark='$mark', mainexamsub_total='$total' 
                              WHERE mainexam_id='" . $_GET['mid'] . "' 
                              AND subject_id='$subjectId'";
                $Conn->query($updateQry);
            } else {
                // Insert new record
                $insQry = "INSERT INTO tbl_mainexamsub(subject_id, mainexamsub_mark, mainexamsub_total, mainexam_id) 
                           VALUES('$subjectId','$mark','$total','" . $_GET['mid'] . "')";
                $Conn->query($insQry);
            }
        }
    }
    echo "<script>alert('Marks saved successfully'); window.location='MainExamSub.php?mid=" . $_GET['mid'] . "';</script>";
    exit();
}

// ====== FETCH ALL MARKS FOR LIST ======
$marksList = [];
$marksQry = "SELECT ms.*, s.subject_name FROM tbl_mainexamsub ms
             INNER JOIN tbl_subject s ON ms.subject_id = s.subject_id
             WHERE ms.mainexam_id='" . $_GET['mid'] . "' ORDER BY s.subject_name";
$marksRes = $Conn->query($marksQry);
while($m = $marksRes->fetch_assoc()){
    $marksList[] = $m;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport :: Main Exam Subject</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {background-color:#f0f4f7; font-family:'Poppins',sans-serif; padding:20px 0;}
.card {max-width:800px; margin:30px auto; padding:25px; border-radius:15px; background-color:#fff; box-shadow:0 6px 25px rgba(0,0,0,0.1);}
.card h2 {text-align:center; color:#4CAF50; margin-bottom:20px;}
input[type="text"] {width:100%; padding:8px; margin-top:5px; margin-bottom:5px; border-radius:5px; border:1px solid #ccc; text-align:center;}
input[type="text"]:focus {border-color:#4CAF50; box-shadow:0 0 6px rgba(76,175,80,0.3); outline:none;}
.btn-submit {background-color:#4CAF50; color:#fff; border:none; padding:10px 20px; border-radius:8px; transition:0.3s;}
.btn-submit:hover {background-color:#45a049; transform:translateY(-2px);}
.table-wrapper {max-width:900px; margin:30px auto; overflow-x:auto;}
.table th, .table td {text-align:center; vertical-align:middle;}
.table-hover tbody tr:hover {background-color:#e8f5e9; transition:0.3s;}
.btn-action {background-color:#ffc107; color:#000; padding:5px 10px; border-radius:5px; text-decoration:none;}
.btn-action:hover {background-color:#e0a800; color:#fff;}
</style>
</head>
<body>

<div class="card">
    <h2>Main Exam Marks Entry</h2>
    <form method="post">
        <div class="table-wrapper">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>SL.NO</th>
                        <th>Subject Name</th>
                        <th>Mark</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $subQry = "SELECT * FROM tbl_subject 
                           WHERE sem_id='$semId' AND course_id='$courseId' 
                           ORDER BY subject_name";
                $subRes = $Conn->query($subQry);

                while ($sub = $subRes->fetch_assoc()) {
                    $i++;
                    $subId = $sub['subject_id'];

                    // Get existing marks if already entered
                    $markRow = [];
                    foreach($marksList as $ml){
                        if($ml['subject_id'] == $subId){ $markRow = $ml; break; }
                    }
                    $mark = $markRow['mainexamsub_mark'] ?? '';
                    $total = $markRow['mainexamsub_total'] ?? '';

                    echo "<tr>
                            <td>$i</td>
                            <td>{$sub['subject_name']}</td>
                            <td><input type='text' name='marks[$subId][mark]' value='$mark' placeholder='Enter mark'></td>
                            <td><input type='text' name='marks[$subId][total]' value='$total' placeholder='Enter total'></td>
                          </tr>";
                }

                if ($i == 0) {
                    echo "<tr><td colspan='4' class='text-center text-muted'>No subjects found for this semester.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <input type="submit" name="btn_submit" class="btn-submit" value="Save Marks">
        </div>
    </form>
</div>

<!-- Existing Marks List -->
<div class="table-wrapper">
    <h2 class="text-center mt-4">Entered Marks List</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>SL.NO</th>
                <th>Subject</th>
                <th>Mark</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(count($marksList) > 0){
            $j = 0;
            foreach($marksList as $ml){
                $j++;
                echo "<tr>
                        <td>$j</td>
                        <td>{$ml['subject_name']}</td>
                        <td>{$ml['mainexamsub_mark']}</td>
                        <td>{$ml['mainexamsub_total']}</td>
                        <td>
                            <a href='MainExamSub.php?did={$ml['mainexamsub_id']}&mid=".$_GET['mid']."' class='btn-action' onclick=\"return confirm('Are you sure?');\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center text-muted'>No marks entered yet.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php include("Foot.php"); ?>
