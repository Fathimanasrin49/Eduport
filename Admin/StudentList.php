<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

if(isset($_GET["did"])) {
    $deleqry="DELETE FROM tbl_student WHERE student_id='".$_GET["did"]."'";
    if($Conn->query($deleqry)) {
        echo "<script>alert('Student deleted successfully'); window.location='StudentList.php';</script>";
    }
}
?>

<div class="container my-4">

  <!-- Heading -->
  <div class="text-center mb-4">
    <h2 class="fw-bold">Student List</h2>
  </div>

  <!-- Filter by Class -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
      <h6 class="mb-0">Filter by Class</h6>
    </div>
    <div class="card-body">
      <form method="post" class="row g-3 align-items-center">
        <div class="col-md-6">
          <label for="sel_class" class="form-label">Select Class</label>
          <select required name="sel_class" id="sel_class" class="form-select" onchange="getStudent(this.value)">
            <option value="">Select Class</option>
            <?php 
            $select = 'SELECT * FROM tbl_class';
            $res = $Conn->query($select);
            while ($data = $res->fetch_assoc()) {
                echo '<option value="' . $data["class_id"] . '">' . $data["class_name"] . '</option>';
            }
            ?>
          </select>
        </div>
      </form>
    </div>
  </div>

  <!-- Student List -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle text-center" id="sel_studentlist">
        <thead class="table-dark">
          <tr>
            <th>SL.NO</th>
            <th>Name</th>
            <th>Class</th>
            <th>Roll No</th>
            <th>Address</th>
            <th>Photo</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        $select="SELECT * FROM tbl_student s 
                 INNER JOIN tbl_class c ON c.class_id=s.class_id 
                 ORDER BY student_rollno ASC";
        $res=$Conn->query($select);
        while($data=$res->fetch_assoc()) {
            $i++;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $data['student_name']; ?></td>
              <td><?php echo $data['class_name']; ?></td>
              <td><?php echo $data['student_rollno']; ?></td>
              <td><?php echo $data['student_address']; ?></td>
              <td>
                <img src="../Assets/Files/Studentimage/<?php echo $data['student_photo']; ?>" 
                     class="img-thumbnail" width="70" height="70">
              </td>
              <td>
                <a href="StudentList.php?did=<?php echo $data['student_id']; ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure you want to delete this student?');">
                  <i class="bi bi-trash"></i> Delete
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../Assets/JQ/jQuery.js"></script>

<script>
function getStudent(cid) {
    $.ajax({
        url:"../Assets/Ajaxpages/AjaxStudent.php?cid="+cid,
        success: function(html){
            $("#sel_studentlist").html(html);
        }
    });
}
</script>

<style>
body {
    background-color: #cce6ff; /* Light blue background */
}
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.card-header {
    font-weight: bold;
    font-size: 1.1rem;
}
.img-thumbnail {
    border-radius: 8px;
}
.table thead {
    background-color: #007BFF;
    color: white;
}
.table-hover tbody tr:hover {
    background-color: #b3d9ff;
}
</style>

<?php include('Footer.php'); ?>
