<?php
function parse_columns($table_name, $postdata)
{
    global $link;
    $vars = array();

    $default = null;

    $sql = "SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT, EXTRA
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = '" . $table_name . "'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {

        $debug = 0;
        if ($debug) {
            echo "<pre>";
            echo $row['COLUMN_NAME'] . "\t";
            echo $row['DATA_TYPE'] . "\t";
            echo $row['IS_NULLABLE'] . "\t";
            echo $row['COLUMN_DEFAULT'] . "\t";
            echo $row['EXTRA'] . "\t";
            echo $default . "\n";
            echo "</pre>";
        }

        switch ($row['DATA_TYPE']) {

            // https://dev.mysql.com/doc/refman/5.7/en/sql-mode.html
            case 'decimal':
                $default = 0;
                break;

            case 'datetime':
                if ($row['COLUMN_DEFAULT'] != 'CURRENT_TIMESTAMP' && $row['IS_NULLABLE'] == 'YES') {
                    $default = null;
                } else {
                    $default = date('Y-m-d H:i:s');
                }
                if ($postdata[$row['COLUMN_NAME']] == 'CURRENT_TIMESTAMP') {
                    $_POST[$row['COLUMN_NAME']] = date('Y-m-d H:i:s');
                }
                break;
        }

        $vars[$row['COLUMN_NAME']] = isset($_POST[$row['COLUMN_NAME']]) && $_POST[$row['COLUMN_NAME']] ? trim($_POST[$row['COLUMN_NAME']]) : $default;
    }
    return $vars;
}

function get_columns_attributes($table_name, $column)
{
    global $link;
    $sql = "SELECT COLUMN_DEFAULT, COLUMN_COMMENT
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = '" . $table_name . "'
            AND column_name = '" . $column . "'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $debug = 0;
        if ($debug) {
            echo "<pre>";
            print_r($row);
            echo "</pre>";
        }
        return $row;
    }
}

function print_error_if_exists($error)
{
    if (isset($error)) {
        if (!is_array($error)) {
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        } else {
            foreach ($error as $err) {
                echo "<div class='alert alert-danger' role='alert'>$err</div>";
            }
        }
    }
}

function convert_date($date_str)
{
    if (isset($date_str)) {
        $date = date('d-m-Y', strtotime($date_str));
        return htmlspecialchars($date);
    }
}

function convert_datetime($date_str)
{
    if (isset($date_str)) {
        $date = date('d-m-Y H:i:s', strtotime($date_str));
        return htmlspecialchars($date);
    }
}

function convert_bool($var)
{
    if (isset($var)) {
        return $var ? "True" : "False";
    }
}

function get_fk_url($value, $fk_table, $fk_column, $representation, bool $pk=false, bool $index=false)
{
    if (isset($value)) {
        $value = htmlspecialchars($value);
        if($pk)
        {
            return '<a href="' . $fk_table . '-read.php?' . $fk_column . '=' . $value . '">' . $representation . '</a>';
        }
        else
        {
            return '<a href="' . $fk_table . '-index.php?' . $fk_column . '=' . $value . '">' . $representation . '</a>';
        }
    }
}

function translate($key, $echo = true, ...$args)
{
    global $translations;

    if (isset($translations[$key])) {
        if ($echo) {
            echo sprintf($translations[$key], ...$args);
        } else {
            return sprintf($translations[$key], ...$args);
        }
    } else {
        if ($echo) {
            echo $key;
        } else {
            return $key;
        }
    }
}




function handleFileUpload($FILE) {

    global $upload_max_size;
    global $upload_target_dir;
    global $upload_disallowed_exts;

    $upload_results     = array();
    $sanitized_fileName = sanitize(basename($FILE["name"]));
    $unique_filename    = generateUniqueFileName($sanitized_fileName);
    $target_file        = $upload_target_dir . $unique_filename;
    $extension          = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!file_exists($upload_target_dir)) {
        mkdir($upload_target_dir, 0777, true);

        file_put_contents($upload_target_dir . '/index.php', '');
    } else {
    }

    if (file_exists($target_file)) {
        $upload_results['error'] = "Sorry, the file " . htmlspecialchars(basename($FILE["name"])) . " already exists.";
        return $upload_results;
    }

    if ($FILE["size"] > $upload_max_size) {
        $upload_results['error'] = "Sorry, the file " . htmlspecialchars(basename($FILE["name"])) . " is too large.";
        return $upload_results;
    }

    if (in_array($extension, $upload_disallowed_exts)) {
        $upload_results['error'] = "Sorry, uploading files with extension $extension is not allowed.";
        return $upload_results;
    }

    if (empty($upload_results)) {
        if (move_uploaded_file($FILE["tmp_name"], $target_file)) {
            $upload_results['success'] = $unique_filename;
        } else {
            $upload_results['error'] = "Sorry, there was an error uploading the file " . htmlspecialchars(basename($FILE["name"])) . ".";
        }
    }
    return $upload_results;
}



function sanitize($fileName) {
    $fileName = str_replace(array('<', '>', ':', '"', '/', '\\', '|', '?', '*'), '', $fileName);

    if (class_exists('Normalizer')) {
        $fileName = Normalizer::normalize($fileName, Normalizer::FORM_C);
    }

    $fileName = str_replace(' ', '_', $fileName);

    $fileName = strtolower($fileName);

    $fileName = substr($fileName, 0, 255);

    return $fileName;
}



function sanitizePath($path) {
    $parts = explode('/', $path);

    foreach ($parts as &$part) {
        if ($part === '.' || $part === '..') {
            continue;
        }

        $part = str_replace(array('<', '>', ':', '"', '|', '?', '*'), '', $part);

        if (class_exists('Normalizer')) {
            $part = Normalizer::normalize($part, Normalizer::FORM_C);
        }

        $part = strtolower(str_replace(' ', '_', $part));

        $part = substr($part, 0, 255);
    }

    return implode('/', $parts);
}



function generateUniqueFileName($originalFileName) {
    $timestamp = time();
    $salt = uniqid();
    $uniquePrefix = $timestamp . '_' . $salt . '_';

    return $uniquePrefix . $originalFileName;
}



function getUploadResultByErrorCode($code) {
    // https://www.php.net/manual/en/features.file-upload.errors.php
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    return $phpFileUploadErrors[$code];
}



function truncate($string, $length = 15) {
    $decodedString = html_entity_decode($string);

    if (mb_strlen($decodedString) > $length) {
        $truncated = htmlspecialchars(mb_substr($decodedString, 0, $length)) . '...';
    } else {
        $truncated = htmlspecialchars($string);
    }

    return $truncated;
}



function findConfigFile() {

}



function getConfigDirectories($baseDir, $excludedDirs = ['locales', 'templates']) {
    $dirs = array_filter(glob($baseDir . '/*', GLOB_ONLYDIR), function ($dir) use ($excludedDirs) {
        return !in_array(basename($dir), $excludedDirs);
    });

    $configDirs = [];
    foreach ($dirs as $dir) {
        if (file_exists($dir . '/config.php')) {
            $configDirs[] = basename($dir);
        }
    }

    return $configDirs;
}



function exportAsCSV($data, $db_name, $tables_and_columns_names, $table_name, $link, $debug = false) {

    $relations = get_foreign_key_relations($link, $db_name);

    $headers = extract_csv_headers($relations, $tables_and_columns_names, $table_name, $debug);

    $lines = [];
    foreach($data as $row) {
        $lines[] = extract_csv_data($row, $relations, $db_name, $tables_and_columns_names, $table_name, $link, $debug);
    }

    if ($debug) {
        echo "<pre>";
        print_r($headers);
        print_r($lines);
        echo "</pre>";
    }

    create_csv($headers, $lines, $table_name, $debug);
}



function create_csv($headers, $lines, $table_name, $debug = false) {

    if (!$debug) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $table_name . '_export.csv"');
    }

    $output = fopen($debug ? 'php://output' : 'php://temp', 'w+');

    fputcsv($output, array_values($headers));

    foreach($lines as $line) {
        fputcsv($output, $line);
    }

    if (!$debug) {
        rewind($output);
        fpassthru($output);
        fclose($output);
    }
}



function extract_csv_data($row, $relations, $db_name, $tables_and_columns_names, $table_name, $link, $debug = false) {
    $line = [];

    foreach ($tables_and_columns_names[$table_name]['columns'] as $column_name => $column_config) {
        if ($column_config['columnvisible']) {
            $value = $row[$column_name];

            $relation = find_relation_by_column($relations, $column_name);

            if ($relation !== NULL) {
                if ($debug) {
                    echo "<br>FK <strong>".$relation['table'].'.'.$relation['column']. '</strong> : '.$tables_and_columns_names[$relation['table']]['columns'][$relation['column']]['columndisplay'];
                }

                $primary = find_primary_key_from_config($table_name, $tables_and_columns_names);

                if ($debug) {
                    echo "<br>&nbsp;value: " . $value;
                }

                if ($value !== null) {
                    $related_value = get_related_table_data($link, $relation['table'], $primary, $value, $debug);
                } else {
                    $related_value = null;
                }

                foreach($tables_and_columns_names[$relation['table']]['columns'] as $related_column => $related_column_config) {
                    if ($related_column_config['columninpreview']) {

                        if ($related_column_config['columninpreview']) {

                            if ($debug) {
                                if ($value !== null) {
                                    echo "<br>&nbsp;related value: " . $related_value[$related_column];
                                } else {
                                    echo "<br>&nbsp;related value: <code>null</code>";
                                }
                            }

                            if ($value !== null) {
                                $line[] = $related_value[$related_column];
                            } else {
                                $line[] = null;
                            }
                        }
                    }
                }

            }
            else {
                if ($debug) {
                    echo "<br>column <code>$column_name</code> (".$value.')';
                }
                $line[] = $value;
            }
        }
    }

    if ($debug) {
        echo "<hr>";
    }

    return $line;
}



function get_related_table_data($link, $referenced_table_name, $primary, $value, $debug = false) {

    $sql = "
        SELECT *
        FROM   `$referenced_table_name`
        WHERE  `$referenced_table_name`.`$primary` = $value
    ";

    if ($debug) {
        echo '<pre>';
        print_r($sql);
        echo '</pre>';
    }

    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}



function extract_csv_headers($relations, $tables_and_columns_names, $table_name, $debug = false) {
    $headers = [];

    foreach ($tables_and_columns_names[$table_name]['columns'] as $column => $column_config) {
        if ($column_config['columnvisible']) {

            $relation = find_relation_by_column($relations, $column);

            if ($relation !== NULL) {
                if ($debug) {
                    echo "<br>FK <strong>".$relation['table'].'.'.$relation['column']. '</strong> : '.$tables_and_columns_names[$relation['table']]['columns'][$relation['column']]['columndisplay'];
                }

                foreach($tables_and_columns_names[$relation['table']]['columns'] as $related_column => $related_column_config) {
                    if ($related_column_config['columninpreview']) {

                        if ($related_column_config['columninpreview']) {

                            if ($column_config['columndisplay'] == $related_column_config['columndisplay']) {
                                $title = $related_column_config['columndisplay'];
                            } else {
                                $title = $column_config['columndisplay'] . ' - ' . $related_column_config['columndisplay'];
                            }

                            if ($debug) {
                                echo "<br>&nbsp;related <code>".$related_column. '</code> ('.$title.')';
                            }
                            $headers[] =  $title;
                        }
                    }
                }
            }
            else {
                if ($debug) {
                    echo "<br>column <code>$column</code> (".$column_config['columndisplay'].')';
                }
                $headers[] = $column_config['columndisplay'];
            }
        }
    }
    return $headers;
}



function get_foreign_key_relations($link, $db_name) {
    $sql = "
        SELECT
            TABLE_NAME,
            COLUMN_NAME,
            CONSTRAINT_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE
            REFERENCED_TABLE_SCHEMA = '$db_name'
    ";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $rows;
}



function find_relation_by_column($relations, $column_name) {
    foreach ($relations as $relation) {
        if ($relation['COLUMN_NAME'] === $column_name) {
            return [
                'table' => $relation['REFERENCED_TABLE_NAME'],
                'column' => $relation['REFERENCED_COLUMN_NAME'],
            ];
        }
    }
    return NULL;
}



function find_primary_key_from_config($table_name, $tables_and_columns_names) {
    foreach ($tables_and_columns_names[$table_name]['columns'] as $column_name => $column_config) {
        if ($column_config['primary']) {
            return $column_name;
        }
    }
}