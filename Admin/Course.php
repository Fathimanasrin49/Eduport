<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

$course_id="";
$course_name="";
$hid="";
$department_id="";

if(isset($_POST['btn_submit']))
{
    $department_id=$_POST['txt_name'];
    $coursename=$_POST['txt_course'];
    $hid=$_POST['txt_hidden'];

    $select="select * from tbl_course where course_name='".$coursename."'";
    $ro=$Conn->query($select);
    if($da=$ro->fetch_assoc())
    {
        echo "<script>alert('Already Exist');window.location='Course.php';</script>";
    }
    else
    {
        if($hid=="")
        {
            $insqry="insert into tbl_course(department_id,course_name) values('".$department_id."','".$coursename."')";
            if($Conn->query($insqry))
            {
                echo "<script>alert('Inserted');window.location='Course.php';</script>";
            }
        }
        else
        {
            $updateqry="update tbl_course set course_name='".$coursename."', department_id='".$department_id."' where course_id='".$hid."'";
            if($Conn->query($updateqry))
            {
                echo "<script>alert('Updated');window.location='Course.php';</script>";
            }
        }
    }
}

if(isset($_GET['eid']))
{
    $selectCourse="select * from tbl_course where course_id='".$_GET["eid"]."'";
    $data_Cat=$Conn->query($selectCourse);
    $row=$data_Cat->fetch_assoc();
    $course_id=$row['course_id'];
    $course_name=$row['course_name'];
    $department_id=$row['department_id'];
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_course where course_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='Course.php';</script>";
    }
}
?>

<style>
body {
    background-color: #cce6ff; /* Light blue background */
}
.card {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.card-header {
    font-weight: bold;
    font-size: 1.1rem;
}
.btn-success {
    background-color: #4CAF50;
    border: none;
}
.btn-warning {
    background-color: #FFC107;
    border: none;
}
.btn-danger {
    background-color: #DC3545;
    border: none;
}
.table thead {
    background-color: #007BFF;
    color: white;
}
</style>

<div class="container-fluid mt-4">
  <div class="row">
    <!-- Form Section -->
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
          Add / Edit Course
        </div>
        <div class="card-body">
          <form method="post" action="">
            <input type="hidden" name="txt_hidden" value="<?php echo $course_id ?>"/>
            <div class="mb-3">
              <label class="form-label">Department</label>
              <select name="txt_name" class="form-select" required>
                <option value="">--Select Department--</option>
                <?php
                $select='select * from tbl_department';
                $res=$Conn->query($select);
                while($data=$res->fetch_assoc())
                {
                    $sel = ($data["department_id"]==$department_id) ? "selected" : "";
                    echo "<option value='".$data["department_id"]."' $sel>".$data["department_name"]."</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Course Name</label>
              <input type="text" class="form-control" name="txt_course" value="<?php echo $course_name ?>" placeholder="Enter course name" required />
            </div>
            <div class="text-center">
              <button type="submit" name="btn_submit" class="btn btn-success w-100">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Table Section -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
          Course List
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <th>SL.NO</th>
                <th>Department</th>
                <th>Course</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i=0;
              $select="select * from tbl_course c inner join tbl_department d on c.department_id=d.department_id";
              $res=$Conn->query($select);
              while($data=$res->fetch_assoc())
              {
                  $i++;
              ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $data['department_name'] ?></td>
                <td><?php echo $data['course_name'] ?></td>
                <td>
                  <a href="Course.php?eid=<?php echo $data['course_id'] ?>" class="btn btn-sm btn-warning mb-1">
                    <i class="ti ti-edit"></i> Edit
                  </a>
                  <a href="Course.php?did=<?php echo $data['course_id'] ?>" class="btn btn-sm btn-danger mb-1"
                     onclick="return confirm('Are you sure?')">
                    <i class="ti ti-trash"></i> Delete
                  </a>
                </td>
              </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('Footer.php'); ?>
