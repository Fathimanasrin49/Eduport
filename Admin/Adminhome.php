<?php
include('Header.php');
include('../Assets/Connection/Connection.php');

// Fetch counts
$studentCount     = $Conn->query("SELECT COUNT(*) as c FROM tbl_student")->fetch_assoc()['c'];
$teacherCount     = $Conn->query("SELECT COUNT(*) as c FROM tbl_teacher")->fetch_assoc()['c'];
$totalReports     = $Conn->query("SELECT COUNT(*) as c FROM tbl_report WHERE report_status=1")->fetch_assoc()['c'];
?>

<div class="row">
  <!-- Students -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded-circle p-3 me-3">
          <i class="fas fa-user-graduate fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Students</h6>
          <h4 class="fw-bold mb-0"><?php echo $studentCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Teachers -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-success text-white rounded-circle p-3 me-3">
          <i class="fas fa-chalkboard-teacher fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Teachers</h6>
          <h4 class="fw-bold mb-0"><?php echo $teacherCount; ?></h4>
        </div>
      </div>
    </div>
  </div>

 

  <!-- Reports -->
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm p-3">
      <div class="d-flex align-items-center">
        <div class="bg-danger text-white rounded-circle p-3 me-3">
          <i class="fas fa-file-alt fs-4"></i>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Total Resolved Reports</h6>
          <h4 class="fw-bold mb-0"><?php echo $totalReports; ?></h4>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Students -->
<div class="col-lg-12">
  <div class="card w-100">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Recent Students</h5>
      <div class="row">
        <?php
        $students = $Conn->query("SELECT s.*, c.class_name, p.parent_name 
                                 FROM tbl_student s 
                                 INNER JOIN tbl_class c ON s.class_id=c.class_id
                                 INNER JOIN tbl_parent p ON s.parent_id=p.parent_id
                                 ORDER BY s.student_id DESC LIMIT 4");
        while($row = $students->fetch_assoc()) {
        ?>
        <div class="col-sm-6 col-xl-3">
          <div class="card overflow-hidden rounded-2">
            <div class="card-body pt-3 p-4">
              <h6 class="fw-semibold fs-4"><?php echo htmlspecialchars($row['student_name']); ?></h6>
              <p class="mb-1">Class: <?php echo htmlspecialchars($row['class_name']); ?></p>
              <p class="mb-1">Address: <?php echo htmlspecialchars(substr($row['student_address'], 0, 50)) . (strlen($row['student_address']) > 50 ? '...' : ''); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-4 mb-0">Roll: <?php echo $row['student_rollno']; ?></h6>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Recent Leaves -->
  <div class="col-lg-6">
    <div class="card w-100">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Recent Leaves</h5>
        <div class="table-responsive">
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Reason</th>
                <th>From Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $qry = $Conn->query("SELECT l.*, s.student_name 
                                  FROM tbl_leave l
                                  INNER JOIN tbl_student s ON l.student_id=s.student_id 
                                  ORDER BY l.leave_id DESC LIMIT 5");
              while($r = $qry->fetch_assoc()) {
                $status = 'Applied'; // Assuming all are applied, no status field
              ?>
              <tr>
                <td><?php echo $r['leave_id']; ?></td>
                <td><?php echo htmlspecialchars($r['student_name']); ?></td>
                <td><?php echo htmlspecialchars($r['leave_reason']); ?></td>
                <td><?php echo $r['leave_date']; ?></td>
                <td>
                  <span class="badge bg-warning">
                    <?php echo $status; ?>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Latest Reports -->
  <div class="col-lg-6">
    <div class="card w-100">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Latest Reports</h5>
        <div class="table-responsive">
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>ID</th>
                <th>Teacher</th>
                <th>Details</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $reports = $Conn->query("SELECT r.*, t.teacher_name 
                                         FROM tbl_report r 
                                         INNER JOIN tbl_teacher t ON r.teacher_id=t.teacher_id 
                                         ORDER BY r.report_id DESC LIMIT 5");
              while($rep = $reports->fetch_assoc()) {
                $rstatus = ($rep['report_status']==0) ? "Pending" : "Replied";
              ?>
              <tr>
                <td><?php echo $rep['report_id']; ?></td>
                <td><?php echo htmlspecialchars($rep['teacher_name']); ?></td>
                <td><?php echo htmlspecialchars($rep['report_details']); ?></td>
                <td><?php echo $rstatus; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('Footer.php');
?>