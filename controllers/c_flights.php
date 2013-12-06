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

        # Query to get preferences
        $q = 'SELECT * FROM preferences WHERE preferences.user_id = '.$this->user->user_id;

        # Run the query, store the results in the variable $preferenceList
        $preferenceList = DB::instance(DB_NAME)->select_rows($q);

        # Set variables to build URL
        $airport = $preferenceList[0]['airport'];
        $month = $preferenceList[0]['month'];
        $year = $preferenceList[0]['year'];
        $region = $preferenceList[0]['region'];
        $max_price = $preferenceList[0]['max_price'];

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