<?php
// models/Router.php
class Router {
    private $routes = [];
    private $basePath;

    // Constructor to set the base path (e.g., /galaxify)
    public function __construct($basePath = '') {
        $this->basePath = rtrim($basePath, '/');
    }

    // Register a route
    public function addRoute($method, $url, $controllerMethod) {
        // accepts the parameter
        $url = preg_replace('/{([a-zA-Z0-9]+)}/', '(?P<$1>[a-zA-Z0-9_-]+)', $url);
        $this->routes[] = ['method' => $method, 'url' => $url, 'controllerMethod' => $controllerMethod];
        //var_dump($this->routes);
    }

    // Dispatch the request to the appropriate controller
    public function dispatch($url, $method) {
        // Normalize the URL by removing the base path
        if ($url === $this->basePath . '/') {
            $url = '/';  // Treat the root of the app as the empty string (home page)
        } else {
            $url = rtrim(str_replace($this->basePath, '', $url), '/');
        }

        foreach ($this->routes as $route) {
            // Convert route placeholders {param} to a regex pattern
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route['url']);
            $pattern = "#^" . $pattern . "$#";
            if ($method === $route['method'] && preg_match($pattern, $url, $matches)) {
                // Extract controller and method
                list($controller, $action) = explode('@', $route['controllerMethod']);
                array_shift($matches); // Remove the full match from $matches
    
                // Call the controller
                $this->callController($controller, $action, $matches);
                return;
            }
        }
        // If no match is found, call the 404 view
        $this->call404();
    }

    // Call the controller's method
    private function callController($controller, $action, $params = []) {
        require_once "controllers/{$controller}.php";

        // Create a reflection instance for the controller
        $reflection = new ReflectionClass($controller);

        // Check if the controller has a constructor
        if ($reflection->hasMethod('__construct')) {
            $constructor = $reflection->getMethod('__construct');

            // If the constructor has parameters, we need to inject dependencies
            if ($constructor->getNumberOfParameters() > 0) {
                // Extract the model name (remove 'Controller' suffix)
                $modelName = str_replace('Controller', '', $controller);
                
                // Check if the model exists before requiring it
                $modelFile = "models/{$modelName}.php";
                if (file_exists($modelFile)) {
                    require_once $modelFile;
                }
                
                // Instantiate the model
                $modelInstance = new $modelName();

                // Instantiate the controller with the model injected
                $controllerInstance = $reflection->newInstance($modelInstance);
            } else {
                // No parameters needed, instantiate the controller without arguments
                $controllerInstance = $reflection->newInstance();
            }
        } else {
            // No constructor, instantiate the controller without arguments
            $controllerInstance = new $controller;
        }

        // Check if the action method exists
        if (method_exists($controllerInstance, $action)) {
            // If the action method has named parameters, we need to map the arguments
            $method = $reflection->getMethod($action);
            $paramsMapped = [];
            $parameters = $method->getParameters();

            // Ensure arguments are passed in correct order
            foreach ($parameters as $index => $parameter) {
                if (isset($params[$index])) {
                    // If the method parameter is named, we map the argument
                    $paramsMapped[$parameter->getName()] = $params[$index];
                }
            }

            // Call the controller's action method with the mapped parameters
            call_user_func_array([$controllerInstance, $action], $paramsMapped);
        } else {
            // Log or handle the error if the action method does not exist
            echo "Error: Action {$action} not found in controller {$controller}.";
        }
    }

    // Call the 404 view
    private function call404() {
        include 'views/404.php';
    }
}