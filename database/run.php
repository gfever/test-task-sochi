<?php
/**
 * @author d.ivaschenko
 */

$config = include __DIR__ . '/../config/database.php';
$command = 'mysql'
    . ' --host=' . $config['host']
    . ' --user=' . $config['username']
    . ' --password=' . $config['password']
    . ' --database=' . $config['dbname']
    . ' --execute="SOURCE ' . __DIR__ . '/db.sql"';


$output1 = shell_exec($command);