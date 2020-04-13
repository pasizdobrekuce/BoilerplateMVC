<?php
/**
 * Application core class
 * Creates URL and loads core controller
 * URL format: /controller/method/params
 */
class Core {

    // Set defaults
    protected $currentController = "Pages";
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct() {

        // Set URL
        $url = $this->getUrl();
        
        /**
         * Look for the first $url value inside controllers folder
         * Load particular controller
         */
        if(file_exists('../application/controllers/' . ucwords($url[0]) . '.php')) {
            // Set value as a controller
            $this->currentController = ucwords($url[0]);
            // Unset zero index
            unset($url[0]);
        }

        // Require the controler
        require_once '../application/controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;
        
        /**
         * Look for the second $url value inside of controller
         * Load particular method
         */
        if(isset($url[1])) {
            // Check if method exists inside of controller
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset index one
                unset($url[1]);
            }
        }

        // Set params
        $this->params = $url ? array_values($url) : $this->params;

        // Callback with array of parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Get url and return its vaules inside an array
     *
     * @return array
     */
    public function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}