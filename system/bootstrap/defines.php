<?php

$PHPSELF = $_SERVER['PHP_SELF'];
$PHPSELF = str_replace('index.php', '', $PHPSELF);
$BRANCH = trim($PHPSELF, '/');

# get the actual SCRIPT_FILENAME (e.g.: /home/.../site/public/index.php)
# and removes public/index.php from get path to this project
$PATH  = $_SERVER['SCRIPT_FILENAME'];
$PATH  = dirname($PATH, 2);
$PATH .= "/";

#
$SCHEME  = 'http';
$SCHEME .= isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'? 's': '';

# lowered method
$REQUEST_METHOD = strtolower($_SERVER['REQUEST_METHOD']);

$SERVERNAME = $_SERVER['SERVER_NAME'];

# get actual url
$BASE = "{$SCHEME}://{$SERVERNAME}/{$BRANCH}";

# this is the url base of this project
define('BASE',   $BASE);

# this is the PATH to this project
define('PATH', $PATH);

# this is the scheme of the project: http, https...
define('SCHEME', $SCHEME);

# this is the method of the project: get, post, put...
define('REQUEST_METHOD', $REQUEST_METHOD);

# this is the branch that someone is tryng to access:
# users, users/test, about...
# empty branch is like home route
define('BRANCH', $BRANCH);
