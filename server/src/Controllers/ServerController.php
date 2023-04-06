<?php

namespace App\Controllers;

use App\Exceptions\ServerException;
use App\Factories\PDOFactory;
use App\Framework\Entity\BaseController;
use App\Framework\Route\Route;
use App\Helpers\Tools;
use App\Managers\ServerManager;
use App\Types\HttpMethods;
use Exception;

class ServerController extends BaseController
{
    #[Route("/servers/{id}", name: "getserver", methods: [HttpMethods::GET])]
    public function serverView(int $id): void
    {
        $server = null;
        try {
            $server = (new ServerManager(new PDOFactory()))->findOne($id);

            http_response_code(200);
            $this->renderJSON([
                "server" => $server->toArray(),
            ]);
        }
        catch (Exception $e) {
            http_response_code(404);
            $this->renderJSON([
                "message" => "server not found"
            ]);
        }
    }
    #[Route("/server/{id}", name: "server-list", methods: [HttpMethods::GET])]
    public function serverProjectsList(int $id): void
    {
        $server = null;
        try {
            $server = (new ServerManager(new PDOFactory()))->findOne($id);
            http_response_code(200);
            $this->renderJSON([
                "projects" => $server->getProjects(),
            ]);
        } catch (Exception $e) {
            http_response_code(404);
            $this->renderJSON([
                "message" => "server not found"
            ]);
        }
    }
         #[Route('/server', name: "get_all_server", methods: ["GET"])]
    public function getAllServer() {
        $server = new ServerManager(new PDOFactory());
        $data = $server->getAll();
        $this->renderJSON($data);
    }

    #[Route('/server/id/{id}', name: "get_one_server", methods: ["GET"])]
    public function getOneServer(string $id) {
        $server = new ServerManager(new PDOFactory());
        $data = $server->getOne($id);
        $this->renderJSON($data);
    }

    #[Route('/server', name: "post_one_server", methods: ["POST"])]
    public function postOneServer() {
        $server = new ServerManager(new PDOFactory());
        $data = $server->postOne();
        $this->renderJSON($data);
    }

    #[Route('/server', name: "put_one_server", methods: ["PUT"])]
    public function putOneServer() {
        $server = new ServerManager(new PDOFactory());
        $data = $server->putOne();
        $this->renderJSON($data);
    }


}