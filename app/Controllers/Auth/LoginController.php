<?php
namespace App\Controllers\Auth;

use App\Model\User;
use Slim\Routing\RouteContext;
use App\Action\Mail\MailAction;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginController extends Controller
{
    protected $userClass;
    public function __construct()
    {
        parent::__construct();
        $this->userClass = new User();
    }
    public function getLogin(Request $request, Response $response)
    {
        if(is_authenticated()){
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('dashboard');
            return $response->withHeader('Location', $url)
                ->withStatus(302);
        }
       return $this->view('auth/login.php', [], $response);
    }
    public function login(Request $request, Response $response)
    {
        $queryParameters = $request->getParsedBody();
        $username = $queryParameters['username'];
        $password = $queryParameters['password'];
        $email = null;
        $user = $this->userClass->getUserByUsername($username);
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $errorUrl = $routeParser->urlFor('get-login');
        $errorResponse =  $response->withHeader('Location', $errorUrl)->withStatus(302);
        if(count($user) > 0){
            $user = $user[0];
            $email = $user['email'];
            if (password_verify($password, $user['password'])) {
                $check = (new MailAction)->sendVerificationMail($user);
                if($check){
                    $_SESSION['user'] = $user;
                    $isAuthenticated = false;
                    $_SESSION['email'] = $email;
                    $_SESSION['is_auth'] = $isAuthenticated;
                    $_SESSION['success'] = 'Successfully Email has been sent, please check your email to verify';
                    $url = $routeParser->urlFor('verified');
                    return $response->withHeader('Location', $url)
                        ->withStatus(302);
                    exit();
                }else{
                    $_SESSION['error'] = 'Sorry! Internal server error';
                }
            } else {
                $_SESSION['error'] = 'Incorrect password';
                return $errorResponse;
            }
        }else{
            $_SESSION['error']= 'Sorry The User Could Not Be Found';
            return $errorResponse;
        }
    }
    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['email']);
        unset($_SESSION['user']);
        unset($_SESSION['is_auth']);
        $_SESSION['success'] = 'GoodBye';
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('dashboard');
        return $response->withHeader('Location', $url)
            ->withStatus(302);
    }
}
