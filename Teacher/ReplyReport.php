<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
}

$select="select * from tbl_report where report_id='".$_GET['rid']."'";
$res=$Conn->query($select);
$data=$res->fetch_assoc();

if(isset($_POST['btn_submit']))
{
    $reportreply=$_POST['txt_reply'];

    $updateqry="update tbl_report set report_reply='".$reportreply."', report_status=1 where report_id='".$_GET['rid']."'";
    if($Conn->query($updateqry))
    {
        ?>
        <script>
            alert("Reply Updated Successfully");
            window.location="ViewReport.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Eduport :: Reply Report</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f9f9fc;
        margin: 0;
        padding: 0;
    }
    h1 {
        text-align: center;
        margin: 30px 0;
        color: #333;
    }
    .card {
        width: 500px;
        margin: 20px auto;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    }
    .card label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
    }
    .card .content-box {
        padding: 12px;
        background: #f1f1f1;
        border-radius: 6px;
        margin-bottom: 15px;
    }
    input[type="text"] {
        width: 95%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 15px;
    }
    input[type="submit"] {
        background: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }
    input[type="submit"]:hover {
        background: #45a049;
    }
    .back-link {
        text-align: center;
        margin-top: 15px;
    }
    .back-link a {
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }
    .back-link a:hover {
        color: #0056b3;
    }
</style>
</head>
<body>

<h1>Reply Report</h1>

<div class="card">
    <form id="form1" name="form1" method="post" action="">
        <label>Content</label>
        <div class="content-box"><?php echo $data['report_details']; ?></div>

        <label for="txt_reply">Reply</label>
        <input type="text" name="txt_reply" id="txt_reply" placeholder="Enter your reply..." required/>

        <div style="text-align:center;">
            <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        </div>
    </form>
</div>

<div class="back-link">
    <a href="ViewReport.php">⬅ Back to Report List</a>
</div>

</body>
</html>
<?php
include("Foot.php");
?>
