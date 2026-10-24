<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

$department_id = "";
$department_name = "";
$hid = "";

if(isset($_POST['btn_submit']))
{
    $departmentname = $_POST['txt_name'];
    $hid = $_POST['txt_hidden'];

    $select="select * from tbl_department where department_name='".$departmentname."'";
    $ro=$Conn->query($select);

    if($da=$ro->fetch_assoc())
    {
        echo "<script>alert('Already Exist');window.location='Department.php';</script>";
    }
    else
    {
        if($hid=="")
        {
            $insqry="insert into tbl_department(department_name) values('".$departmentname."')";
            if($Conn->query($insqry))
            {
                echo "<script>alert('Inserted');window.location='Department.php';</script>";
            }
        }
        else
        {
            $updateqry="update tbl_department set department_name='".$departmentname."' where department_id='".$hid."'";
            if($Conn->query($updateqry))
            {
                echo "<script>alert('Updated');window.location='Department.php';</script>";
            }
        }
    }
}

if(isset($_GET['eid']))
{
    $selectDepartment="select * from tbl_department where department_id='".$_GET["eid"]."'";
    $data_Cat=$Conn->query($selectDepartment);
    $row=$data_Cat->fetch_assoc();
    $department_id=$row['department_id'];
    $department_name=$row['department_name'];
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_department where department_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='Department.php';</script>";
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
</style>

<div class="container-fluid mt-4">
  <div class="row">
    <!-- Form Section -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Add / Edit Department</h5>
        </div>
        <div class="card-body">
          <form method="post" action="">
            <input type="hidden" name="txt_hidden" value="<?php echo $department_id ?>" />
            <div class="mb-3">
              <label class="form-label">Department Name</label>
              <input type="text" name="txt_name" class="form-control" placeholder="Enter Department" 
                     value="<?php echo $department_name ?>" required />
            </div>
            <button type="submit" name="btn_submit" class="btn btn-success w-100">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Table Section -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">Department List</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
              <tr>
                <th>SL.NO</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i=0;
              $select="select * from tbl_department";
              $res=$Conn->query($select);
              while($data=$res->fetch_assoc())
              {
                  $i++;
              ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $data['department_name'] ?></td>
                <td>
                  <a href="Department.php?eid=<?php echo $data['department_id'] ?>" 
                     class="btn btn-sm btn-warning">
                    <i class="ti ti-edit"></i> Edit
                  </a>
                  <a href="Department.php?did=<?php echo $data['department_id'] ?>" 
                     class="btn btn-sm btn-danger" 
                     onclick="return confirm('Are you sure you want to delete this department?')">
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
