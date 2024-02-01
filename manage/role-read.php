<?php
require_once('config.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

$_GET["role_id"] = trim($_GET["role_id"]);
if(isset($_GET["role_id"]) && !empty($_GET["role_id"])){
    $sql = "SELECT `role`.* 
            FROM `role` 
            WHERE `role`.`role_id` = ?
            GROUP BY `role`.`role_id`;";

    if($stmt = mysqli_prepare($link, $sql)){
        $param_id = trim($_GET["role_id"]);

		if (is_int($param_id)) $__vartype = "i";
		elseif (is_string($param_id)) $__vartype = "s";
		elseif (is_numeric($param_id)) $__vartype = "d";
		else $__vartype = "b"; // blob
        mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else{
                header("location: error.php");
                exit();
            }

        } else{
            echo translate('stmt_error') . "<br>".$stmt->error;
        }
    }

    mysqli_stmt_close($stmt);

} else{
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
									$has_link_file = isset($tables_and_columns_names['role']["columns"]['name']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['role']["columns"]['name']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['name']) .'" target="_blank" class="uploaded_file" id="link_name">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Role Name*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["name"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['role']["columns"]['description']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['role']["columns"]['description']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['description']) .'" target="_blank" class="uploaded_file" id="link_description">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Role Description</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo nl2br(htmlspecialchars($row["description"] ?? "")); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>
                    <hr>
                    <p>
                        <a href="role-update.php?role_id=<?php echo $_GET["role_id"];?>" class="btn btn-warning"><?php translate('Update Record') ?></a>
                        <a href="role-delete.php?role_id=<?php echo $_GET["role_id"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                        <a href="role-create.php" class="btn btn-success"><?php translate('Add New Record') ?></a>
                        <a href="role-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
                    </p>
                    <?php
                    $html = "";
                    $id = is_numeric($row["role_id"]) ? $row["role_id"] : "'".$row["role_id"]."'";
                    $sql = "SELECT COUNT(*) AS count FROM `author_has_role` WHERE `Role_role_id` = ". $id . ";";
                    $number_of_refs = mysqli_fetch_assoc(mysqli_query($link, $sql))["count"];
                    if ($number_of_refs > 0)
                    {
                        $html .= '<p><a href="author_has_role-index.php?Role_role_id='. $row["role_id"].'" class="btn btn-info">' . translate("references_view_btn", false, $number_of_refs, "author_has_role", "Role_role_id", $row["role_id"]) .'</a></p></p>';
                    }if ($html != "") {echo "<h3>" . translate("references_tables", false, "role") . "</h3>" . $html;}

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