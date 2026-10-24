<?php
include("../Assets/Connection/Connection.php");
session_start();
include('Header.php'); 
if($_SESSION['aid']==""){
    header('location:../Guest/Login.php');
}

$sem_id="";
$sem_name="";
$hid="";

if(isset($_POST['btn_submit']))
{
    $semname=$_POST['txt_name'];
    $hid=$_POST['txt_hidden'];

    $select="select * from tbl_sem where sem_name='".$semname."'";
    $ro=$Conn->query($select);
    if($da=$ro->fetch_assoc())
    {
        echo "<script>alert('Already Exist');window.location='Sem.php';</script>";
    }
    else
    {
        if($hid=="")
        {
            $insqry="insert into tbl_sem(sem_name) values('".$semname."')";
            if($Conn->query($insqry))
            {
                echo "<script>alert('Inserted');window.location='Sem.php';</script>";
            }
        }
        else
        {
            $updateqry="update tbl_sem set sem_name='".$semname."' where sem_id='".$hid."'";
            if($Conn->query($updateqry))
            {
                echo "<script>alert('Updated');window.location='Sem.php';</script>";
            }
        }
    }
}

if(isset($_GET['eid']))
{
    $selectSem="select * from tbl_sem where sem_id='".$_GET["eid"]."'";
    $data_Cat=$Conn->query($selectSem);
    $row=$data_Cat->fetch_assoc();
    $sem_id=$row['sem_id'];
    $sem_name=$row['sem_name'];
}

if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_sem where sem_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        echo "<script>alert('Deleted');window.location='Sem.php';</script>";
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
.btn-primary {
    background-color: #007BFF;
    border: none;
}
.table thead {
    background-color: #007BFF;
    color: white;
}
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4">Semester Management</h2>

    <!-- Form Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    Add / Edit Semester
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <input type="hidden" name="txt_hidden" value="<?php echo $sem_id ?>" />
                        <div class="mb-3">
                            <label class="form-label">Semester Name</label>
                            <input type="text" name="txt_name" class="form-control" placeholder="Enter semester" 
                                   value="<?php echo $sem_name ?>" required />
                        </div>
                        <div class="text-center">
                            <button type="submit" name="btn_submit" class="btn btn-success w-50">Submit</button>
                            <a href="Sem.php" class="btn btn-secondary w-25">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- List Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
            Semester List
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>SL.NO</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $select="select * from tbl_sem";
                    $res=$Conn->query($select);
                    while($data=$res->fetch_assoc())
                    {
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $data['sem_name'] ?></td>
                        <td>
                            <a href="Sem.php?eid=<?php echo $data['sem_id'] ?>" class="btn btn-sm btn-primary mb-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="Sem.php?did=<?php echo $data['sem_id'] ?>" class="btn btn-sm btn-danger mb-1"
                               onclick="return confirm('Are you sure to delete this semester?');">
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
