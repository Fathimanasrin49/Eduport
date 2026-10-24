<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Eduport :: View Report</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f9f7;
        margin: 0;
        padding: 0;
    }
    h1 {
        text-align: center;
        color: #3b3b3b;
        margin: 30px 0;
        text-transform: uppercase;
    }
    table {
        border-collapse: collapse;
        margin: 0 auto;
        width: 90%;
        max-width: 1000px;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        font-size: 14px;
    }
    th {
        background: #4CAF50;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    tr:hover {
        background: #eafaea;
        transition: 0.3s;
    }
    a {
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }
    a:hover {
        color: #0056b3;
    }
    /* Footer */
    .footer-area {
        background: #795548; /* brown */
        padding: 20px 0;
        text-align: center;
        color: white;
        position: relative;
        bottom: 0;
        width: 100%;
        margin-top: 40px;
    }
    .footer-social a {
        color: white;
        margin: 0 8px;
        font-size: 18px;
        transition: 0.3s;
    }
    .footer-social a:hover {
        color: #d7ccc8;
    }
</style>
</head>

<body>
<h1>Report List</h1>
<form id="form1" name="form1" method="post" action="">
  <table>
    <tr>
      <th>SL.NO</th>
      <th>Name</th>
      <th>Email</th>
      <th>Contact</th>
      <th>Content</th>
      <th>Reply</th>
      <th>Action</th>
    </tr>
    <?php
    $i=0;
    $select="select * from tbl_report r inner join tbl_parent p on r.parent_id=p.parent_id";
    $res=$Conn->query($select);
    while($data=$res->fetch_assoc())
    {
        $i++;
    ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data['parent_name'] ?></td>
      <td><?php echo $data['parent_email'] ?></td> 
      <td><?php echo $data['parent_contact'] ?></td>
      <td><?php echo $data['report_details'] ?></td>
      <td>
        <?php 
            if($data['report_reply']=="") {
                echo "<span style='color:orange;font-weight:bold;'>Pending</span>";
            } else {
                echo $data['report_reply'];
            }
        ?>
      </td>
      <td>
        <?php 
            if($data['report_status']==0) {
                ?>
                <a href="ReplyReport.php?rid=<?php echo $data['report_id'] ?>">Reply</a>
                <?php
            } else {
                echo "<span style='color:green;font-weight:bold;'>Already Replied</span>";
            }
        ?>
      </td>
    </tr>
    <?php
    }
    ?>
  </table>
</form>
</body>
</html>
<?php
include("Foot.php");
?>
