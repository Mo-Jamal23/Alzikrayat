<?php
class Photo extends Model {
 public function all(): array { return $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) author FROM photos p JOIN users u ON u.id=p.user_id ORDER BY p.date_time DESC')->fetchAll(); }
 public function find(int $id): ?array { $s=$this->db->prepare('SELECT p.*, CONCAT(u.first_name," ",u.last_name) author FROM photos p JOIN users u ON u.id=p.user_id WHERE p.id=?'); $s->execute([$id]); return $s->fetch() ?: null; }
 public function create(int $userId,string $file,string $title,?string $description): int { $s=$this->db->prepare('INSERT INTO photos(user_id,file_name,title,description) VALUES(?,?,?,?)'); $s->execute([$userId,$file,$title,$description]); return (int)$this->db->lastInsertId(); }
 public function delete(int $id,int $userId): bool { $s=$this->db->prepare('DELETE FROM photos WHERE id=? AND user_id=?'); $s->execute([$id,$userId]); return $s->rowCount()>0; }
}
?>
