<?php
include("../Assets/Connection/Connection.php");

if(isset($_POST['btn_submit']))
{
    $name=$_POST['txt_name'];
    $email=$_POST['txt_email'];
    $password=$_POST['txt_password'];
    $photo=$_FILES['txt_photo']['name'];
    $path=$_FILES['txt_photo']['tmp_name'];
    move_uploaded_file($path,"../Assets/Files/Teacherimage/".$photo);
    $proof=$_FILES['txt_proof']['name'];
    $path=$_FILES['txt_proof']['tmp_name'];
    move_uploaded_file($path,"../Assets/Files/Teacherproof/".$proof);
    $certificate=$_FILES['txt_certificate']['name'];
    $path=$_FILES['txt_certificate']['tmp_name'];
    move_uploaded_file($path,"../Assets/Files/Teachercertificate/".$certificate);

    $insqry=("insert into tbl_teacher(teacher_name,teacher_email,teacher_password,teacher_photo,teacher_proof,teacher_certificate)values('".$name."','".$email."','".$password."','".$photo."','".$proof."','".$certificate."')");
    if($Conn->query($insqry))
    {
        ?>
        <script>
        alert("Inserted Successfully");
        window.location="Teacher.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eduport::Teacher Registration</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
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

.register-card {
    background: rgba(255,255,255,0.95);
    width: 320px;   /* card cheruthakki */
    border-radius: 15px;
    padding: 25px 20px;  
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    animation: slideIn 1s forwards;
}

@keyframes slideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.register-card h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
    font-weight: 700;
    font-size: 20px;
    text-transform: uppercase;
}

/* Input fields */
.register-card input {
    width: 100%;
    padding: 10px 14px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: all 0.3s ease;
}

.register-card input:focus {
    border-color: #3498db;
    box-shadow: 0 0 8px rgba(52,152,219,0.4);
    outline: none;
}

/* Buttons */
.register-card button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border-radius: 40px;
    border: none;
    background: #3498db;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 8px;
}

.register-card button:hover {
    background: #2c3e50;
    transform: scale(1.05);
}
</style>
</head>

<body>

<div class="register-card">
    <h2>Teacher Registration</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="txt_name" placeholder="Enter your name" required 
               pattern="^[A-Z]+[a-zA-Z ]*$" 
               title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" />

        <input type="email" name="txt_email" placeholder="Enter your email" required />

        <input type="password" name="txt_password" placeholder="Enter password" 
               required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
               title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />

        <input type="password" name="txt_confirm" placeholder="Confirm password" required />

        <label>Upload Photo</label>
        <input type="file" name="txt_photo" required />

        <label>Upload Proof ID</label>
        <input type="file" name="txt_proof" required />

        <label>Upload Certificate</label>
        <input type="file" name="txt_certificate" required />

        <!-- 🔹 Button text changed here -->
        <button type="submit" name="btn_submit">Register</button>
        <button type="reset">Cancel</button>
    </form>
</div>

</body>
</html>
