<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if($_SESSION['uid']==""){
    header('location:../Guest/Login.php');
    exit();
}

$select = "SELECT * FROM tbl_parent u 
           INNER JOIN tbl_place p ON u.place_id=p.place_id 
           INNER JOIN tbl_district d ON d.district_id=p.district_id 
           WHERE parent_id='".$_SESSION['uid']."'"; 
$Parentdata = $Conn->query($select);
$Parentrow = $Parentdata->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Eduport :: Parent Profile</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../Assets/Templates/Main/css/bootstrap.css">
<style>
    body {
        background-color: #f4f2f0;
        color: #4b3f36;
        font-family: 'Poppins', sans-serif;
    }
    .profile-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 30px;
        margin-top: 50px;
    }
    .profile-card img {
        border-radius: 50%;
        border: 3px solid #a9746e;
    }
    .profile-card h2 {
        margin-top: 15px;
        color: #a9746e;
    }
    .profile-card table {
        margin-top: 20px;
    }
    .profile-card table td {
        padding: 10px;
        vertical-align: middle;
    }
    .profile-card a {
        color: #a9746e;
        font-weight: 500;
        margin: 0 10px;
    }
    .profile-card a:hover {
        color: #d9b69a;
        text-decoration: none;
    }
</style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile-card text-center">
                <img src="../Assets/Files/Parentimage/<?php echo $Parentrow['parent_photo'] ?>" width="120" height="120" alt="Profile Photo">
                <h2><?php echo $Parentrow['parent_name'] ?></h2>

                <table class="table table-borderless text-left">
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?php echo $Parentrow['parent_email'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Contact:</strong></td>
                        <td><?php echo $Parentrow['parent_contact'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td><?php echo $Parentrow['parent_address'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>District:</strong></td>
                        <td><?php echo $Parentrow['district_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Place:</strong></td>
                        <td><?php echo $Parentrow['place_name'] ?></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="EditProfileParent.php" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                    <a href="ChangePasswordParent.php" class="btn btn-outline-warning btn-sm">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="../Assets/Templates/Main/js/jquery-3.2.1.min.js"></script>
<script src="../Assets/Templates/Main/js/popper.js"></script>
<script src="../Assets/Templates/Main/js/bootstrap.min.js"></script>

</body>
</html>

<?php
include("Foot.php");
?>
