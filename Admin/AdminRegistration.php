<?php
include("../Assets/Connection/Connection.php");
session_start();
if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

$admin_id="";
$admin_name="";
$admin_email="";
$admin_password="";
$hid="";
	if(isset($_POST['btn_submit']))
	{
		$adminname=$_POST['txt_name'];
		$adminemail=$_POST['txt_email'];
		$adminpassword=$_POST['txt_password'];
		$hid=$_POST['txt_hidden'];
	if($hid=="")
	{
		$insqry=("insert into tbl_admin(admin_name,admin_email,admin_password) values('".$adminname."','".$adminemail."','".$adminpassword."')");
		
		if($Conn->query($insqry))
		{
			?>
        	 <script>
				alert("INSERTED");
				window.location="AdminRegistration.php";
			</script>
            <?php
		}
	}
	
	else
	{
		$updateqry="update tbl_admin set admin_name='".$adminname."' , admin_email='".$adminemail."' , admin_password='".$adminpassword."' where admin_id='".$hid."'";
		if($Conn->query($updateqry))
		{
			?>
            <script>
				alert("updated");
				window.location="AdminRegistration.php";
			</script>
            <?php
			
		}
	}
}
		if(isset($_GET['eid']))
{
	$selectAdmin="select * from tbl_admin where admin_id='".$_GET["eid"]."'";
		$data_Cat=$Conn->query($selectAdmin);
			$row=$data_Cat->fetch_assoc();
			$admin_id=$row['admin_id'];
			$admin_name=$row['admin_name'];
			$admin_email=$row['admin_email'];
			$admin_password=$row['admin_password'];
}
	if(isset($_GET["did"]))
{
		$deleqry="delete from tbl_admin where admin_id='".$_GET["did"]."'";
		if($Conn->query($deleqry))
		{
			?>
            <script>
			alert("Deleted");
			window.location="AdminRegistration.php";
			</script>
            <?php
		}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eduport::Adminregister</title>
</head>

<body>
<a href="Adminhome.php">Home</a>
<h1 align="center"> ADMIN REGISTRATION</h1>
<form id="form1" name="form1" method="post" action="">
  <table align="center" width="412" height="293" border="1">
    <tr>
      <td width="167">Admin Name</td>
      <td width="229"><label for="txt_name"></label>
      <input type="hidden" name="txt_hidden" id="txt_hidden" value="<?php echo 		$admin_id ?>" />
          <input type="text" name="txt_name" id="txt_name" value="<?php echo $admin_name ?>" placeholder="Enter your name" required title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" pattern="^[A-Z]+[a-zA-Z ]*$" />
    </tr>
    <tr>
      <td>Admin Email</td>
      <td><label for="txt_email"></label>
      <input type="email" name="txt_email" id="txt_email" value="<?php echo 		$admin_email ?>" placeholder="Enter your email id" required /></td>
    </tr>
    <tr>
      <td>Admin Password</td>
      <td><label for="txt_password"></label>
      <input type="password" name="txt_password" id="txt_password" value="<?php echo 		$admin_password ?>" placeholder="Set your password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
  </table>
  <h2 align="center">ADMIN FORM</h2>
  <table align="center" width="418" height="120" border="1">
    <tr>
      <td>SL.NO</td>
      <td>Name</td>
      <td>Email</td>
      <td>Action</td>
    </tr>
     <?php
	$i=0;
    $select='select * from tbl_admin';
	$res=$Conn->query($select);
	while($data=$res->fetch_assoc())
	{
		$i++;
		?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data['admin_name'] ?></td>
      <td><?php echo $data['admin_email'] ?></td>
       <td>
             <p><a href="AdminRegistration.php?eid=<?php echo $data['admin_id'] ?>">Edit</a>
       <a href="AdminRegistration.php?did=<?php echo $data['admin_id'] ?>">Delete</a></p></td></tr>
    <?php
	}
	?>
  </table>
</form>
</body>
</html>