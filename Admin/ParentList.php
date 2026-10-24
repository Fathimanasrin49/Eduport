<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php'); 

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}
?>

<div class="container my-4">

  <!-- Back Button -->
  <form method="post" class="mb-3">
    <button type="submit" name="btn_exit" id="btn_exit" class="btn btn-secondary">
      <i class="bi bi-arrow-left-circle"></i> Back
    </button>
    <?php
    if(isset($_POST['btn_exit'])) {
        echo "<script>window.location='Adminhome.php';</script>";
    }
    ?>
  </form>

  <h2 class="text-center mb-4">Parent List</h2>

  <!-- Filter by Class -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form method="post">
        <div class="row g-3 align-items-center">
          <div class="col-md-3">
            <label for="sel_class" class="form-label fw-bold">Class</label>
            <select required name="sel_class" id="sel_class" class="form-select" onChange="getParent(this.value)">
              <option value="">Select Class</option>
              <?php 
              $select = 'SELECT * FROM tbl_class';
              $res = $Conn->query($select);
              while ($data = $res->fetch_assoc()) {
                  echo '<option value="'.$data["class_id"].'">'.$data["class_name"].'</option>';
              }
              ?>
            </select>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Parent Table -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover text-center align-middle" id="sel_parentlist">
        <thead class="table-dark">
          <tr>
            <th>SI.NO</th>
            <th>Name</th>
            <th>Place</th>
            <th>District</th>
            <th>Relation</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Address</th>
            <th>Photo</th>
            <th>Proof</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=0;
          $select="SELECT * FROM tbl_parent u 
                   INNER JOIN tbl_place p ON u.place_id=p.place_id 
                   INNER JOIN tbl_district d ON d.district_id=p.district_id";
          $res=$Conn->query($select);
          while($data=$res->fetch_assoc()) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo htmlspecialchars($data['parent_name']); ?></td>
                <td><?php echo htmlspecialchars($data['place_name']); ?></td>
                <td><?php echo htmlspecialchars($data['district_name']); ?></td>
                <td><?php echo htmlspecialchars($data['parent_relation']); ?></td>
                <td><?php echo htmlspecialchars($data['parent_contact']); ?></td>
                <td><?php echo htmlspecialchars($data['parent_email']); ?></td>
                <td><?php echo htmlspecialchars($data['parent_address']); ?></td>
                <td><img src="../Assets/Files/Parentimage/<?php echo $data['parent_photo']; ?>" class="img-thumbnail" width="70" height="70"></td>
                <td><img src="../Assets/Files/Parentproof/<?php echo $data['parent_proof']; ?>" class="img-thumbnail" width="70" height="70"></td>
              </tr>
              <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="../Assets/JQ/jQuery.js"></script>
<script>
function getParent(cid) {
    $.ajax({
        url:"../Assets/Ajaxpages/AjaxParent.php?cid="+cid,
        success: function(html){
            $("#sel_parentlist").html(html);
        }
    });
}
</script>

<style>
body {
    background-color: #cce6ff; /* Light blue background */
    font-family: Arial, sans-serif;
}
.card {
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
.card-header {
    font-weight: bold;
    font-size: 1rem;
}
.table thead {
    background-color: #007BFF;
    color: white;
}
.table-hover tbody tr:hover {
    background-color: #b3d9ff;
}
.img-thumbnail {
    border-radius: 5px;
}
</style>

<?php include('Footer.php'); ?>
