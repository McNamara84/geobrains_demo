<?php
require_once('config.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

// Check existence of id parameter before processing further
$_GET["licence_id"] = trim($_GET["licence_id"]);
if(isset($_GET["licence_id"]) && !empty($_GET["licence_id"])){
    // Prepare a select statement
    $sql = "SELECT `licence`.* 
            FROM `licence` 
            WHERE `licence`.`licence_id` = ?
            GROUP BY `licence`.`licence_id`;";

    if($stmt = mysqli_prepare($link, $sql)){
        // Set parameters
        $param_id = trim($_GET["licence_id"]);

        // Bind variables to the prepared statement as parameters
		if (is_int($param_id)) $__vartype = "i";
		elseif (is_string($param_id)) $__vartype = "s";
		elseif (is_numeric($param_id)) $__vartype = "d";
		else $__vartype = "b"; // blob
        mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo translate('stmt_error') . "<br>".$stmt->error;
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php translate('View Record') ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<?php require_once('navbar.php'); ?>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="page-header">
                        <h1><?php translate('View Record') ?></h1>
                    </div>

                    									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['licence']["columns"]['text']);
									// echo '</pre>';
									$has_link_file = isset($tables_and_columns_names['licence']["columns"]['text']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['licence']["columns"]['text']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['text']) .'" target="_blank" class="uploaded_file" id="link_text">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>License Text*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["text"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['licence']["columns"]['code']);
									// echo '</pre>';
									$has_link_file = isset($tables_and_columns_names['licence']["columns"]['code']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['licence']["columns"]['code']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['code']) .'" target="_blank" class="uploaded_file" id="link_code">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>License Code</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["code"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									// Check if the column is file upload
									// echo '<pre>';
									// print_r($tables_and_columns_names['licence']["columns"]['url']);
									// echo '</pre>';
									$has_link_file = isset($tables_and_columns_names['licence']["columns"]['url']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['licence']["columns"]['url']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['url']) .'" target="_blank" class="uploaded_file" id="link_url">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Licence URL</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["url"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>
                    <hr>
                    <p>
                        <a href="licence-update.php?licence_id=<?php echo $_GET["licence_id"];?>" class="btn btn-warning"><?php translate('Update Record') ?></a>
                        <a href="licence-delete.php?licence_id=<?php echo $_GET["licence_id"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                        <a href="licence-create.php" class="btn btn-success"><?php translate('Add New Record') ?></a>
                        <a href="licence-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
                    </p>
                    <?php
                    

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </section>
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