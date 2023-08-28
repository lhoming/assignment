<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class Controller 
{
    protected $render;
    protected $config;
    function __construct()
    {
        session_start();
        include project_path().'/config/app.php';
        $this->config = $config;
        $this->render = new PhpRenderer(project_path().'/resources/views');
    }
    public function view($file_name, $data, Response $response)
    {
        return $this->render->render($response, $file_name, $data);
    }
}