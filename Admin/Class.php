<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php'); 

if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

// Initialize variables
$class_id = "";
$class_name = "";
$selected_course_id = "";
$selected_dept_id = "";
$selected_year_id = "";

if(isset($_POST['btn_submit']))
{
    $classname = $_POST['txt_class'];
    $coursename = $_POST['sel_course'];
    $academicyearname = $_POST['sel_year'];
    $hid = $_POST['txt_hidden'];

    // Check for duplicates (class + course + year)
    $select = "SELECT * FROM tbl_class WHERE class_name='$classname' AND course_id='$coursename' AND academicyear_id='$academicyearname'";
    $ro = $Conn->query($select);

    if($da = $ro->fetch_assoc() && $hid=="")
    {
        echo "<script>alert('Class already exists for this course and year');window.location='Class.php';</script>";
    }
    else
    {
        if($hid=="")
        {
            $insqry = "INSERT INTO tbl_class(class_name, course_id, academicyear_id) VALUES('$classname', '$coursename', '$academicyearname')";
            if($Conn->query($insqry))
            {
                echo "<script>alert('Inserted');window.location='Class.php';</script>";
            }
        }
        else
        {
            $updateqry = "UPDATE tbl_class SET class_name='$classname', course_id='$coursename', academicyear_id='$academicyearname' WHERE class_id='$hid'";
            if($Conn->query($updateqry))
            {
                echo "<script>alert('Updated');window.location='Class.php';</script>";
            }
        }
    }
}

if(isset($_GET['eid']))
{
    $selectClass = "SELECT * FROM tbl_class WHERE class_id='".$_GET["eid"]."'";
    $data_Cat = $Conn->query($selectClass);
    $row = $data_Cat->fetch_assoc();

    $class_id = $row['class_id'];
    $class_name = $row['class_name'];
    $selected_course_id = $row['course_id'];
    $selected_year_id = $row['academicyear_id'];

    // Get department id from course
    $courseRow = $Conn->query("SELECT department_id FROM tbl_course WHERE course_id='$selected_course_id'")->fetch_assoc();
    $selected_dept_id = $courseRow['department_id'];
}

if(isset($_GET["did"]))
{
    $deleqry = "DELETE FROM tbl_class WHERE class_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='Class.php';</script>";
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
    text-align: center;
}
.btn-primary { background-color: #007BFF; border: none; }
.btn-warning { background-color: #FFC107; border: none; }
.btn-danger { background-color: #DC3545; border: none; }
.table thead { background-color: #007BFF; color: white; }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4">Manage Class</h2>

    <!-- Form Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">Add / Edit Class</div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="txt_hidden" value="<?php echo $class_id ?>"/>
                
                <div class="mb-3">
                    <label class="form-label">Class Name</label>
                    <input type="text" name="txt_class" class="form-control" value="<?php echo $class_name ?>" required placeholder="Enter class name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <select name="sel_name" id="sel_name" class="form-select" onChange="getCourse(this.value)" required>
                        <option value="">-- Select Department --</option>
                        <?php
                        $res = $Conn->query('SELECT * FROM tbl_department');
                        while($data=$res->fetch_assoc()) {
                            $sel = ($selected_dept_id==$data["department_id"]) ? "selected" : "";
                            echo "<option value='".$data["department_id"]."' $sel>".$data["department_name"]."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <select name="sel_course" id="sel_course" class="form-select" required>
                        <option value="">-- Select Course --</option>
                        <?php
                        $res = $Conn->query('SELECT * FROM tbl_course');
                        while($data=$res->fetch_assoc()) {
                            $sel = ($selected_course_id==$data["course_id"]) ? "selected" : "";
                            echo "<option value='".$data["course_id"]."' $sel>".$data["course_name"]."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Academic Year</label>
                    <select name="sel_year" id="sel_year" class="form-select" required>
                        <option value="">-- Select Academic Year --</option>
                        <?php
                        $res = $Conn->query('SELECT * FROM tbl_academicyear');
                        while($data=$res->fetch_assoc()) {
                            $sel = ($selected_year_id==$data["academicyear_id"]) ? "selected" : "";
                            echo "<option value='".$data["academicyear_id"]."' $sel>".$data["academicyear_year"]."</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="btn_submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>

    <!-- List Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Class List</div>
        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>SL.NO</th>
                        <th>Class</th>
                        <th>Department</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                $select="SELECT * FROM tbl_class c 
                         INNER JOIN tbl_course s ON c.course_id=s.course_id 
                         INNER JOIN tbl_department d ON d.department_id=s.department_id 
                         INNER JOIN tbl_academicyear a ON c.academicyear_id=a.academicyear_id";
                $res=$Conn->query($select);
                while($data=$res->fetch_assoc())
                {
                    $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $data['class_name'] ?></td>
                    <td><?php echo $data['department_name'] ?></td>
                    <td><?php echo $data['course_name'] ?></td>
                    <td><?php echo $data['academicyear_year'] ?></td>
                    <td>
                        <a href="Class.php?eid=<?php echo $data['class_id'] ?>" class="btn btn-sm btn-warning mb-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="Class.php?did=<?php echo $data['class_id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure?')">
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

<script src="../Assets/JQ/jQuery.js"></script>
<script>
function getCourse(did) {
    $.ajax({
        url:"../Assets/AjaxPages/AjaxCourse.php?did="+did,
        success: function(html){
            $("#sel_course").html(html);
        }
    });
}
</script>

<?php include('Footer.php'); ?>
