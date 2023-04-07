<?php

namespace App\Controllers;

use App\Entities\User;
use App\Exceptions\UserException;
use App\Factories\PDOFactory;
use App\Framework\Entity\BaseController;
use App\Framework\Route\Route;
use App\Helpers\Tools;
use App\Managers\UserManager;
use App\Types\HttpMethods;
use Exception;

class UserController extends BaseController
{
    #[Route("/users/{id}", name: "user-profile", methods: [HttpMethods::GET])]
    public function userView(int $id): void
    {
        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->findOne($id);

            http_response_code(200);
            $this->renderJSON([
                "user" => $user->toArray(),
            ]);
        } catch (Exception $e) {
            http_response_code(404);
            $this->renderJSON([
                "message" => "user not found"
            ]);
        }
    }

    #[Route("/users/{id}/servers", name: "user-servers-list", methods: [HttpMethods::GET])]
    public function userServersList(int $id): void
    {
        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->findOne($id);

            http_response_code(200);
            //script conso, backup
            $this->renderJSON([
                "servers" => $user->getServers(),
            ]);
        } catch (Exception $e) {
            http_response_code(404);
            $this->renderJSON([
                "message" => "user not found"
            ]);
        }
    }

    #[Route('/users', name: "create_user", methods: [HttpMethods::POST])]
    public function createUser() {
        try {
            $data = (new UserManager(new PDOFactory()))->insertOne($_POST['user']);
            //scpipt adduser
            $this->renderJSON($data);
        } catch (UserException $e) {
            http_response_code(400);
            $this->renderJSON([
                "message" => $e->getMessage()
            ]);
        }
    }

    #[Route('/users/{id}', name: "update_user", methods: [HttpMethods::PUT])]
    public function updateUser(int $id) {
        try {
            $oldUser = (new UserManager(new PDOFactory()))->findOne($id);
            $newUser = new User($_POST['user']);
            $finalUserArray = array_merge($oldUser->toArray(), $newUser->toArray());

            $user = new User($finalUserArray);

            $data = (new UserManager(new PDOFactory()))->updateOne($user);
            //script addssh
            $this->renderJSON($data);
        } catch (UserException $e) {
            http_response_code(400);
            $this->renderJSON([
                "message" => $e->getMessage()
            ]);
        }
    }

}
