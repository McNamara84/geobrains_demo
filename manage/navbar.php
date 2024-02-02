<?php require_once('config-tables-columns.php'); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand nav-link" href="index.php">GEOBRAINS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Datensätze</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="author-index.php">Autoren</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <?php translate('Einstellungen') ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="language-index.php">
            <?php echo (!empty($tables_and_columns_names["language"]["name"])) ? $tables_and_columns_names["language"]["name"] : "language" ?>
          </a>
          <a class="dropdown-item" href="licence-index.php">
            <?php echo (!empty($tables_and_columns_names["licence"]["name"])) ? $tables_and_columns_names["licence"]["name"] : "licence" ?>
          </a>
          <a class="dropdown-item" href="resource_type-index.php">
            <?php echo (!empty($tables_and_columns_names["resource_type"]["name"])) ? $tables_and_columns_names["resource_type"]["name"] : "resource_type" ?>
          </a>
          <a class="dropdown-item" href="role-index.php">
            <?php echo (!empty($tables_and_columns_names["role"]["name"])) ? $tables_and_columns_names["role"]["name"] : "role" ?>
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>