<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if (!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
    header('location:../Guest/Login.php');
    exit();
}

$select = "SELECT * FROM tbl_parent u 
           INNER JOIN tbl_place p ON u.place_id = p.place_id 
           INNER JOIN tbl_district d ON d.district_id = p.district_id 
           WHERE parent_id='" . $_SESSION['uid'] . "'";
$Parentdata = $Conn->query($select);
$Parentrow = $Parentdata->fetch_assoc();

if (isset($_POST['btn_update'])) {
    $parentname = $_POST['txt_name'];
    $parentemail = $_POST['txt_email'];
    $parentcontact = $_POST['txt_contact'];
    $parentaddress = $_POST['txt_address'];

    $updateqry = "UPDATE tbl_parent SET 
                  parent_name='$parentname', 
                  parent_email='$parentemail', 
                  parent_contact='$parentcontact', 
                  parent_address='$parentaddress' 
                  WHERE parent_id='" . $_SESSION['uid'] . "'";
    if ($Conn->query($updateqry)) {
        echo "<script>alert('Profile updated successfully'); window.location='ParentProfile.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Edit Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
}
.card {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    background-color: #fff;
}
h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #4CAF50;
}
.btn-primary {
    width: 100%;
    border-radius: 8px;
}
</style>
</head>
<body>

<div class="card">
    <h2>Edit Profile</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="txt_name" class="form-label">Name</label>
            <input type="text" class="form-control" name="txt_name" id="txt_name" 
                   value="<?php echo htmlspecialchars($Parentrow['parent_name']); ?>" 
                   required pattern="^[A-Z]+[a-zA-Z ]*$" 
                   title="Name allows only alphabets and spaces; first letter must be capital">
        </div>
        <div class="mb-3">
            <label for="txt_email" class="form-label">Email</label>
            <input type="email" class="form-control" name="txt_email" id="txt_email" 
                   value="<?php echo htmlspecialchars($Parentrow['parent_email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="txt_contact" class="form-label">Contact No.</label>
            <input type="text" class="form-control" name="txt_contact" id="txt_contact" 
                   value="<?php echo htmlspecialchars($Parentrow['parent_contact']); ?>" 
                   required pattern="[7-9]{1}[0-9]{9}" 
                   title="Phone number must start with 7-9 and have 10 digits">
        </div>
        <div class="mb-3">
            <label for="txt_address" class="form-label">Address</label>
            <textarea class="form-control" name="txt_address" id="txt_address" rows="4" required><?php echo htmlspecialchars($Parentrow['parent_address']); ?></textarea>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-primary" name="btn_update" value="Update Profile">
            <a href="ParentProfile.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>

<?php
include("Foot.php");
?>
