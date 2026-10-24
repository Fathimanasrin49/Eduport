<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eduport::StudentList</title>
</head>

<body>
 <h1 align="center">STUDENT INFO</h1>
  <table width="350" height="147" border="1" align="center">
    <tr>
      <td width="64">SI.NO</td>
       <td width="60">NAME</td>
        <td width="64">CLASS</td>
      <td width="64">ROLLNO</td>
      <td width="60">ADDRESS</td>
      <td width="64">PHOTO</td>
      <td width="64">ACTION</td>
    </tr>
    <tr>
     <?php
	$i=0;
    $select="select * from tbl_student s inner join tbl_class c on c.class_id=s.class_id  where  student_id='".$_GET['tid']."'";
		$res=$Conn->query($select);
	while($data=$res->fetch_assoc())
	{
		$i++;
		?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data['student_name']; ?></td>
      <td><?php echo $data['class_name']; ?></td>
      <td><?php echo $data['student_rollno']; ?></td>
      <td><?php echo $data['student_address']; ?></td>
      <td> <img src="../Assets/Files/Studentimage/<?php echo $data ['student_photo'] ?> " width="70px" height="70px"/></td>
      <td>
       <a href="../Admin/Attendance.php?sid=<?php echo $data['student_id'] ?>">Attendance</a> 
       <a href="../Admin/StudentList.php?did=<?php echo $data['student_id'] ?>">Delete</a>
       </td>
    </tr>
    <?php
	}
	?>
  </table>
</form>
</body>
</html>
</body>
</html>
<?php
include("Foot.php");
?>