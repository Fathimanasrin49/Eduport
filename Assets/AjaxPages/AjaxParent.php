<?php
include("../Connection/Connection.php");
?>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>SL.NO</th>
                            <th>NAME</th>
                            <th>PLACE</th>
                            <th>DISTRICT</th>
                            <th>RELATION</th>
                            <th>CONTACT NO.</th>
                            <th>EMAIL</th>
                            <th>ADDRESS</th>
                            <th>PHOTO</th>
                            <th>PROOF</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $i = 0;
                        $select = "SELECT * FROM tbl_parent u 
                                   INNER JOIN tbl_place p ON u.place_id=p.place_id 
                                   INNER JOIN tbl_district d ON d.district_id=p.district_id 
                                   INNER JOIN tbl_class c ON u.class_id=c.class_id 
                                   WHERE u.class_id='" . $_GET['cid'] . "'";
                        $res = $Conn->query($select);
                        while($data = $res->fetch_assoc()) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $data['parent_name']; ?></td>
                                <td><?php echo $data['place_name']; ?></td>
                                <td><?php echo $data['district_name']; ?></td>
                                <td><?php echo $data['parent_relation']; ?></td>
                                <td><?php echo $data['parent_contact']; ?></td>
                                <td><?php echo $data['parent_email']; ?></td>
                                <td><?php echo $data['parent_address']; ?></td>
                                <td><img src="../Assets/Files/Parentimage/<?php echo $data['parent_photo']; ?>" width="70" height="70" class="img-thumbnail"></td>
                                <td><img src="../Assets/Files/Parentproof/<?php echo $data['parent_proof']; ?>" width="70" height="70" class="img-thumbnail"></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
   


