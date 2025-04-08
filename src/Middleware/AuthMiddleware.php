<?php
namespace Src\Middleware;

class AuthMiddleware {
    public function handle($headers) {
        $authHeader = $headers['Authorization'] ?? '';
        if ($authHeader !== 'Bearer ' . getenv('API_SECRET')) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }
}
