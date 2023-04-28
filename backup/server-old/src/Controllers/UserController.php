<?php

namespace App\Controllers;

use App\Entities\User;
use App\Exceptions\UserException;
use App\Factories\PDOFactory;
use App\Framework\Entity\BaseController;
use App\Framework\Route\Route;
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

        $data = (new UserManager(new PDOFactory()))->insertOne($_POST['user']);
        //script adduser
        shell_exec("sudo ./../scripts/adduser.sh ".$data->getUsername()." ".$data->getHashedPassword());
        $this->renderJSON($data);
    }

    #[Route('/users/{id}', name: "update_user", methods: [HttpMethods::PUT])]
    public function updateUser(int $id) {
        $user = (new UserManager(new PDOFactory()))->findOne($id);
        $newUser = new User($id);
        $user->setPublicSshKey($_POST['publicSshKey']);
        try {
            $data = (new UserManager(new PDOFactory()))->updateOne($user);
            //script changement de mot de passe
            shell_exec("sudo ./../scripts/addsshkey.sh ".$user->getUsername()." ".$_POST['publicSshKey']);

        } catch (UserException $e) {
            http_response_code(400);
            $this->renderJSON([
                "message" => $e->getMessage()
            ]);
        }
    }
}
