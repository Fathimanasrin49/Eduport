<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if(!isset($_SESSION['uid']) || $_SESSION['uid']==""){
    header('location:../Guest/Login.php');
    exit();
}

if(isset($_POST['btn_submit'])) {
    $reportdetails = $_POST['txt_content'];
    $insqry = "INSERT INTO tbl_report(report_details, teacher_id, parent_id) 
               VALUES('".$reportdetails."', '".$_SESSION['tid']."', '".$_SESSION['uid']."')";
    if($Conn->query($insqry)) {
        echo "<script>
                alert('Inserted');
                window.location='ReportParent.php';
              </script>";
    }
}

if(isset($_GET["did"])) {
    $deleqry = "DELETE FROM tbl_report WHERE report_id='".$_GET["did"]."'";
    if($Conn->query($deleqry)) {
        echo "<script>
                alert('Deleted');
                window.location='ReportParent.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Eduport :: Report Form</title>
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
.no-data {
    text-align: center;
    color: #888;
}
</style>
</head>
<body>

<div class="card">
    <h2>Report Form</h2>

    <!-- Report Submission Form -->
    <form method="post" class="mb-4">
        <div class="mb-3">
            <textarea class="form-control" name="txt_content" rows="5" placeholder="Enter Your Report Here..." required></textarea>
        </div>
        <div class="text-center">
            <button type="submit" name="btn_submit" class="btn btn-success">Submit</button>
        </div>
    </form>

    <h2>View Reports</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-success">
                <tr>
                    <th>SL.NO</th>
                    <th>Details</th>
                    <th>Reply</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            $select = "SELECT * FROM tbl_report WHERE parent_id='".$_SESSION['uid']."'";
            $res = $Conn->query($select);

            if($res && $res->num_rows > 0) {
                while($data = $res->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo htmlspecialchars($data['report_details']) ?></td>
                        <td><?php echo ($data['report_reply'] == "") ? "Pending" : htmlspecialchars($data['report_reply']); ?></td>
                        <td>
                            <a href="ReportParent.php?did=<?php echo $data['report_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="4" class="no-data">No reports found.</td></tr>';
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
