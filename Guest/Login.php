<?php
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_POST['btn_submit']))
{
    $email=$_POST['txt_email'];
    $password=$_POST['txt_password'];

    $selParent="SELECT * FROM tbl_parent WHERE parent_email='".$email."' AND parent_password='".$password."'";
    $selAdmin="SELECT * FROM tbl_admin WHERE admin_email='".$email."' AND admin_password='".$password."'";
    $selTeacher="SELECT * FROM tbl_teacher WHERE teacher_email='".$email."' AND teacher_password='".$password."'";

    $Parentdata=$Conn->query($selParent);
    $Admindata=$Conn->query($selAdmin);
    $Teacherdata=$Conn->query($selTeacher);

    if($Parentrow=$Parentdata->fetch_assoc())
    {
        $_SESSION['uid']=$Parentrow['parent_id'];
        $_SESSION['uname']=$Parentrow['parent_name'];
        header("Location:../Parent/Parenthome.php");
    }
    elseif($Adminrow=$Admindata->fetch_assoc())
    {
        $_SESSION['aid']=$Adminrow['admin_id'];
        $_SESSION['aname']=$Adminrow['admin_name'];
        header("Location:../Admin/Adminhome.php");
    }
    elseif($Teacherrow=$Teacherdata->fetch_assoc())
    {
        $_SESSION['tid']=$Teacherrow['teacher_id'];
        $_SESSION['cid']=$Teacherrow['class_id'];
        $_SESSION['tname']=$Teacherrow['teacher_name'];
        header("Location:../Teacher/Teacherhome.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport :: Login</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
/* Moving gradient background */
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Roboto', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #a18cd1, #fbc2eb);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
}

@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Sliding card effect */
.login-card {
    background: rgba(255,255,255,0.95);
    width: 380px;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    transform: translateY(-50px);
    animation: slideIn 1s forwards;
}

@keyframes slideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.login-card h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-weight: 700;
}

/* Input fields */
.login-card input[type="email"],
.login-card input[type="password"] {
    width: 100%;
    padding: 14px 20px;
    margin-bottom: 20px;
    border-radius: 50px;
    border: 1px solid #ccc;
    font-size: 15px;
    transition: all 0.3s ease;
}

.login-card input[type="email"]:focus,
.login-card input[type="password"]:focus {
    border-color: #ff6f91;
    box-shadow: 0 0 10px rgba(255,111,145,0.4);
    outline: none;
}

/* Buttons */
.login-card button {
    width: 100%;
    padding: 14px;
    font-size: 18px;
    border-radius: 50px;
    border: none;
    background: #2e7ca6ff;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-card button:hover {
    background: #083d5eff;
    transform: scale(1.05);
}

/* Registration links */
.login-links {
    text-align: center;
    margin-top: 20px;
}

.login-links a {
    text-decoration: none;
    color: #040404ff;
    font-weight: 500;
    margin: 0 10px;
    transition: color 0.3s, transform 0.3s;
}

.login-links a:hover {
    color: #040404ff;
    transform: scale(1.05);
}
</style>
</head>

<body>

<div class="login-card">
    <h2>Eduport Login</h2>
    <form method="post" action="">
        <input type="email" name="txt_email" placeholder="Enter Email" required>
        <input type="password" name="txt_password" placeholder="Enter Password" required>
        <button type="submit" name="btn_submit">Login</button>
    </form>
    <div class="login-links"> 
        <a href="Teacher.php">Teacher Registration</a>
    </div>
</div>

</body>
</html>
