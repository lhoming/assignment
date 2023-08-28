<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(Request $request, Response $response)
    {
        $data =[
            'name'=>"Helllo",
        ];
        return $this->view('index.php', $data, $response);
    }
}
