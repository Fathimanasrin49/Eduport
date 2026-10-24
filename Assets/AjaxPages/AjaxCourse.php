<option value="">--select--</option>
 <?php
 include("../Connection/Connection.php");

    			$select="select * from tbl_course where department_id='".$_GET['did']."'";
				$res=$Conn->query($select);
				while($data=$res->fetch_assoc())
				{
		?>
        	<option value="<?php echo $data["course_id"]?>"><?php echo $data["course_name"]?></option>
            <?php
				}
				?>