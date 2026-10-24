<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
}

$sel="select * from tbl_parent p inner join tbl_class c on p.class_id=c.class_id where parent_id='".$_GET['uid']."'";
$res1=$Conn->query($sel);
$datap=$res1->fetch_assoc();

if(isset($_POST['btn_submit']))
{
    $name=$_POST['txt_name'];
    $rollno=$_POST['txt_rollno'];
    $address=$_POST['txt_address'];
    $photo=$_FILES['txt_photo']['name'];
    $class=$_POST['sel_class'];
    $path=$_FILES['txt_photo']['tmp_name'];
    move_uploaded_file($path,"../Assets/Files/Studentimage/".$photo);

    $insqry=("insert into tbl_student(student_name,student_rollno,student_address,student_photo,class_id,parent_id) 
              values('".$name."','".$rollno."','".$address."','".$photo."','".$datap['class_id']."','".$_GET['uid']."')");
    if($Conn->query($insqry))
    {
        ?>
        <script>
        alert("Student Inserted Successfully");
        window.location="ParentList.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Eduport :: Student Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f9f9fc;
        margin: 0;
        padding: 0;
    }
    h1, h2 {
        text-align: center;
        color: #333;
        margin: 20px 0;
        text-transform: uppercase;
    }
    form {
        background: #fff;
        width: 500px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        padding: 10px;
        font-size: 14px;
    }
    input[type="text"], input[type="file"], textarea {
        width: 95%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    textarea {
        resize: none;
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
    a {
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover {
        color: #0056b3;
    }
    /* Student Info Table */
    .info-table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    }
    .info-table th, .info-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    .info-table th {
        background: #795548; /* brown */
        color: #fff;
        text-transform: uppercase;
    }
    .info-table tr:nth-child(even) {
        background: #f9f9f9;
    }
    .info-table tr:hover {
        background: #f1f1f1;
    }
</style>
</head>
<body>

<h1>Student Form</h1>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table>
    <tr>
      <td><b>Name</b></td>
      <td><input type="text" name="txt_name" id="txt_name" required 
                 pattern="^[A-Z]+[a-zA-Z ]*$" 
                 title="Name allows only alphabets, spaces and must start with a capital letter"
                 placeholder="Enter student name..."/></td>
    </tr>
    <tr>
      <td><b>Roll No</b></td>
      <td><input type="text" name="txt_rollno" id="txt_rollno" required placeholder="Enter roll no..."/></td>
    </tr>
    <tr>
      <td><b>Address</b></td>
      <td><textarea name="txt_address" id="txt_address" rows="4" required placeholder="Enter student address"></textarea></td>
    </tr>
    <tr>
      <td><b>Photo</b></td>
      <td><input type="file" name="txt_photo" id="txt_photo" required /></td>
    </tr>
    <tr>
      <td><b>Class</b></td>
      <td><?php echo $datap['class_name']; ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </td>
    </tr>
  </table>
</form>

<p align="center"><a href="Teacherhome.php">Home Page</a></p>

<h2>Student Info</h2>
<table class="info-table">
  <tr>
    <th>SI.NO</th>
    <th>Name</th>
    <th>Class</th>
    <th>Roll No</th>
    <th>Address</th>
    <th>Photo</th>
    <th>Action</th>
  </tr>
  <?php
  $i=0;
  $select="select * from tbl_student s inner join tbl_class c on c.class_id=s.class_id where parent_id='".$_GET['uid']."'";
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
    <td><img src="../Assets/Files/Studentimage/<?php echo $data['student_photo'] ?>" width="70px" height="70px" style="border-radius:5px;"/></td>
    <td><a href="../Admin/StudentList.php?did=<?php echo $data['student_id'] ?>" onclick="return confirm('Are you sure to delete this student?')">Delete</a></td>
  </tr>
  <?php
  }
  ?>
</table>

</body>
</html>
<?php
include("Foot.php");
?>
