<?php

namespace Rodeliza\Dbmodel\Models;

use Rodeliza\Dbmodel\Includes\Database;


class Task extends Database {
    private $db;

    public function __construct() {
        parent::__construct(); // Call the parent constructor to establish the connection
        $this->db = $this->getConnection(); // Get the connection instance
    }

    public function getTasks() {
        $sql = "SELECT * FROM todotask";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTask($id) {
        $sql = "SELECT * FROM todotask WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createTask($data) {
        $sql = "INSERT INTO todotask (task, status) VALUES (:task, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'task' => $data['task'],
            'status' => $data['status'] ?? 'pending' 
        ]);
        return $this->db->lastInsertId();
    }

    public function updateTask($data) {
        $sql = "UPDATE todotask SET task = :task, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'task' => $data['task'],
            'status' => $data['status']
        ]);
        return "Record UPDATED successfully";
    }

    public function deleteTask($id) {
        $sql = "DELETE FROM todotask WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return "Record DELETED successfully";
    }   
}