<?php

namespace App\Controllers;

use App\Entities\User;
use App\Exceptions\UserException;
use App\Factories\PDOFactory;
use App\Framework\Entity\BaseController;
use App\Framework\Route\Route;
use App\Helpers\Filters;
use App\Helpers\Tools;
use App\Managers\UserManager;
use App\Service\JWTHelper;
use App\Types\HttpMethods;

class AuthController extends BaseController
{
    #[Route("/auth/login", name: "login", methods: [HttpMethods::POST])]
    public function login(): void
    {
        $authenticationMethod = Filters::postString('authentication-method');
        $password = Filters::postString('password');

        if (!empty($authenticationMethod) && !empty($password)) {
            try {
                $manager = new UserManager(new PDOFactory());
                $user = $manager->findOneByAuthenticationMethod($authenticationMethod);
                if (password_verify($password, $user->getHashedPassword())) {
                    $jwt = JWTHelper::buildJWT($user);
                    http_response_code(200);
                    $this->renderJSON([
                        "token" => $jwt
                    ]);
                } else {
                    http_response_code(406);
                    $this->renderJSON([
                        "message" => "invalid cred"
                    ]);
                }
            } catch (UserException $e) {
                http_response_code(406);
                $this->renderJSON([
                    "message" => "user not found"
                ]);
            }
        } else {
            http_response_code(406);
            $this->renderJSON([
                "message" => "fields missing"
            ]);
        }
    }

    #[Route("/auth/register", name: "register", methods: [HttpMethods::POST])]
    public function register(): void
    {
        if (!empty(Filters::postString('password')) && !empty(Filters::postString('password-confirm')) && Filters::postString('password') === Filters::postString('password-confirm')) {
            try {
                $user = new User([
                    'username' => strtolower(Filters::postString('username')),
                    'email' => strtolower(Filters::postString('email')),
                ]);

                $user->setHashedPassword(password_hash(Filters::postString('password'), PASSWORD_DEFAULT));
                $user = (new UserManager(new PDOFactory()))->insertOne($user);
                $jwt = JWTHelper::buildJWT($user);
                http_response_code(201);
                $this->renderJSON([
                    "token" => $jwt,
                    "message" => "user created"
                ]);

            } catch (UserException $e) {
                http_response_code(403);
                $this->renderJSON([
                    "message" => "user already exists"
                ]);
            }
        } else {
            http_response_code(406);
            $this->renderJSON([
                "message" => "passwords do not match"
            ]);
        }
    }
}
