<?php
/**
 * ================================================================
 *  DATABASE CONFIGURATION — production & local
 * ================================================================
 */

define('DB_HOST', getenv('DB_HOST') ?: 'mysql-393297ae-okhelfaoui23-4e85.f.aivencloud.com');
define('DB_PORT', getenv('DB_PORT') ?: '24322');
define('DB_NAME', getenv('DB_NAME') ?: 'defaultdb');
define('DB_USER', getenv('DB_USER') ?: 'avnadmin');
define('DB_PASS', getenv('DB_PASS') ?: 'AVNS_MvfQ9gxbGcpizuEpAeF');
