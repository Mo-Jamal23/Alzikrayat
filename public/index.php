<?php
require_once __DIR__.'/../core/bootstrap.php'; require_once __DIR__.'/../core/Model.php'; require_once __DIR__.'/../core/Router.php';
foreach (glob(__DIR__.'/../models/*.php') as $file) require_once $file; foreach (glob(__DIR__.'/../controllers/*.php') as $file) require_once $file;
$router=new Router(); $auth=new AuthController(); $photos=new PhotoController(); $comments=new CommentController();
$router->add('GET','/','home'); $router->add('GET','/about','about');
$router->add('GET','/login',[$auth,'showLogin']); $router->add('POST','/login',[$auth,'login']); $router->add('GET','/register',[$auth,'showRegister']); $router->add('POST','/register',[$auth,'register']); $router->add('GET','/logout',[$auth,'logout']);
$router->add('GET','/photos',[$photos,'index']); $router->add('GET','/photo/([0-9]+)',[$photos,'show']); $router->add('GET','/photo/create',[$photos,'create']); $router->add('POST','/photo/store',[$photos,'store']); $router->add('POST','/photo/([0-9]+)/delete',[$photos,'delete']); $router->add('POST','/photo/([0-9]+)/comment',[$comments,'store']);
function home(){ $stats=['users'=>0,'photos'=>0,'comments'=>0]; if(databaseAvailable()){ $db=Database::connection(); $stats['users']=(int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn(); $stats['photos']=(int)$db->query('SELECT COUNT(*) FROM photos')->fetchColumn(); $stats['comments']=(int)$db->query('SELECT COUNT(*) FROM comments')->fetchColumn(); } render('home/index',['title'=>'Home','stats'=>$stats]); }
function about(){ render('home/about',['title'=>'About Alzikrayat']); }
$router->dispatch($_SERVER['REQUEST_METHOD']??'GET',$_SERVER['REQUEST_URI']??'/');
?>
