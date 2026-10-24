<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");
if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
    exit();
}

$select="SELECT * FROM tbl_teacher WHERE teacher_id='".$_SESSION['tid']."'"; 
$Teacherdata=$Conn->query($select);
$Teacherrow=$Teacherdata->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport::Teacher Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Fonts & Body */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f4f7;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Card Float Animation */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.card {
    max-width: 500px;
    margin: 40px auto;
    padding: 30px 20px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    text-align: center;
    animation: float 6s ease-in-out infinite;
}

/* Profile Image Pulse */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.card img {
    border-radius: 50%;
    width: 120px;
    height: 120px;
    object-fit: cover;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    animation: pulse 3s ease-in-out infinite;
}

.card h2 {
    color: #4CAF50;
    margin-bottom: 10px;
}

.card p {
    font-size: 16px;
    margin: 5px 0;
}

/* Button Group Animation */
.btn-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-top: 15px;
}

.btn-group a {
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    background-color: #ffc107;
    color: #000;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}

/* Moving gradient effect */
.btn-group a::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(120deg, rgba(255,255,255,0.2), rgba(255,255,255,0.0), rgba(255,255,255,0.2));
    transform: rotate(45deg);
    animation: shine 2s linear infinite;
}

@keyframes shine {
    0% { transform: rotate(45deg) translateX(-200%); }
    100% { transform: rotate(45deg) translateX(200%); }
}

.btn-group a:hover {
    background-color: #e0a800;
    color: #fff;
    transform: translateY(-3px);
}

/* Footer */
footer {
    background-color: #8B4513;
    color: #fff;
    text-align: center;
    padding: 20px 0;
    margin-top: auto;
    animation: float 8s ease-in-out infinite;
}

footer a {
    color: #FFD700;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<div class="card">
    <img src="../Assets/Files/Teacherimage/<?php echo $Teacherrow['teacher_photo'] ?>" alt="Teacher Photo">
    <h2><?php echo htmlspecialchars($Teacherrow['teacher_name']); ?></h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($Teacherrow['teacher_email']); ?></p>
    <div class="btn-group">
        <a href="EditProfileTeacher.php">Edit Profile</a>
        <a href="ChangePasswordTeacher.php">Change Password</a>
        <a href="Parent.php">Add Parent</a>
    </div>
</div>



</body>
</html>

<?php
include("Foot.php");
?>
