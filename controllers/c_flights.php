<?php
class flights_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            Router::redirect("/users/login");
        }
    } 

    public function index() {

        # Setup view
        $this->template->content = View::instance('v_flights_index');
        $this->template->title   = "Deals";

        # Get deal list from kayak.com's rss feed
        $results = Utils::curl('http://www.kayak.com/h/rss/buzz?code=BOS');
        
        # Put results into array
        $results = Utils::xml_to_array($results);

        # Get deal list from results
        $items = $results['channel']['item'];
        //echo var_dump($items);

        # Pass data to the view
        $this->template->content->items = $items;

        # Render the view
        echo $this->template;
    }

} # end of the class