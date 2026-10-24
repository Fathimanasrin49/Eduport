<?php
include("../Assets/Connection/Connection.php");
session_start();
if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

?>
 <?php
	$i=0;
    $select="select * from tbl_complaint where complaint_id='".$_GET['cid']."'";
	$res=$Conn->query($select);
	$data=$res->fetch_assoc();


	if(isset($_POST['btn_submit']))
	{
		$complaintreply=$_POST['txt_reply'];
		

$updateqry="update tbl_complaint set complaint_reply='".$complaintreply."' , complaint_status=1 where complaint_id='".$_GET['cid']."'";
		if($Conn->query($updateqry))
		{
			?>
            <script>
				alert("updated");
				window.location="ViewComplaint.php";
			</script>
            <?php
		}

	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eduport::replycomplaint</title>
</head>

<body>
<h1 align="center">REPLY</h1>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <table width="227" height="227" border="1" align="center">
      <tr>
        <td width="109">Title</td>
        <td width="102"> <?php echo $data['complaint_title']; ?></td>
      </tr>
      <tr>
        <td height="49">Content</td>
        <td width="102"><?php echo $data['complaint_content']; ?></td>
      </tr>
      <tr>
        <td>Reply</td>
        <td><label for="txt_reply"></label>
        <input type="text" name="txt_reply" id="txt_reply" required placeholder="Enter complaint reply"/></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        </div></td>
      </tr>
      </table>
  </div>
</form>
</body>
</html>