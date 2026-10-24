<?php
include("../Assets/Connection/Connection.php");
$category_id="";
$category_name="";
$hid="";
	if(isset($_POST['btn_submit']))
	{
		$categoryname=$_POST['txt_cat'];
		$hid=$_POST['txt_hidden'];
	if($hid=="")
	{
		$insqry=("insert into tbl_category(category_name) 					values('".$categoryname."')");
		if($Conn->query($insqry))
		{
			?>
            <script>
			alert("INSERTED");
			window.location="Category.php";
			</script>
            <?php
		}
	}
	else
	{
		$updateqry="update tbl_category set category_name='".$categoryname."' where category_id='".$hid."'";
		if($Conn->query($updateqry))
		{
			?>
            <script>
				alert("updated");
				window.location="Category.php";
			</script>
            <?php
		}
	}
}

if(isset($_GET['eid']))
{
	$selectCategory="select * from tbl_category where category_id='".$_GET["eid"]."'";
		$data_Cat=$Conn->query($selectCategory);
			$row=$data_Cat->fetch_assoc();
			$category_id=$row['category_id'];
			$category_name=$row['category_name'];
			
}

if(isset($_GET["did"]))
{
		$deleqry="delete from tbl_category where category_id='".$_GET["did"]."'";
		if($Conn->query($deleqry))
		{
			?>
            <script>
			alert("Deleted");
			window.location="Category.php";
			</script>
            <?php
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Category</title>
</head>

<body>
<h1 align="center">MONTH</h1>
<form id="form1" name="form1" method="post" action="">
  <table align="center" width="365" height="165" border="1">
    <tr>
      <td>Category Name</td>
      <td><label for="txt_cat"></label>
        <div align="left">
            <input type="hidden" name="txt_hidden" id="txt_hidden" value="<?php echo $category_id ?>"/>
          <input type="text" name="txt_cat" id="txt_cat" value="<?php echo $category_name ?>" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        <input type="submit" name="btn_reset" id="btn_reset" value="Reset" />
      </div></td>
    </tr>
  </table> 
  <h2 align="center">MONTH LIST</h2>
  <table align="center" width="313" height="83" border="1">
    <tr>
      <td width="99" height="37">SL.NO</td>
      <td width="105">Category</td>
      <td width="87">Action</td>
    </tr>
    <?php
	$i=0;
    $select='select * from tbl_category';
	$res=$Conn->query($select);
	while($data=$res->fetch_assoc())
	{
		$i++;
		?>
    <tr>
      <td height="38"><?php echo $i ?></td>
      <td><?php echo $data['category_name'] ?></td>
      <td> <a href="Category.php?eid=<?php echo $data['category_id'] ?>">Edit</a>
       <a href="Category.php?did=<?php echo $data['category_id'] ?>">Delete</a>;</td>
    </tr>
    <?php
	}
	?>
  </table>
</form>
</body>
</html>