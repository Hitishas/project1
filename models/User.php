<?php
require_once __DIR__ . '/../include/db.php';

class User
{
    public static function findByEmail($email)
    {
        $mysqli = db();
        $sql = "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public static function findById($id)
    {
        $mysqli = db();
        $sql = "SELECT id, name, email FROM users WHERE id = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public static function create($name, $email, $password)
    {
        $mysqli = db();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sss', $name, $email, $hash);
        return $stmt->execute();
    }
}
