<?php
class Router {
 private array $routes=[];
 public function add(string $method,string $pattern,callable $handler): void { $normalized = $pattern === '/' ? '/' : rtrim($pattern,'/'); $this->routes[] = [$method, '#^'.$normalized.'$#', $handler]; }
 public function dispatch(string $method,string $uri): void {
  $path=parse_url($uri,PHP_URL_PATH) ?: '/'; $base=rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''),'/'); if($base && str_starts_with($path,$base)) $path=substr($path,strlen($base)) ?: '/';
  $path='/'.trim($path,'/'); if($path!=='/') $path=rtrim($path,'/');
  foreach($this->routes as [$m,$pattern,$handler]) { if($m!==$method) continue; if(preg_match($pattern,$path,$matches)) { array_shift($matches); $handler(...$matches); return; } }
  http_response_code(404); render('home/404',['title'=>'Page Not Found']);
 }
}
?>
