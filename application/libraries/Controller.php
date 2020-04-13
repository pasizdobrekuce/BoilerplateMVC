<?php 
/**
 * Base contoller
 * Loads the models and views
 */
class Controller {

    // Load model
    public function model($model) {
        
        // Require model file
        require_once "../application/models/$model.php";

        // Instanitiate model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        
        // Check if view file exists
        if(file_exists("../application/views/$view.php")) {
            // Load view
            require_once "../application/views/$view.php";
        } else {
            die("<strong>$view</strong> view does not exist!");
        }
    }
}