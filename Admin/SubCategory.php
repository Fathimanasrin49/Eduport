<?php
include("../Assets/Connection/Connection.php");

	if(isset($_POST['btn_submit']))
	{
		$categoryname=$_POST['txt_name'];
		$subname=$_POST['txt_sub'];
		$insqry=("insert into tbl_subcategory(category_id,subcategory_name)values('".$categoryname."','".$subname."')");
		if($Conn->query($insqry))
		{
			?>
            <script>
			alert("INSERTED");
			window.location="SubCategory.php";
			</script>
            <?php
		}
	}
?>
<?php
if(isset($_GET["did"]))
{
		$deleqry="delete from tbl_SubCategory where SubCategory_id='".$_GET["did"]."'";
		if($Conn->query($deleqry))
		{
			?>
            <script>
			alert("Deleted");
			window.location="SubCategory.php";
			</script>
            <?php
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SubCategory</title>
</head>

<body>
<h1 align="center">SUBCATEGORY</h1>
<form id="form1" name="form1" method="post" action="">
  <table width="252" height="194" border="1" align="center">
    <tr>
      <td width="115">Category</td>
      <td width="121"><label for="txt_name"></label>
        <label for="txt_name2"></label>
        <select name="txt_name" id="txt_name2">
        <?php

    			$select='select * from tbl_category';
				$res=$Conn->query($select);
				while($data=$res->fetch_assoc())
				{
		?>
        	<option value="<?php echo $data["category_id"]?>"><?php echo $data["category_name"]?></option>
            <?php
				}
				?>
      </select></td>
    </tr>
    <tr>
      <td>SubCategory</td>
      <td><label for="txt_sub"></label>
      <input type="text" name="txt_sub" id="txt_sub" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        <input type="submit" name="btn_reset" id="btn_reset" value="Cancel" />
      </div></td>
    </tr>
  </table>
  <h2 align="center">SUBCATEGORY LIST</h2>
  <table width="374" height="193" border="1" align="center">
    <tr>
      <td width="50">SI.NO</td>
      <td width="114">Category Name</td>
      <td width="94">SubCategory</td>
      <td width="88">Action</td>
    </tr>
    <tr>
       <?php
	$i=0;
    $select="select * from tbl_subcategory s inner join tbl_category c on s.category_id=c.category_id";
	$res=$Conn->query($select);
	while($data=$res->fetch_assoc())
	{
		$i++;
		?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $data['category_name']; ?></td>
      <td><?php echo $data['subcategory_name']; ?></td>
      <td> <a href="SubCategory.php? did=<?php echo $data['subcategory_id']?>">Delete </a>
      </td>
    </tr>
    <?php
	}
	?>
  </table>
</form>
</body>
</html>