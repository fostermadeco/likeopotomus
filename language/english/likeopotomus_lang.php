<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$lang = array(
    "likeopotomus_module_name" => "Likeopotomus",
    "likeopotomus_module_description" => "Provides bookmarking & liking support",

    // Settings
    "auth_token" => "Use Auth tokken?",
    "auth_token_desc" => "Enable this if you are using an authentication token over ExpressionEngine's in-built auth methods.",
    "auth_token_name" => "Auth token name:",
    "auth_token_name_desc" => "Name of the global variable where the OAuth token is stored in ExpressionEngine.
        <br />
        eg. 'auth_token' would look at ee()->config->_global_vars['auth_token']",

    // Module's tag function default add / delete text
    "add" => "Add",
    "delete" => "Delete"
);