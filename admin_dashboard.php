<?php
    require 'modules/app.php';
    check_session();
    verify_is_admin();
    $page_identifier = "./";
    $title = "Dashbaord";
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Start of DataTables -->
        <link rel="stylesheet" href="assets/css/fontawesome_all.css">
        <link rel="stylesheet" href="assets/css/mdb.min.css">
        <link href="assets/css/datatables/datatables.min.css" rel="stylesheet">
        <!-- End of DataTables -->
        <?php require 'modules/head.php'; ?>

    </head>

    <body>
    <script type="text/javascript"

            src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"

            src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <?php require 'modules/navbar.php'; ?>
    <?php
    function count_db_rows($con, $table_name){
        $sql="SELECT * FROM $table_name";
        if ($result=mysqli_query($con,$sql))
        {
            $rowcount=mysqli_num_rows($result);
            return $rowcount;
        }
        mysqli_close($con);
    }
    ?>

            <div class="container mt-5">
                <!--  TOp Cards -->
                <div class="row justify-content-around custom-padding-9-15">
                    <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <div class="dark-box text-center">
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-users fa-3x"></i>
                                    <p id="number_text" class="heading-font-1 ml-4"><?php echo count_db_rows($con, 'users'); ?></p>
                                </div>
                                <p id="bottom_heading" class="heading-font-2">Total Users</p>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <div class="dark-box text-center">
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-hdd fa-3x"></i>
                                <p id="number_text" class="heading-font-1 ml-4"><?php echo count_db_rows($con, 'user_and_devices'); ?></p>
                            </div>
                            <p id="bottom_heading" class="heading-font-2">Total Devices</p>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <div class="dark-box text-center">
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                                <p id="number_text" class="heading-font-1 ml-4">0</p>
                            </div>
                            <p id="bottom_heading" class="heading-font-2">Total Alerts</p>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <div class="dark-box text-center">
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-signal fa-3x"></i>
                                <p id="number_text" class="heading-font-1 ml-4"><?php echo count_db_rows($con, 'user_and_devices'); ?></p>
                            </div>
                            <p id="bottom_heading" class="heading-font-2">Online Devices</p>
                        </div>
                    </div>
                </div>
                    <!-- END OF CARDS -->
                <!-- End OF Main Container -->
            </div>

    <!-- Starting OF Custom Container -->
    <div class="container-fluid custom-container">

                <div class="row justify-content-around mt-5">
                    <!-- USer Data Tables -->
                    <div class="col-sm-12 col-md-12 mb-md-5 col-lg-6 col-xl-6 dark-box">
                        <table id="dtBasicExample" class="table table-striped table-bordered table-hover-custom text-dark" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="th-sm">Device Name</th>
                                        <th class="th-sm">Email</th>
                                        <th class="th-sm">Device MAC</th>
                                        <th class="th-sm">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    require 'modules/db.php';
                                    $sql = "SELECT * FROM user_and_devices";
                                    $res = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_array($res)){
                                        $rand = rand();
                                        echo '
                                    <tr class="border-match-bg">
                                        <td>'.$row["device_name"].'</td>
                                        <td>'.get_email($con, $row["user_id"]).'</td>
                                        <td>'.$row["mac"].'</td>
                                        <td>
                                            <a style="color: #00c851!important;" href="device-details.php?id='.$row["id"].'" class="link-custom text-success">Details</a> |
                                            <a style="color: #ffc107 !important;" href="" data-toggle="modal" data-target="#edit_user_'.$rand.'" class="link-custom text-warning">Edit</a> |
                                            <a style="color: #ff3547!important;" href="admin_dashboard.php?del_userid='.$row["id"].'" class="link-custom text-danger">Delete</a>
                                        </td>
                                    </tr>
                                ';?>

                                        <div class="modal" id="edit_user_<?php  echo $rand; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="" method="post">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header bg-modal-header border-bottom-red">
                                                            <h4 class="modal-title">Edit Device</h4>
                                                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body bg-modal-body text-white">
                                                                <div class="input-group mb-2">
                                                                    <span class="input-group-text text-secondary">
                                                                    <i class="fas fa-font"></i>
                                                                    </span>
                                                                    <input type="text" name="name" class="form-control " value="<?php  echo $row["device_name"]; ?>" required>
                                                                </div>
                                                                <div class="input-group mb-2">
                                                                <span class="input-group-text text-secondary">
                                                                    <i class="fas fa-at"></i>
                                                                </span>
                                                                    <input type="text" name="mac" class="form-control " value="<?php  echo $row["mac"]; ?>" required>
                                                                </div>
                                                                <div class="input-group mb-2">
                                                                <span class="input-group-text text-secondary">
                                                                    <i class="fas fa-lock"></i>
                                                                </span>
                                                                    <input type="text" name="location" class="form-control" value="<?php  echo $row["location"]; ?>" required>
                                                                </div>
                                                            <input type="hidden" name="id" value="<?php  echo $row["id"]; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer bg-modal-header text-white border-top-red">
                                                            <button class="w-50 btn btn-success" type="submit" name="edit_user">Update</button>
                                                            <button type="button" class="w-50 btn btn-danger" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                    </div>
                    <!-- Logs -->
                    <div class="col-sm-12 col-md-12 mb-md-5 col-lg-5 col-xl-5 dark-box overflow-overlay">
                        <p class="heading-font-2 system_logs_heading">System Logs</p>
                        <ul class="list-group system-log-list">
                            <?php
                            require 'modules/db.php';
                            $sql = "SELECT * FROM logs";
                            $res = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($res)){
                                if($row["cat"]==1){
                                    $theme = "info";
                                    $txt="Device Added";
                                }
                                if($row["cat"]==2){
                                    $theme = "danger";
                                    $txt="Alert";
                                }
                                if($row["cat"]==3){
                                    $theme = "warning";
                                    $txt="Device Removed";
                                }
                                if($row["cat"]==4){
                                    $theme = "success";
                                    $txt="User Added";
                                }
                                echo '
                           <li class="list-group-item"><i class="fas fa-chevron-right text-'.$theme.'"></i>
                                <span class="text-'.$theme.' log-msg">'.$row["message"].' at '.$row["date_time"].'.</span>
                                <span class="badge badge-pill badge-'.$theme.' height-fit-content float-right">'.$txt.'</span>
                            </li>
                                ';
                            }
                            ?>
                        </ul>
                    </div>
                </div>


                <!-- End Of USer Data Tables -->
    </div>
    <!-- End OF Custom Container -->


        <?php require 'modules/footer.php'; ?>
    <!-- Start of DataTables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
    <script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>
    <!-- End of DataTables -->

    <script>
        $(document).ready(function () {
            $('#dtBasicExample').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
    <!-- End of DataTables -->
    </body>

</html>

<?php
if(isset($_GET["del_userid"])){
    $user_id = secure_parameter($_GET["del_userid"]);
    require 'modules/classes/class.logger.php';
    $device_add_log = new logger();
    $device_add_log->device_removed(get_device_name_4rm_id($con, $user_id), 5);

    require 'modules/classes/class.updateConfigs.php';
    $del_user_id = new updateConfigs();
    $del_user_id->del_row('user_and_devices', $user_id);

}

function get_name($con, $id){
    $sql = "SELECT * FROM users WHERE id=$id";
    $res = mysqli_query($con, $sql);
    $a = mysqli_fetch_assoc($res);
    return $a["username"];
}
function get_email($con, $id){
    $sql = "SELECT * FROM users WHERE id=$id";
    $res = mysqli_query($con, $sql);
    $a = mysqli_fetch_assoc($res);
    return $a["email"];
}
function get_device_name_4rm_id($con, $id){
    $sql = "SELECT * FROM user_and_devices WHERE id=$id";
    $res = mysqli_query($con, $sql);
    $a = mysqli_fetch_assoc($res);
    return $a["device_name"];
}
if(isset($_POST["edit_user"])){
    $name = secure_parameter($_POST["name"]);
    $mac = secure_parameter($_POST["mac"]);
    $location = secure_parameter($_POST["location"]);
    $id = secure_parameter($_POST["id"]);
    require 'modules/classes/class.users.php';
    $add_device_obj = new Users();
    if($add_device_obj->updateDeviceDetails($id, $name, $mac, $location)){
        require 'modules/classes/class.logger.php';
        $user_add_log = new logger();
        $user_add_log->user_added($name, 6);
        js_alert("Device updated Successfully");
        js_redirect("admin_dashboard.php");
    }else{
        js_alert("Error Occrued while Updating Device!");
    }
}
?>
