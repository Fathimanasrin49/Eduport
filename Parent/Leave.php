<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if(!isset($_SESSION['uid']) || $_SESSION['uid']==""){
    header('location:../Guest/Login.php');
    exit();
}

$student_id = isset($_GET['sid']) ? $_GET['sid'] : '';

if(isset($_POST['btn_submit'])) {
    $reason = $_POST['txt_reason'];
    $fordate = $_POST['txt_date'];
    $insqry = "INSERT INTO tbl_leave(leave_reason, leave_fordate, leave_date, student_id, parent_id)
               VALUES('$reason', '$fordate', CURDATE(), '$student_id', '".$_SESSION['uid']."')";
    
    if($Conn->query($insqry)) {
        echo "<script>
                alert('Inserted');
                window.location='Leave.php?sid=$student_id';
              </script>";
    }
}

if(isset($_GET['did'])) {
    $deleqry = "DELETE FROM tbl_leave WHERE leave_id='".$_GET['did']."'";
    if($Conn->query($deleqry)) {
        echo "<script>
                alert('Deleted');
                window.location='Leave.php?sid=$student_id';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport :: Leave Form</title>
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
textarea {
    resize: none;
}
</style>
</head>
<body>

<div class="card">
    <h2>Leave Form</h2>
    <form method="post" class="mb-4">
        <div class="mb-3">
            <label for="txt_reason" class="form-label">Reason</label>
            <textarea class="form-control" name="txt_reason" id="txt_reason" rows="5" placeholder="Enter the leave reason" required></textarea>
        </div>
        <div class="mb-3">
            <label for="txt_date" class="form-label">For Date</label>
            <input type="date" class="form-control" name="txt_date" min="<?php echo date('Y-m-d')?>" id="txt_date" required>
        </div>
        <div class="text-center">
            <button type="submit" name="btn_submit" class="btn btn-success">Submit</button>
        </div>
    </form>

    <h2>Leave Details</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-success">
                <tr>
                    <th>SL.NO</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>For Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            $select = "SELECT * FROM tbl_leave WHERE parent_id='".$_SESSION['uid']."' AND student_id='$student_id'";
            $res = $Conn->query($select);

            if($res && $res->num_rows > 0){
                while($data = $res->fetch_assoc()){
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($data['leave_reason']); ?></td>
                        <td><?php echo $data['leave_date']; ?></td>
                        <td><?php echo $data['leave_fordate']; ?></td>
                        <td>
                            <a href="Leave.php?did=<?php echo $data['leave_id']; ?>&sid=<?php echo $student_id; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="5" class="text-center text-muted">No leave records found.</td></tr>';
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
