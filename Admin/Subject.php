<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php');

$subject_id = "";
$subject_name = "";
$hid = "";

if (isset($_POST['btn_submit'])) {
    $class = $_POST['sel_class'];
    $coursename = $_POST['sel_course'];
    $semname = $_POST['sel_sem'];
    $subjectname = $_POST['txt_subject'];
    $hid = $_POST['txt_hidden'];

    $select = "select * from tbl_subject where subject_name='" . $subjectname . "' and course_id='" . $coursename . "' and sem_id='" . $semname . "'";
    $ro = $Conn->query($select);

    if ($da = $ro->fetch_assoc()) {
        echo "<script>alert('Already Exist');window.location='Subject.php';</script>";
    } else {
        if ($hid == "") {
            $insqry = "insert into tbl_subject(course_id,sem_id,subject_name,class_id) 
                       values('" . $coursename . "','" . $semname . "','" . $subjectname . "','" . $class . "')";
            if ($Conn->query($insqry)) {
                echo "<script>alert('Inserted');window.location='Subject.php';</script>";
            }
        } else {
            $updateqry = "update tbl_subject set subject_name='" . $subjectname . "' where subject_id='" . $hid . "'";
            if ($Conn->query($updateqry)) {
                echo "<script>alert('Updated');window.location='Subject.php';</script>";
            }
        }
    }
}

if (isset($_GET['eid'])) {
    $selectSubject = "select * from tbl_subject where subject_id='" . $_GET["eid"] . "'";
    $data_Cat = $Conn->query($selectSubject);
    $row = $data_Cat->fetch_assoc();
    $subject_id = $row['subject_id'];
    $subject_name = $row['subject_name'];
}

if (isset($_GET["did"])) {
    $deleqry = "delete from tbl_subject where subject_id='" . $_GET["did"] . "'";
    if ($Conn->query($deleqry)) {
        echo "<script>alert('Deleted');window.location='Subject.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Subject Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #cce6ff; }
        .card { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .card-header { font-weight: bold; font-size: 1.1rem; text-align: center; }
        .btn-warning { background-color: #FFC107; border: none; }
        .btn-danger { background-color: #DC3545; border: none; }
        .table thead { background-color: #007BFF; color: white; }
    </style>
</head>
<body>
<div class="container my-4">

    <div class="mb-3">
        <a href="Adminhome.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add / Edit Subject</h4>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <input type="hidden" name="txt_hidden" value="<?php echo $subject_id ?>"/>

                <div class="mb-3">
                    <label for="sel_course" class="form-label">Course</label>
                    <select name="sel_course" id="sel_course" class="form-select" required>
                        <option value="">--Select Course--</option>
                        <?php
                        $select = 'select * from tbl_course';
                        $res = $Conn->query($select);
                        while ($data = $res->fetch_assoc()) {
                            $sel = (isset($row['course_id']) && $row['course_id'] == $data['course_id']) ? "selected" : "";
                            echo "<option value='".$data['course_id']."' $sel>".$data['course_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sel_sem" class="form-label">Semester</label>
                    <select name="sel_sem" id="sel_sem" class="form-select" required>
                        <option value="">--Select Semester--</option>
                        <?php
                        $select = 'select * from tbl_sem';
                        $res = $Conn->query($select);
                        while ($data = $res->fetch_assoc()) {
                            $sel = (isset($row['sem_id']) && $row['sem_id'] == $data['sem_id']) ? "selected" : "";
                            echo "<option value='".$data['sem_id']."' $sel>".$data['sem_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sel_class" class="form-label">Class</label>
                    <select name="sel_class" id="sel_class" class="form-select" required>
                        <option value="">--Select Class--</option>
                        <?php
                        $select = 'select * from tbl_class';
                        $res = $Conn->query($select);
                        while ($data = $res->fetch_assoc()) {
                            $sel = (isset($row['class_id']) && $row['class_id'] == $data['class_id']) ? "selected" : "";
                            echo "<option value='".$data['class_id']."' $sel>".$data['class_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="txt_subject" class="form-label">Subject</label>
                    <input type="text" name="txt_subject" id="txt_subject"
                           value="<?php echo $subject_name ?>"
                           class="form-control" placeholder="Enter Subject" required>
                </div>

                <div class="text-center">
                    <button type="submit" name="btn_submit" class="btn btn-success w-50">
                        <i class="bi bi-check-circle"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Subject List</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>SL.NO</th>
                    <th>COURSE</th>
                    <th>SEMESTER</th>
                    <th>SUBJECT</th>
                    <th>CLASS</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $select = "select * from tbl_subject s 
                           inner join tbl_course c on s.course_id=c.course_id 
                           inner join tbl_sem se on se.sem_id=s.sem_id 
                           inner join tbl_class cs on cs.class_id=s.class_id";
                $res = $Conn->query($select);
                while ($data = $res->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $data['course_name'] ?></td>
                        <td><?php echo $data['sem_name'] ?></td>
                        <td><?php echo $data['subject_name'] ?></td>
                        <td><?php echo $data['class_name'] ?></td>
                        <td>
                            <a href="Subject.php?eid=<?php echo $data['subject_id'] ?>"
                               class="btn btn-sm btn-warning mb-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="Subject.php?did=<?php echo $data['subject_id'] ?>"
                               onclick="return confirm('Are you sure you want to delete this?');"
                               class="btn btn-sm btn-danger mb-1">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('Footer.php'); ?>
