<?php

namespace App\Framework\Route;

class ErrorController
{
    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        http_response_code(404);
        $this->renderJSON([
            "message" => "page not found"
        ]);
    }

    public function renderJSON($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
        exit;
    }
}