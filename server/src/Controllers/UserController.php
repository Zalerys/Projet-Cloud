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

    #[Route("/users/{id}/projects", name: "user-projects-list", methods: [HttpMethods::GET])]
    public function userProjectsList(int $id): void
    {
        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->findOne($id);

            http_response_code(200);
            $this->renderJSON([
                "projects" => $user->getProjects(),
            ]);
        } catch (Exception $e) {
            http_response_code(404);
            $this->renderJSON([
                "message" => "user not found"
            ]);
        }
    }

    /**
     * @throws UserException
     */
    #[Route('/users', name: "post_one_user", methods: ["POST"])]
    public function postOneUser() {
        $users = new UserManager(new PDOFactory());
        $user = new User($body);
        $data = $users->insertOne($user);
        //scpipt adduser
        $this->renderJSON($data);
    }

    #[Route('/users', name: "put_one_user", methods: ["PUT"])]
    public function putOneUser() {
        $users = new UserManager(new PDOFactory());
        $user = new User($body);
        //ajouter script modify Pwd
        $data = $users->updateOne($user);
        $this->renderJSON($data);
    }

    #[Route('/users/ssh', name: "put_one_user_ssh_key", methods: ["PUT"])]
    public function addsshKey() {
        $users = new UserManager(new PDOFactory());
        $user = new User($body);
        $data = $users->updateOne($user);
        //script addssh
        $this->renderJSON($data);
    }

}
