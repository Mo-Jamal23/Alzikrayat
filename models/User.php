<?php
class User extends Model {
 public function findByEmail(string $email): ?array { $s=$this->db->prepare('SELECT * FROM users WHERE email=? LIMIT 1'); $s->execute([$email]); return $s->fetch() ?: null; }
 public function create(array $d): int { $s=$this->db->prepare('INSERT INTO users(first_name,last_name,email,password,location,description,occupation) VALUES(?,?,?,?,?,?,?)'); $s->execute([$d['first_name'],$d['last_name'],$d['email'],password_hash($d['password'],PASSWORD_DEFAULT),$d['location']?:null,$d['description']?:null,$d['occupation']?:null]); return (int)$this->db->lastInsertId(); }
 public function count(): int { return (int)$this->db->query('SELECT COUNT(*) FROM users')->fetchColumn(); }
}
?>
