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
 include("../Connection/Connection.php");
	$i=0;
    $select="select * from tbl_student s inner join tbl_class c on c.class_id=s.class_id where s.class_id='".$_GET['cid']."' ORDER BY student_rollno ASC";
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
       <a href="StudentList.php?did=<?php echo $data['student_id'] ?>">Delete</a></td>
    </tr>
    <?php
	}
	?>
  </table>