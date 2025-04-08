<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Controller\RecipeController;
use Src\Middleware\AuthMiddleware;

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$headers = getallheaders();

$auth = new AuthMiddleware();
$recipeController = new RecipeController();

switch (true) {
    case preg_match('#^/recipes$#', $requestUri) && $method === 'GET':
        $recipeController->list();
        break;
    case preg_match('#^/recipes$#', $requestUri) && $method === 'POST':
        $auth->handle($headers);
        $recipeController->create();
        break;
    case preg_match('#^/recipes/([0-9]+)$#', $requestUri, $matches):
        $id = $matches[1];
        if ($method === 'GET') {
            $recipeController->get($id);
        } elseif (in_array($method, ['PUT', 'PATCH'])) {
            $auth->handle($headers);
            $recipeController->update($id);
        } elseif ($method === 'DELETE') {
            $auth->handle($headers);
            $recipeController->delete($id);
        }
        break;
    case preg_match('#^/recipes/([0-9]+)/rating$#', $requestUri, $matches) && $method === 'POST':
        $recipeController->rate($matches[1]);
        break;
    case preg_match('#^/search\?q=(.*)#', $requestUri, $matches) && $method === 'GET':
        $recipeController->search(urldecode($matches[1]));
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
}
