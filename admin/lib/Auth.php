<?php

class Auth
{
    private $sessionKey;
    private $redirectTo;
    private $ajaxJson;

    public function __construct($sessionKey = 'session_user', $redirectTo = '/login.php', $ajaxJson = true)
    {
        $this->sessionKey = $sessionKey;
        $this->redirectTo = $redirectTo;
        $this->ajaxJson = $ajaxJson;
        if (!isset($_SESSION[$this->sessionKey])) $_SESSION[$this->sessionKey] = null;
    }

    public function check()
    {
        return is_array($_SESSION[$this->sessionKey]) && !empty($_SESSION[$this->sessionKey]);
    }

    public function user($key = null, $default = null)
    {
        if (!$this->check()) return null;
        $u = $_SESSION[$this->sessionKey];
        if ($key === null) return $u;
        return array_key_exists($key, $u) ? $u[$key] : $default;
    }

    public function login(array $data) { $_SESSION[$this->sessionKey] = $data; return true; }
    public function logout() { $_SESSION[$this->sessionKey] = null; return true; }

    public function requireLogin()
    {
        if ($this->check()) return;

        if ($this->isAjax() && $this->ajaxJson) {
            $this->json(401, ['ok'=>false,'error'=>'unauthorized']);
        }

        echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
        exit;
    }


    private function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') return true;
        if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) return true;
        return false;
    }

    private function json($status, $payload) { if (!headers_sent()) header('Content-Type: application/json; charset=utf-8', true, $status); echo json_encode($payload); exit; }
    private function redirect($url) { if (!headers_sent()) header('Location: '.$url, true, 302); exit; }
}