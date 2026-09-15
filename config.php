<?php
/**
 * ================================================================
 *  DATABASE CONFIGURATION — edit this ONE file when you deploy
 * ================================================================
 *  The values below are your LOCAL (XAMPP) defaults and work
 *  exactly as they are on your PC.
 *
 *  WHEN DEPLOYING TO AWARDSPACE:
 *    1. Log in to your AwardSpace control panel.
 *    2. Open  MySQL Management  and CREATE a new database.
 *    3. The panel shows these details — copy them into this file:
 *
 *       DB_HOST  -> looks like:  a1234567.mysql.awardspace.net
 *       DB_NAME  -> looks like:  a1234567_portfolio
 *       DB_USER  -> the MySQL username the panel gives you
 *       DB_PASS  -> the MySQL password the panel gives you
 *       DB_PORT  -> leave as 3306 (AwardSpace uses the default)
 *  ================================================================
 */

define('DB_HOST', '127.0.0.1');   // XAMPP local. AwardSpace: e.g. a1234567.mysql.awardspace.net
define('DB_PORT', '3307');        // XAMPP local. AwardSpace: change to 3306
define('DB_NAME', 'portfolio_db');// XAMPP local. AwardSpace: e.g. a1234567_portfolio
define('DB_USER', 'root');        // XAMPP local. AwardSpace: your MySQL username
define('DB_PASS', '1234');        // XAMPP local. AwardSpace: your MySQL password