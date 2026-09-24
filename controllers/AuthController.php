<?php
class AuthController {
 private User $users; public function __construct(){ $this->users=new User(); }
 public function showLogin(): void { render('auth/login',['title'=>'Sign In','lastLogin'=>$_COOKIE['last_login']??null]); }
 public function showRegister(): void { render('auth/register',['title'=>'Create Account']); }
 public function login(): void { verifyCsrf(); $email=trim($_POST['email']??''); $password=$_POST['password']??''; $u=$this->users->findByEmail($email); if(!$u || !password_verify($password,$u['password'])){ flash('error','Invalid email or password.'); redirect('login'); } $_SESSION['user']=['id'=>$u['id'],'first_name'=>$u['first_name'],'last_name'=>$u['last_name'],'email'=>$u['email']]; setcookie('last_login',date('Y-m-d H:i:s'),['expires'=>time()+604800,'path'=>'/','httponly'=>true,'samesite'=>'Lax']); flash('success','Welcome back, '.e($u['first_name']).'.'); redirect('photos'); }
 public function register(): void { verifyCsrf(); $d=['first_name'=>trim($_POST['first_name']??''),'last_name'=>trim($_POST['last_name']??''),'email'=>strtolower(trim($_POST['email']??'')),'password'=>$_POST['password']??'','location'=>trim($_POST['location']??''),'description'=>trim($_POST['description']??''),'occupation'=>trim($_POST['occupation']??'')]; if(!preg_match('/^[A-Za-z ]{2,50}$/',$d['first_name'])||!preg_match('/^[A-Za-z ]{2,50}$/',$d['last_name'])||!filter_var($d['email'],FILTER_VALIDATE_EMAIL)||strlen($d['password'])<8){ flash('error','Please provide valid details. Password must be at least 8 characters.'); redirect('register'); } if($this->users->findByEmail($d['email'])){ flash('error','This email is already registered.'); redirect('register'); } $this->users->create($d); flash('success','Account created. You can now sign in.'); redirect('login'); }
 public function logout(): void { $_SESSION=[]; session_destroy(); redirect('login'); }
}
?>
