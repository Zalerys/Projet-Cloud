<?php

namespace App\Framework\Entity;

use App\Entities\User;
use App\Factories\PDOFactory;
use App\Framework\HTTPFoundation\HTTPRequest;
use App\Framework\HTTPFoundation\HTTPResponse;
use App\Managers\UserManager;

abstract class BaseController
{
    protected HTTPRequest $HTTPRequest;
    protected HTTPResponse $HTTPResponse;

    public function __construct(string $action, array $params = [])
    {
        $this->HTTPRequest = new HTTPRequest();
        $this->HTTPResponse = new HTTPResponse();

        if (!is_callable([$this, $action])) {
            throw new \RuntimeException("La méthode $action n'est pas disponible");
        }

        call_user_func_array([$this, $action], $params);
    }

    public function render(string $view, array $variables, string $pageTitle)
    {
        $template = './../views/template.php';
        $view = './../views/' . $view . '.php';

        foreach ($variables as $key => $variable) {
            ${$key} = $variable;
        }

        ob_start();
        require $view;
        $content = ob_get_clean();

        $title = $pageTitle;
        require $template;
        exit;
    }

    public function renderJSON($content): void
    {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
        exit;
    }

    public function isAuth(): bool
    {
//        TODO: JWT verification
        if (!empty($_POST["auth"]["token"])) {
            return true;
        }
        return false;
    }

    public function getUser(): ?User {
//        TODO: JWT verification
        $token = $_POST["auth"]["token"];
        if (!empty($token)) {
            $username = $token["username"];
            $manager = new UserManager(new PDOFactory());

            try {
                return $manager->findOneByUsername($username);
            } catch (\Exception $e) {
                $this->renderJSON([
                    "message" => "User not found."
                ]);
            }
        }
        return null;
    }
}
