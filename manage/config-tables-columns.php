<?php

$tables_and_columns_names = array (
  'author' => 
  array (
    'name' => 'Author',
    'columns' => 
    array (
      'author_id' => 
      array (
        'columndisplay' => 'Author ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'lastname' => 
      array (
        'columndisplay' => 'Lastname',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 1,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'firstname' => 
      array (
        'columndisplay' => 'Firstname',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 1,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'orcid' => 
      array (
        'columndisplay' => 'ORCID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 1,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'affiliation' => 
      array (
        'columndisplay' => 'Affiliation',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'language' => 
  array (
    'name' => 'Languages',
    'columns' => 
    array (
      'language_id' => 
      array (
        'columndisplay' => 'Language ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'code' => 
      array (
        'columndisplay' => 'Language Code',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'name' => 
      array (
        'columndisplay' => 'Language Name',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'licence' => 
  array (
    'name' => 'Licenses',
    'columns' => 
    array (
      'licence_id' => 
      array (
        'columndisplay' => 'License ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'text' => 
      array (
        'columndisplay' => 'License Text',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'code' => 
      array (
        'columndisplay' => 'License Code',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'url' => 
      array (
        'columndisplay' => 'Licence URL',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'resource' => 
  array (
    'name' => 'Resources',
    'columns' => 
    array (
      'resource_id' => 
      array (
        'columndisplay' => 'Resource ID',
        'is_file' => 0,
        'columnvisible' => 0,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'doi' => 
      array (
        'columndisplay' => 'DOI',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'title' => 
      array (
        'columndisplay' => 'Resource Title',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'version' => 
      array (
        'columndisplay' => 'Version',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'year' => 
      array (
        'columndisplay' => 'Publication Year',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Licence_licence_id' => 
      array (
        'columndisplay' => 'License ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Resource_Type_resource_name_id' => 
      array (
        'columndisplay' => 'Resource Type ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Language_language_id' => 
      array (
        'columndisplay' => 'Language ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'resource_type' => 
  array (
    'name' => 'Resource Types',
    'columns' => 
    array (
      'resource_name_id' => 
      array (
        'columndisplay' => 'Resource Type ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'description' => 
      array (
        'columndisplay' => 'Resource Type Description',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'resource_name' => 
      array (
        'columndisplay' => 'Resource Type Name',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'role' => 
  array (
    'name' => 'Roles',
    'columns' => 
    array (
      'role_id' => 
      array (
        'columndisplay' => 'Role ID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'name' => 
      array (
        'columndisplay' => 'Role Name',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 1,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'description' => 
      array (
        'columndisplay' => 'Role Description',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
);

?>