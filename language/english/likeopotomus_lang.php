<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$lang = array(
    "likeopotomus_module_name" => "Likeopotomus",
    "likeopotomus_module_description" => "Provides bookmarking & liking support",

    // Settings
    "auth_token" => "Use Auth tokken?",
    "auth_token_desc" => "Enable this if you are using an authentication token over ExpressionEngine's in-built auth methods.",
    "auth_token_path" => "Auth token path:",
    "auth_token_path_desc" => "Enter the path where the auth token is stored in the session variable, with each array key separated by a comma.
        <br />
        For example, if the token is stored in " . '$_SESSION' . "['foo']['bar'] enter 'foo,bar'",

    // Module's tag function default add / delete text
    "add" => "Add",
    "delete" => "Delete"
);