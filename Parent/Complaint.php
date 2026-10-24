<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if (!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

// Insert complaint
if(isset($_POST['btn_submit']))
{
    $complainttitle = $_POST['txt_title'];
    $complaintcontent = $_POST['txt_content'];

    $insqry = "INSERT INTO tbl_complaint(complaint_title, complaint_content, parent_id) 
               VALUES('$complainttitle', '$complaintcontent', '".$_SESSION['uid']."')";
    if($Conn->query($insqry))
    {
        echo "<script>alert('Complaint Submitted Successfully'); window.location='Complaint.php';</script>";
    }
}

// Delete complaint
if(isset($_GET["did"]))
{
    $deleqry = "DELETE FROM tbl_complaint WHERE complaint_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Complaint Deleted'); window.location='Complaint.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Complaint Form</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
}
.card {
    max-width: 700px;
    margin: 40px auto;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    background-color: #fff;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #4CAF50;
}
.table th, .table td {
    vertical-align: middle !important;
    text-align: center;
}
.btn-action {
    background-color: #ffc107;
    color: #000;
    border-radius: 5px;
    padding: 5px 10px;
    text-decoration: none;
}
.btn-action:hover {
    background-color: #e0a800;
    color: #fff;
}
textarea.form-control {
    resize: none;
}
</style>
</head>
<body>

<div class="card">
    <h2>Submit Complaint</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="txt_title" class="form-label">Title</label>
            <input type="text" class="form-control" name="txt_title" id="txt_title" placeholder="Title for your complaint" required>
        </div>
        <div class="mb-3">
            <label for="txt_content" class="form-label">Content</label>
            <textarea class="form-control" name="txt_content" id="txt_content" rows="4" placeholder="Enter your complaint here..." required></textarea>
        </div>
        <div class="d-grid">
            <input type="submit" name="btn_submit" class="btn btn-success" value="Submit Complaint">
        </div>
    </form>
</div>

<div class="card mt-4">
    <h2>My Complaints</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>SL.NO</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Reply</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            $select = "SELECT * FROM tbl_complaint WHERE parent_id='".$_SESSION['uid']."'";
            $res = $Conn->query($select);
            while($data = $res->fetch_assoc())
            {
                $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($data['complaint_title']); ?></td>
                    <td><?php echo htmlspecialchars($data['complaint_content']); ?></td>
                    <td><?php echo ($data['complaint_reply'] == "") ? "Pending" : htmlspecialchars($data['complaint_reply']); ?></td>
                    <td>
                        <a href="Complaint.php?did=<?php echo $data['complaint_id']; ?>" class="btn-action">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
