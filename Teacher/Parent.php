
<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

$selQry="select * from tbl_teacher t inner join tbl_class c on c.class_id=t.class_id where teacher_id='".$_SESSION['tid']."'";
$row=$Conn->query($selQry);
$data=$row->fetch_assoc();
$class=$data['class_id'];

if(isset($_POST['btn_submit']))
{
    $name=$_POST['txt_name'];
    $place=$_POST['sel_place'];
    $guardian=$_POST['btn_relation'];
    $contact=$_POST['txt_contact'];
    $email=$_POST['txt_email'];
    $password=$_POST['txt_password'];
    $address=$_POST['txt_address'];

    $photo=$_FILES['txt_photo']['name'];
    $path=$_FILES['txt_photo']['tmp_name'];
    move_uploaded_file($path,"../Assets/Files/Parentimage/".$photo);

    $proof=$_FILES['txt_proof']['name'];
    $path=$_FILES['txt_proof']['tmp_name'];
    move_uploaded_file($path,"../Assets/Files/Parentproof/".$proof);

    $insqry="insert into tbl_parent(parent_name,place_id,parent_relation,parent_contact,parent_email,parent_password,parent_address,parent_photo,parent_proof,class_id)
             values('".$name."','".$place."','".$guardian."','".$contact."','".$email."','".$password."','".$address."','".$photo."','".$proof."','".$class."')";
    
    if($Conn->query($insqry))
    {
        ?>
        <script>
        alert("Parent Registered Successfully");
        window.location="Parent.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Eduport :: Parent Registration</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #fdfcfb, #e2d1c3);
        margin: 0;
        padding: 0;
    }
    h1 {
        text-align: center;
        margin: 25px 0;
        color: #5d4037;
        font-size: 28px;
    }
    .form-container {
        width: 600px;
        margin: 20px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        animation: fadeIn 1.2s ease-in-out;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        font-weight: 600;
        color: #444;
        display: block;
        margin-bottom: 6px;
    }
    .form-group input, 
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #bbb;
        border-radius: 8px;
        font-size: 14px;
        transition: 0.3s;
    }
    .form-group input:focus, 
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #795548;
        outline: none;
        box-shadow: 0 0 6px rgba(121,85,72,0.5);
    }
    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 5px;
    }
    .form-actions {
        text-align: center;
        margin-top: 25px;
    }
    .form-actions input {
        background: #795548;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        margin: 0 5px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .form-actions input:hover {
        background: #5d4037;
        transform: scale(1.05);
    }
    .view-link {
        display: block;
        text-align: center;
        margin-top: 18px;
        text-decoration: none;
        color: #5d4037;
        font-weight: bold;
        transition: 0.3s;
    }
    .view-link:hover {
        color: #3e2723;
        text-decoration: underline;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
</head>
<body>

<h1>Parent Registration Form</h1>

<div class="form-container">
    <form method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="txt_name">Name</label>
            <input type="text" name="txt_name" id="txt_name" placeholder="Enter your name" 
                   required pattern="^[A-Z]+[a-zA-Z ]*$" 
                   title="Only alphabets, first letter capitalized"/>
        </div>
        
        <div class="form-group">
            <label for="sel_district">District</label>
            <select name="sel_district" id="sel_district" onChange="getPlace(this.value)" required>
                <option value="">-- Select District --</option>
                <?php
                $select='select * from tbl_district';
                $res=$Conn->query($select);
                while($d=$res->fetch_assoc())
                {
                    echo "<option value='".$d['district_id']."'>".$d['district_name']."</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="sel_place">Place</label>
            <select name="sel_place" id="sel_place" required>
                <option value="">-- Select Place --</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Relation</label>
            <div class="radio-group">
                <label><input type="radio" name="btn_relation" value="Father" required/> Father</label>
                <label><input type="radio" name="btn_relation" value="Mother"/> Mother</label>
                <label><input type="radio" name="btn_relation" value="Guardian"/> Guardian</label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="txt_contact">Contact No.</label>
            <input type="text" name="txt_contact" id="txt_contact" placeholder="Enter your number"
                   required pattern="[7-9]{1}[0-9]{9}" 
                   title="Must start with 7-9 and contain 10 digits"/>
        </div>
        
        <div class="form-group">
            <label for="txt_email">Email</label>
            <input type="email" name="txt_email" id="txt_email" placeholder="Enter your email" required/>
        </div>
        
        <div class="form-group">
            <label for="txt_password">Password</label>
            <input type="password" name="txt_password" id="txt_password" placeholder="Enter your password"
                   required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                   title="At least 1 number, 1 uppercase, 1 lowercase, min 8 characters"/>
        </div>
        
        <div class="form-group">
            <label for="txt_confirm">Confirm Password</label>
            <input type="password" name="txt_confirm" id="txt_confirm" placeholder="Confirm password" required/>
        </div>
        
        <div class="form-group">
            <label for="txt_address">Address</label>
            <textarea name="txt_address" id="txt_address" rows="4" placeholder="Enter your address" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="txt_photo">Photo</label>
            <input type="file" name="txt_photo" id="txt_photo" required/>
        </div>
        
        <div class="form-group">
            <label for="txt_proof">Proof ID</label>
            <input type="file" name="txt_proof" id="txt_proof" required/>
        </div>
        
        <div class="form-actions">
            <input type="submit" name="btn_submit" value="Submit"/>
            <input type="reset" value="Cancel"/>
        </div>
        
    </form>
    <a href="ParentList.php" class="view-link">View Parent List</a>
</div>

<script src="../Assets/JQ/jQuery.js"></script>  
<script>
    function getPlace(did) {
        $.ajax({
            url:"../Assets/AjaxPages/AjaxPlace.php?did="+did,
            success: function(html){
                $("#sel_place").html(html);
            }
        });
    }
</script>

</body>
</html>
<?php include("Foot.php"); ?>
