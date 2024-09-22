<?php

declare(strict_types=1);

namespace App\Handler\Auth;

use App\Library\Database\Sleek;
use App\Library\Session\Flash;
use App\Library\Session\Session;
use App\Library\View\ViewInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginHandler
{
    public function __construct(private ViewInterface $renderer, private Sleek $sleek) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {

        if (is_logged_in()) {
            return new RedirectResponse('/');
        }

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';

            $user = $this->sleek->getUser($username);
            if ($user && password_verify($password, $user['password'])) {
                Session::set('user_id', $user['_id']);
                Session::set('username', $user['username']);
                Flash::set('success', 'Welcome ' . $user['username'] . '!');
                return new RedirectResponse('/');
            }
            Flash::set('error', 'Invalid username or password');
        }

        return new HtmlResponse($this->renderer->render('auth/login'));
    }
}
