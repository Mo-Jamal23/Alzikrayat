<?php
class CommentController { public function store(string $id): void { requireAuth(); verifyCsrf(); $comment=trim($_POST['comment']??''); if($comment==='' || mb_strlen($comment)>1000){ flash('error','Comment must contain 1-1000 characters.'); redirect('photo/'.$id); } $photo=new Photo(); if(!$photo->find((int)$id)){ http_response_code(404); exit('Photo not found.'); } (new Comment())->create((int)$id,(int)currentUser()['id'],$comment); flash('success','Comment added.'); redirect('photo/'.$id); } }
?>
