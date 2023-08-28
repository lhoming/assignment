<?php
namespace App\Controllers\Home;

use App\Model\User;
use Slim\Routing\RouteContext;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController extends Controller
{
    protected $userClass;
    public function __construct()
    {
        parent::__construct();
        $this->userClass =  new User();
    }
    public function index(Request $request, Response $response)
    {
        if(!is_authenticated()){
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('get-login');
            return $response->withHeader('Location', $url)
            ->withStatus(302);
        }
        $user = [];
        if (isset($_SESSION['email'])) {
            $user = $_SESSION['user'];
        }
        $isAuthenticated = false; 
        if (isset($_SESSION['is_auth'])) {
            $isAuthenticated = $_SESSION['is_auth'];
        }
        $data = [
            'email'=>$user['email'],
            'isAuthenticated'=>$isAuthenticated,
            'name'=>$user['name'],
            'username'=>$user['username'],
            'address'=>$user['address'],
            'balance'=>$user['balance'],
        ];
        return $this->view('dashboard.php', $data, $response);
    }

    public function verified(Request $request, Response $response)
    {
        if(is_authenticated()){
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('dashboard');
            return $response->withHeader('Location', $url)
            ->withStatus(302);
        }
        if(!is_authenticated()){
            if(isset($_SESSION['email'])){
                $user = $_SESSION['user'];
                $isAuthenticated = false;
                $data = [
                    'email'=>$user['email'],
                    'isAuthenticated'=>$isAuthenticated,
                    'name'=>$user['name'],
                    'username'=>$user['username'],
                ];
                return $this->view('verified.php', $data, $response);
            }else{
                $routeParser = RouteContext::fromRequest($request)->getRouteParser();
                $url = $routeParser->urlFor('get-login');
                return $response->withHeader('Location', $url)
                ->withStatus(302);
            }
        }
    }
    public function verify(Request $request, Response $response)
    {
        $queryParameters = $request->getQueryParams();
        $username = $queryParameters['username'];
        $token = $queryParameters['token'];
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        if(!isset($_SESSION[$username.'_token'])){
            $_SESSION['error'] = 'Sorry, The Token is not valid';
            $url = $routeParser->urlFor('get-login');
            return $response->withHeader('Location', $url)
            ->withStatus(302);
        }
        if(isset($_SESSION['email'])){
            $user = $_SESSION['user'];
            $n_user = $this->userClass->getUserByUsername($username);
            if(count($n_user) <= 0){
                $url = $routeParser->urlFor('get-login');
                $_SESSION['error'] = "Sorry User Does not match with your verification";
                return $response->withHeader('Location', $url)
                ->withStatus(302);
            }
            if($user['username'] === $username && $n_user[0]['token'] === $token){
                $_SESSION['is_auth'] = true;
                $_SESSION['success'] = 'Successfuly Authenticated';
                $url = $routeParser->urlFor('dashboard');
                $this->userClass->update(['token'=>null], ['id'=>$n_user[0]['id']]);
                return $response->withHeader('Location', $url)
                ->withStatus(302);
            }else{
                $url = $routeParser->urlFor('get-login');
                $_SESSION['error'] = "Sorry User Does not match with your verification";
                return $response->withHeader('Location', $url)
                ->withStatus(302);
            }
        }
    }
}
