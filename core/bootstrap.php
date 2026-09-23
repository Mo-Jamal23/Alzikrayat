<?php
session_start();
require_once __DIR__.'/../config/database.php';
function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function redirect(string $path): never { header('Location: '.baseUrl($path)); exit; }
function baseUrl(string $path=''): string { $base = rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/'); return $base.'/'.ltrim($path,'/'); }
function isPost(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function csrfToken(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verifyCsrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid security token.'); } }
function currentUser(): ?array { return $_SESSION['user'] ?? null; }
function requireAuth(): void { if (!currentUser()) redirect('login'); }
function flash(string $type, string $message): void { $_SESSION['flash'] = compact('type','message'); }
function consumeFlash(): ?array { $f=$_SESSION['flash']??null; unset($_SESSION['flash']); return $f; }
function render(string $view, array $data=[]): void { extract($data); $flash=consumeFlash(); require __DIR__.'/../views/layouts/header.php'; require __DIR__.'/../views/'.$view.'.php'; require __DIR__.'/../views/layouts/footer.php'; }
?>
