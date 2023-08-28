<?php

function dd($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

function str_random($number=16)
{
    $randomBytes = random_bytes($number);
    $rand = rtrim(strtr(base64_encode($randomBytes), '+/', '-_'), '=');
    return $rand;
}

function is_authenticated()
{
    $isAuthenticated = false;
    if (isset($_SESSION['is_auth'])) {
        $isAuthenticated = $_SESSION['is_auth'];
    }
    return $isAuthenticated;
}

function project_path()
{
    return __DIR__.'/../../';
}

function public_path()
{
    return __DIR__.'/../../public/';
}

function asset($path=null)
{
    include project_path().'/config/app.php';
    return $config['app_url'].'/'.$path;
}