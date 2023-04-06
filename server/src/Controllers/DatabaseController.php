<?php

namespace App\Controllers;

use App\Exceptions\DatabaseException;
use App\Factories\PDOFactory;
use App\Framework\Entity\BaseController;
use App\Framework\Route\Route;
use App\Helpers\Tools;
use App\Managers\DatabaseManager;
use App\Types\HttpMethods;
use Exception;

class DatabaseController extends BaseController
{
    #[Route("/database", name: "database", methods: [HttpMethods::GET])]
    public function database(){

    }
}
