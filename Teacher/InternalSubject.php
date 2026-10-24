<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
    exit();
}

// ====== FETCH EXAM AND TEACHER INFO ======
$SelIn="SELECT * FROM tbl_internalexam WHERE internalexam_id='".$_GET['sid']."'";
$resI=$Conn->query($SelIn);
$rowI=$resI->fetch_assoc();
$semId=$rowI['sem_id'];

$SelC="SELECT * FROM tbl_teacher t 
       INNER JOIN tbl_class c ON t.class_id=c.class_id 
       INNER JOIN tbl_course cs ON cs.course_id=c.course_id 
       WHERE t.teacher_id='".$_SESSION['tid']."'";
$resC=$Conn->query($SelC);
$rowC=$resC->fetch_assoc();
$courseId=$rowC['course_id'];

// ====== SAVE MARKS ======
if(isset($_POST['btn_submit'])){
    foreach($_POST['marks'] as $subjectId => $markData){
        $mark = $markData['mark'];
        $total = $markData['total'];

        if($mark !== '' && $total !== ''){
            // Check if record exists
            $checkQry = "SELECT * FROM tbl_internalsub 
                         WHERE internalexam_id='".$_GET['sid']."' 
                         AND subject_id='$subjectId'";
            $checkRes = $Conn->query($checkQry);

            if($checkRes->num_rows > 0){
                $updateQry = "UPDATE tbl_internalsub 
                              SET internalsub_mark='$mark', internalsub_total='$total' 
                              WHERE internalexam_id='".$_GET['sid']."' 
                              AND subject_id='$subjectId'";
                $Conn->query($updateQry);
            } else {
                $insQry = "INSERT INTO tbl_internalsub(subject_id, internalsub_mark, internalsub_total, internalexam_id) 
                           VALUES('$subjectId','$mark','$total','".$_GET['sid']."')";
                $Conn->query($insQry);
            }
        }
    }
    echo "<script>alert('Marks saved successfully'); window.location='InternalSubject.php?sid=".$_GET['sid']."';</script>";
    exit();
}

// ====== FETCH EXISTING MARKS ======
$marksList = [];
$marksQry = "SELECT i.*, s.subject_name FROM tbl_internalsub i
             INNER JOIN tbl_subject s ON i.subject_id=s.subject_id
             WHERE i.internalexam_id='".$_GET['sid']."' ORDER BY s.subject_name";
$marksRes = $Conn->query($marksQry);
while($m = $marksRes->fetch_assoc()){
    $marksList[$m['subject_id']] = $m; // keyed by subject_id for quick lookup
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport :: Internal Exam Subject</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {background-color:#f0f4f7; font-family:'Poppins',sans-serif; padding:20px 0;}
.card {max-width:800px; margin:30px auto; padding:25px; border-radius:15px; background-color:#fff; box-shadow:0 6px 25px rgba(0,0,0,0.1);}
.card h2 {text-align:center; color:#4CAF50; margin-bottom:20px;}
input[type="text"], input[type="number"] {width:100%; padding:8px; margin-top:5px; margin-bottom:5px; border-radius:5px; border:1px solid #ccc; text-align:center;}
input[type="text"]:focus, input[type="number"]:focus {border-color:#4CAF50; box-shadow:0 0 6px rgba(76,175,80,0.3); outline:none;}
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

<!-- Internal Marks Entry Form -->
<div class="card">
    <h2>Internal Exam Marks Entry</h2>
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

                while($sub = $subRes->fetch_assoc()){
                    $i++;
                    $subId = $sub['subject_id'];

                    $markRow = $marksList[$subId] ?? ['internalsub_mark'=>'', 'internalsub_total'=>''];

                    echo "<tr>
                            <td>$i</td>
                            <td>{$sub['subject_name']}</td>
                            <td><input type='number' name='marks[$subId][mark]' value='{$markRow['internalsub_mark']}' placeholder='Enter mark'></td>
                            <td><input type='number' name='marks[$subId][total]' value='{$markRow['internalsub_total']}' placeholder='Enter total'></td>
                          </tr>";
                }

                if($i==0){
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

<!-- Internal Marks List -->
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
                        <td>{$ml['internalsub_mark']}</td>
                        <td>{$ml['internalsub_total']}</td>
                        <td>
                            <a href='InternalSubject.php?did={$ml['internalsub_id']}&sid=".$_GET['sid']."' class='btn-action' onclick=\"return confirm('Are you sure?');\">Delete</a>
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
