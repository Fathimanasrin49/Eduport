
<?php
include("../Assets/Connection/Connection.php");
session_start();
include("Head.php");

if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
}

// Delete parent
if(isset($_GET["did"]))
{
    $deleqry="delete from tbl_parent where parent_id='".$_GET["did"]."'";
    if($Conn->query($deleqry))
    {
        ?>
        <script>
        alert("Parent Deleted Successfully");
        window.location="ParentList.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Eduport :: Parent List</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #fdfcfb, #e2d1c3);
        margin: 0;
        padding: 0;
    }
    h2 {
        text-align: center;
        margin: 30px 0;
        color: #5d4037;
        font-size: 26px;
    }
    .table-container {
        width: 95%;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        overflow-x: auto;
        animation: fadeIn 1s ease-in-out;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background-color: #795548;
        color: #fff;
        padding: 12px;
        text-align: center;
        font-size: 14px;
    }
    td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        font-size: 13px;
    }
    tr:nth-child(even) {
        background-color: #f9f4f2;
    }
    tr:hover {
        background-color: #f1e1da;
        transition: 0.3s;
    }
    img {
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    a.action-btn {
        display: inline-block;
        margin: 4px 0;
        padding: 6px 10px;
        background: #795548;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 12px;
        transition: 0.3s;
    }
    a.action-btn:hover {
        background: #5d4037;
        transform: scale(1.05);
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(15px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
</head>
<body>

<h2>Parent List</h2>

<div class="table-container">
    <table>
        <tr>
            <th>SI.NO</th>
            <th>Name</th>
            <th>Place</th>
            <th>District</th>
            <th>Relation</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Address</th>
            <th>Photo</th>
            <th>Proof</th>
            <th>Action</th>
        </tr>
        <?php
        $i=0;
        $select="select * from tbl_parent u 
                 inner join tbl_place p on u.place_id=p.place_id 
                 inner join tbl_district d on d.district_id=p.district_id 
                 where u.class_id='".$_SESSION['cid']."'";
        $res=$Conn->query($select);
        while($data=$res->fetch_assoc())
        {
            $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $data['parent_name']; ?></td>
                <td><?php echo $data['place_name']; ?></td>
                <td><?php echo $data['district_name']; ?></td>
                <td><?php echo $data['parent_relation']; ?></td>
                <td><?php echo $data['parent_contact']; ?></td>
                <td><?php echo $data['parent_email']; ?></td>
                <td><?php echo $data['parent_address']; ?></td>
                <td><img src="../Assets/Files/Parentimage/<?php echo $data['parent_photo']; ?>" width="70" height="70"></td>
                <td><img src="../Assets/Files/Parentproof/<?php echo $data['parent_proof']; ?>" width="70" height="70"></td>
                <td>
                    <a href="ParentList.php?did=<?php echo $data['parent_id']; ?>" class="action-btn">Delete</a>
                    <a href="Student.php?uid=<?php echo $data['parent_id']; ?>" class="action-btn">Add Student</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

</body>
</html>
<?php include("Foot.php"); ?>
```
