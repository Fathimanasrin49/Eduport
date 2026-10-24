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

if(isset($_POST['btn_update']))
{
    $teachername=$_POST['txt_name'];
    $teacheremail=$_POST['txt_email'];

    $updateqry="UPDATE tbl_teacher SET teacher_name='".$teachername."', teacher_email='".$teacheremail."' WHERE teacher_id='".$_SESSION['tid']."'";
    if($Conn->query($updateqry))
    {
        ?>
        <script>
            alert("Profile Updated Successfully");
            window.location="TeacherProfile.php";
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
<title>Eduport::Teacher Edit Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f4f7;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    padding: 20px 0;
}

/* Floating Card Animation */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.card {
    max-width: 450px;
    margin: 40px auto;
    padding: 25px 20px;
    border-radius: 15px;
    background-color: #fff;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    animation: float 6s ease-in-out infinite;
}

/* Inputs Styling */
.card input[type="text"],
.card input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    transition: 0.3s;
}

.card input[type="text"]:focus,
.card input[type="email"]:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
    outline: none;
}

/* Submit Button */
.card input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.card input[type="submit"]:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

/* Card Heading */
.card h2 {
    text-align: center;
    color: #4CAF50;
    margin-bottom: 25px;
}
</style>
</head>
<body>
<div class="card">
    <h2>Edit Profile</h2>
    <form method="post">
        <label for="txt_name">Name</label>
        <input type="text" name="txt_name" id="txt_name" value="<?php echo htmlspecialchars($Teacherrow['teacher_name']); ?>" required
        title="Name Allows Only Alphabets, Spaces and First Letter Must Be Capital Letter" pattern="^[A-Z]+[a-zA-Z ]*$"/>

        <label for="txt_email">Email</label>
        <input type="email" name="txt_email" id="txt_email" value="<?php echo htmlspecialchars($Teacherrow['teacher_email']); ?>" required/>

        <div style="text-align:center;">
            <input type="submit" name="btn_update" value="Update" />
        </div>
    </form>
</div>
</body>
</html>

<?php
include("Foot.php");
?>
