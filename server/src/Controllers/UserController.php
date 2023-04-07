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
            //script conso, backup
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

    #[Route('/users', name: "create_user", methods: [HttpMethods::POST])]
    public function createUser() {
        $data = (new UserManager(new PDOFactory()))->insertOne($_POST['user']);
        //scpipt adduser
        $this->renderJSON($data);
    }

    #[Route('/users/{id}', name: "update_user", methods: [HttpMethods::PUT])]
    public function updateUser(int $id) {
        $user = (new UserManager(new PDOFactory()))->findOne($id);
        $newUser = new User($id);
        $user->setPublicSshKey($_POST['publicSshKey']);
        try {
            $data = (new UserManager(new PDOFactory()))->updateOne($user);
        } catch (UserException $e) {
            http_response_code(400);
            $this->renderJSON([
                "message" => $e->getMessage()
            ]);
        }
        //script addssh
        $this->renderJSON($data);
    }

    #[Route("/users/{id}/edit", name: "user-edit", methods: [HttpMethods::PUT])]
    public function userEdit(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/login");
        }

        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->findOne($id);
        } catch (Exception $e) {
            $_SESSION['error'] = "User not found";
            Tools::redirect("/");
        }

        $user->setFirstname($_POST['firstname']);
        $user->setLastname($_POST['lastname']);
        $user->setBio($_POST['bio']);
        $user->setPhone($_POST['phone']);
        $user->setDateOfBirth($_POST['date_of_birth']);
        $user->setAvatarUrl($_POST['avatar_url']);
        $user->setUpdatedAt(date('Y-m-d H:i:s'));

        try {
            (new UserManager(new PDOFactory()))->updateOne($user);
            $_SESSION['success'] = "User updated";
            Tools::redirect("/");
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            Tools::redirect("/users/{$user->getId()}/edit");
        }
    }

}
