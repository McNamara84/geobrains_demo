<?php
require_once('config.php');
require_once('helpers.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $upload_results = array();
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $value) {
            if ($value['error'] != UPLOAD_ERR_NO_FILE) {
                $this_upload = handleFileUpload($_FILES[$key]);
                $upload_results[] = $this_upload;
                if (!in_array(true, array_column($this_upload, 'error')) && !array_key_exists('error', $this_upload)) {
                    $_POST[$key] = $this_upload['success'];
                }
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



        $stmt = $link->prepare("INSERT INTO `author` (`lastname`, `firstname`, `orcid`, `affiliation`) VALUES (?, ?, ?, ?)");

        try {
            $stmt->execute([$lastname, $firstname, $orcid, $affiliation]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = $e->getMessage();
        }

        if (!isset($error)) {
            $new_id = mysqli_insert_id($link);
            header("location: author-read.php?author_id=$new_id");
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php translate('Add New Record') ?>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<?php require_once('navbar.php'); ?>

<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>
                            <?php translate('Add New Record') ?>
                        </h2>
                    </div>
                    <?php print_error_if_exists(@$upload_errors); ?>
                    <?php print_error_if_exists(@$error); ?>
                    <p>
                        <?php translate('add_new_record_instructions') ?>
                    </p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="lastname">Lastname*</label>
                            <textarea name="lastname" id="lastname"
                                class="form-control"><?php echo @$lastname; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="firstname">Firstname*</label>
                            <textarea name="firstname" id="firstname"
                                class="form-control"><?php echo @$firstname; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="orcid">ORCID*</label>
                            <input type="text" name="orcid" id="orcid" maxlength="19" class="form-control"
                                value="<?php echo @$orcid; ?>">
                        </div>
                        <div class="form-group">
                            <label for="affiliation">Affiliation</label>
                            <input type="text" name="affiliation" id="affiliation" maxlength="9" class="form-control"
                                value="<?php echo @$affiliation; ?>">
                        </div>

                        <input type="submit" class="btn btn-primary" value="<?php translate('Create') ?>">
                        <a href="author-index.php" class="btn btn-secondary">
                            <?php translate('Cancel') ?>
                        </a>
                    </form>
                    <p><small>
                            <?php translate('required_fiels_instructions') ?>
                        </small></p>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>