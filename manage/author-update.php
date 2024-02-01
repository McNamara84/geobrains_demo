<?php
require_once('config.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

if(isset($_POST["author_id"]) && !empty($_POST["author_id"])){
    $author_id = $_POST["author_id"];

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

        $lastname = trim($_POST["lastname"]);
		$firstname = trim($_POST["firstname"]);
		$orcid = trim($_POST["orcid"]);
		$affiliation = $_POST["affiliation"] == "" ? null : trim($_POST["affiliation"]);
		

        $stmt = $link->prepare("UPDATE `author` SET `lastname`=?,`firstname`=?,`orcid`=?,`affiliation`=? WHERE `author_id`=?");

        try {
            $stmt->execute([ $lastname, $firstname, $orcid, $affiliation, $author_id  ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = $e->getMessage();
        }

        if (!isset($error)){
            header("location: author-read.php?author_id=$author_id");
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
$_GET["author_id"] = trim($_GET["author_id"]);
if(isset($_GET["author_id"]) && !empty($_GET["author_id"])){
    $author_id =  trim($_GET["author_id"]);

    $sql = "SELECT * FROM `author` WHERE `author_id` = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        $param_id = $author_id;

        if (is_int($param_id)) $__vartype = "i";
        elseif (is_string($param_id)) $__vartype = "s";
        elseif (is_numeric($param_id)) $__vartype = "d";
        else $__vartype = "b"; // blob
        mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);


                $lastname = htmlspecialchars($row["lastname"] ?? "");
					$firstname = htmlspecialchars($row["firstname"] ?? "");
					$orcid = htmlspecialchars($row["orcid"] ?? "");
					$affiliation = htmlspecialchars($row["affiliation"] ?? "");
					

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
                                            <label for="lastname">Lastname*</label>
                                            <textarea name="lastname" id="lastname" class="form-control"><?php echo @$lastname; ?></textarea>
                                        </div>
						<div class="form-group">
                                            <label for="firstname">Firstname*</label>
                                            <textarea name="firstname" id="firstname" class="form-control"><?php echo @$firstname; ?></textarea>
                                        </div>
						<div class="form-group">
                                            <label for="orcid">ORCID*</label>
                                            <input type="text" name="orcid" id="orcid" maxlength="19" class="form-control" value="<?php echo @$orcid; ?>">
                                        </div>
						<div class="form-group">
                                            <label for="affiliation">Affiliation</label>
                                            <input type="text" name="affiliation" id="affiliation" maxlength="9" class="form-control" value="<?php echo @$affiliation; ?>">
                                        </div>

                        <input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
                        <p>
                            <input type="submit" class="btn btn-primary" value="<?php translate('Edit') ?>">
                            <a href="javascript:history.back()" class="btn btn-secondary"><?php translate('Cancel') ?></a>
                        </p>
                        <hr>
                        <p>
                            <a href="author-read.php?author_id=<?php echo $_GET["author_id"];?>" class="btn btn-info"><?php translate('View Record') ?></a>
                            <a href="author-delete.php?author_id=<?php echo $_GET["author_id"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                            <a href="author-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
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