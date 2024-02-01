<?php
require_once('config.php');
require_once('helpers.php');
require_once('config-tables-columns.php');

$_GET["resource_id"] = trim($_GET["resource_id"]);
if(isset($_GET["resource_id"]) && !empty($_GET["resource_id"])){
    $sql = "SELECT `resource`.* 
            FROM `resource` 
            WHERE `resource`.`resource_id` = ?
            GROUP BY `resource`.`resource_id`;";

    if($stmt = mysqli_prepare($link, $sql)){
        $param_id = trim($_GET["resource_id"]);

		if (is_int($param_id)) $__vartype = "i";
		elseif (is_string($param_id)) $__vartype = "s";
		elseif (is_numeric($param_id)) $__vartype = "d";
		else $__vartype = "b";
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
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['doi']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['doi']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['doi']) .'" target="_blank" class="uploaded_file" id="link_doi">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>DOI</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["doi"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['title']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['title']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['title']) .'" target="_blank" class="uploaded_file" id="link_title">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Resource Title*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["title"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['version']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['version']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['version']) .'" target="_blank" class="uploaded_file" id="link_version">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Version</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["version"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['year']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['year']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['year']) .'" target="_blank" class="uploaded_file" id="link_year">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Publication Year*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["year"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['Licence_licence_id']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['Licence_licence_id']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Licence_licence_id']) .'" target="_blank" class="uploaded_file" id="link_Licence_licence_id">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>License ID*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["Licence_licence_id"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['Resource_Type_resource_name_id']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['Resource_Type_resource_name_id']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Resource_Type_resource_name_id']) .'" target="_blank" class="uploaded_file" id="link_Resource_Type_resource_name_id">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Resource Type ID*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["Resource_Type_resource_name_id"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>									<?php
									$has_link_file = isset($tables_and_columns_names['resource']["columns"]['Language_language_id']['is_file']) ? true : false;
									if ($has_link_file){
									    $is_file = $tables_and_columns_names['resource']["columns"]['Language_language_id']['is_file'];
									    $link_file = $is_file ? '<a href="uploads/'. htmlspecialchars($row['Language_language_id']) .'" target="_blank" class="uploaded_file" id="link_Language_language_id">' : '';
									    $end_link_file = $is_file ? "</a>" : "";
									}
									?>
									<div class="form-group">
									    <h4>Language ID*</h4>
									    <?php if ($has_link_file): ?>
									        <p class="form-control-static"><?php echo $link_file ?><?php echo htmlspecialchars($row["Language_language_id"] ?? ""); ?><?php echo $end_link_file ?></p>
									    <?php endif ?>
									</div>
                    <hr>
                    <p>
                        <a href="resource-update.php?resource_id=<?php echo $_GET["resource_id"];?>" class="btn btn-warning"><?php translate('Update Record') ?></a>
                        <a href="resource-delete.php?resource_id=<?php echo $_GET["resource_id"];?>" class="btn btn-danger"><?php translate('Delete Record') ?></a>
                        <a href="resource-create.php" class="btn btn-success"><?php translate('Add New Record') ?></a>
                        <a href="resource-index.php" class="btn btn-primary"><?php translate('Back to List') ?></a>
                    </p>
                    <?php
                    $html = "";
                    $id = is_numeric($row["resource_id"]) ? $row["resource_id"] : "'".$row["resource_id"]."'";
                    $sql = "SELECT COUNT(*) AS count FROM `resource_has_author` WHERE `Resource_resource_id` = ". $id . ";";
                    $number_of_refs = mysqli_fetch_assoc(mysqli_query($link, $sql))["count"];
                    if ($number_of_refs > 0)
                    {
                        $html .= '<p><a href="resource_has_author-index.php?Resource_resource_id='. $row["resource_id"].'" class="btn btn-info">' . translate("references_view_btn", false, $number_of_refs, "resource_has_author", "Resource_resource_id", $row["resource_id"]) .'</a></p></p>';
                    }if ($html != "") {echo "<h3>" . translate("references_tables", false, "resource") . "</h3>" . $html;}

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