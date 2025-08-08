<?php

namespace EyoPHP\Framework\Controller;

/**
 * ErrorController - Error handling for 404 and other errors
 *
 * @package EyoPHP\Framework\Controller
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class ErrorController
{
    /**
     * Render a view
     */
    private function renderView(string $view, array $data = [])
    {
        // Extract data to make it available in the view
        extract($data);

        // Define path to views
        $viewPath = APP_PATH . "views/" . $view . ".php";

        // Check if view exists
        if (!file_exists($viewPath)) {
            echo "<h1>Error 404</h1>";
            echo "<p>View '$view' not found.</p>";
            echo "<p>Path searched: $viewPath</p>";
            return;
        }

        // Include the view
        require_once $viewPath;
    }

    /**
     * 404 Not Found error page
     */
    public function notFound(): void
    {
        http_response_code(404);
        $this->renderView('error/404', [
            'title' => '404 - Page Not Found',
            'description' => 'The requested page could not be found on this server'
        ]);
    }

    /**
     * 403 Forbidden error page
     */
    public function forbidden(): void
    {
        http_response_code(403);
        $this->renderView('error/403', [
            'title' => '403 - Access Forbidden',
            'description' => 'You do not have permission to access this resource'
        ]);
    }

    /**
     * 500 Internal Server Error page
     */
    public function serverError(?\Throwable $exception = null): void
    {
        http_response_code(500);
        $this->renderView('error/500', [
            'title' => '500 - Internal Server Error',
            'description' => 'The server encountered an internal error and could not complete your request',
            'exception' => $exception
        ]);
    }
}
