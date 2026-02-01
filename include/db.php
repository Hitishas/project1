<?php
// Database helper that wraps the existing mysqli connection from config.php
require_once __DIR__ . '/config.php';

function db()
{
    global $con;
    return $con;
}

function db_query($sql, $params = [])
{
    $mysqli = db();
    if (empty($params)) {
        return $mysqli->query($sql);
    }
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $types = '';
    $values = [];
    foreach ($params as $p) {
        if (is_int($p)) $types .= 'i';
        elseif (is_double($p) || is_float($p)) $types .= 'd';
        else $types .= 's';
        $values[] = $p;
    }
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}
