<?php
include("../Assets/Connection/Connection.php");
session_start();
if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eduport:: view complaint</title>
</head>

<body>
<h1 align="center"> COMPLAINT LIST</h1>
<form id="form1" name="form1" method="post" action="">
  <table width="371" height="120" border="1" align="center">
    <tr>
      <td>SL.NO</td>
      <td>Name</td>
      <td>Email</td>
      <td>Contact</td>
      <td>Title </td>
      <td>Content</td>
      <td>Reply</td>
      <td>Action</td>
    </tr>
    <?php
	$i=0;
	$select="select * from tbl_complaint c inner join tbl_parent p on c.parent_id=p.parent_id";

	$res=$Conn->query($select);
	while($data=$res->fetch_assoc())
	{
		$i++;
	?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data['parent_name'] ?></td>
      <td><?php echo $data['parent_email'] ?></td> 
      <td><?php echo $data['parent_contact'] ?> </td>
      <td><?php echo $data['complaint_title'] ?></td>
      <td><?php echo $data['complaint_content'] ?></td>
      <td><?php echo $data['complaint_reply']?> </td>
      <td>
      <?php
	  if($data['complaint_status']==0){
		  ?>
		  
		   <a href="Reply.php?cid=<?php echo $data['complaint_id'] ?>">Reply</a> <?php
	  }
	  else
	  {
		  echo "replied";
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