<?php
require_once('config.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

if(isset($_POST["resource_name_id"]) && !empty($_POST["resource_name_id"])){
    $resource_name_id = $_POST["resource_name_id"];

    $upload_results = array();
    $upload_errors = array();

    foreach ($_POST as $key => $value) {

        if (substr($key, 0, 15) === 'cruddiy_backup_') {
            $originalKey = substr($key, 15);
            if (isset($_FILES[$originalKey]) && $_FILES[$originalKey]['error'] == UPLOAD_ERR_OK) {
                $this_upload = handleFileUpload($_FILES[$originalKey]);
                $upload_results[] = $this_upload;

                if (!in_array(true, array_column($this_upload, 'error')) && !array_key_exists('error', $this_upload)) {
                    $_POST[$originalKey] = $this_upload['success'];

                    unlink($upload_target_dir . $_POST['cruddiy_backup_' . $originalKey]);
                }
            } else {
                $_POST[$originalKey] = $value;
            }
        }


        if (substr($key, 0, 15) === 'cruddiy_delete_') {
            $deleteKey = substr($key, 15);

            if (isset($_POST['cruddiy_delete_' . $deleteKey]) && $_POST['cruddiy_delete_' . $deleteKey]) {
                $_POST[$deleteKey] = '';

                @unlink($upload_target_dir . $_POST['cruddiy_backup_' . $deleteKey]);
            }
        }
    }

    $upload_errors = array();
    foreach ($upload_results as $result) {
        if (isset($result['error'])) {
            $upload_errors[] = $result['error'];
        }
    }

    if (!in_array(true, array_column($upload_results, 'error'))) {

        $description = $_POST["description"] == "" ? null : trim($_POST["description"]);
		$resource_name = $_POST["resource_name"] == "" ? null : trim($_POST["resource_name"]);
		

        $stmt = $link->prepare("UPDATE `resource_type` SET `description`=?,`resource_name`=? WHERE `resource_name_id`=?");

        try {
            $stmt->execute([ $description, $resource_name, $resource_name_id  ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = $e->getMessage();
        }

        if (!isset($error)){
            header("location: resource_type-read.php?resource_name_id=$resource_name_id");
        } else {
            $uploaded_files = array();
            foreach ($upload_results as $result) {
                if (isset($result['success'])) {
                    unlink($upload_target_dir . $result['success']);
                }
            }
        }

    }
}
$_GET["resource_name_id"] = trim($_GET["resource_name_id"]);
if(isset($_GET["resource_name_id"]) && !empty($_GET["resource_name_id"])){
    $resource_name_id =  trim($_GET["resource_name_id"]);

    $sql = "SELECT * FROM `resource_type` WHERE `resource_name_id` = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        $param_id = $resource_name_id;

        if (is_int($param_id)) $__vartype = "i";
        elseif (is_string($param_id)) $__vartype = "s";
        elseif (is_numeric($param_id)) $__vartype = "d";
        else $__vartype = "b";
        mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);


                $description = htmlspecialchars($row["description"] ?? "");
					$resource_name = htmlspecialchars($row["resource_name"] ?? "");
					

            } else{
                header("location: error.php");
                exit();
            }

        } else{
            translate('stmt_error') . "<br>".$stmt->error;
        }
    }

    mysqli_stmt_close($stmt);

}  else{
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php translate('Update Record') ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<?php require_once('navbar.php'); ?>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2><?php translate('Update Record') ?></h2>
                    </div>
                    <?php print_error_if_exists(@$upload_errors); ?>
                    <?php print_error_if_exists(@$error); ?>
                    <p><?php translate('update_record_instructions') ?></p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                                            <label for="description">Resource Type Description</label>
                                            <textarea name="description" id="description" class="form-control"><?php echo @$description; ?></textarea>
                                        </div>
						<div class="form-group">
                                            <label for="resource_name">Resource Type Name</label>
                                            <input type="text" name="resource_name" id="resource_name" maxlength="20" class="form-control" value="<?php echo @$resource_name; ?>">
                                        </div>

                        <input type="hidden" name="resource_name_id" value="<?php echo $resource_name_id; ?>"/>
                        <p>
                            <input type="submit" class="btn btn-primary" value="<?php translate('Edit') ?>">
                            <a href="javascript:history.back()" class="btn btn-secondary"><?php translate('Cancel') ?></a>
                        </p>
                        <hr>
                        <p>
                            <a href="resource_type-read.php?resource_name_id=<?php echo $_GET["resource_name_id"];?>" class="btn btn-info"><?php translate('View Record') ?></a>
                            <a href="resource_type-delete.php?resource_name_id=<?php echo $_GET["resource_name_id"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                            <a href="resource_type-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
                        </p>
                        <p><?php translate('required_fiels_instructions') ?></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>