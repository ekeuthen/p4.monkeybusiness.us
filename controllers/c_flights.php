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

        # Query to get user's preferences
        $q = 'SELECT * FROM preferences WHERE preferences.user_id = '.$this->user->user_id;

        # Run the query, store the results in variable
        $preferenceList = DB::instance(DB_NAME)->select_rows($q);

        # Set variables to build URL
        $airport = $preferenceList[0]['airport'];
        $month = $preferenceList[0]['month'];
        $year = $preferenceList[0]['year'];
        $region = $preferenceList[0]['region'];
        $max_price = $preferenceList[0]['max_price'];

        # Build URL
        $url_string = 'code='.$airport;

        if (isset($month) && isset($year)) {
            $url_string .= '&tm='.$year.$month;
        }

        if (isset($region)) {
            # Convert region names to region codes prior to adding to url string
            switch ($region) {
                case 'Africa':
                    $region = 'f';
                    break;
                case 'Asia':
                    $region = 'a';
                    break;
                case 'Caribbean':
                    $region = 'c';
                    break;
                case 'Central American':
                    $region = 'm';
                    break;
                case 'Europe':
                    $region = 'e';
                    break;
                case 'North America':
                    $region = 'u';
                    break;
                case 'South America':
                    $region = 's';
                    break;
            }
            $url_string .= '&rc='.$region;
        }

        if (isset($max_price)) {
            $url_string .= '&max='.$max_price;
        }

        # Get deal list from kayak.com's rss feed
        # Reference: http://www.kayak.com/labs/rss/
        $results = Utils::curl('http://www.kayak.com/h/rss/buzz?'.$url_string);
        
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