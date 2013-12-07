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

        # Create two empty arrays to be populated for each preference
        $descriptions = [];
        $items = [];

        foreach($preferenceList as $preference) {

            # Set variables to build URL
            $airport = $preference['airport'];
            $month = $preference['month'];
            $year = $preference['year'];
            $region = $preference['region'];
            $max_price = $preference['max_price'];

            # Build URL and description
            $url_string = 'code='.$airport;
            $description = 'Flights from '.$airport;

            if (isset($month) && isset($year)) {
                $url_string .= '&tm='.$year.$month;
                $description .= ' during '.$month.'/'.$year;
            }

            if ($region != '') {
                $description .= ' to somewhere in '.$region;
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
                $description .= ' for less than $'.$max_price;
            }

            $description .= '.';

            # Get deal list from kayak.com's rss feed
            # Reference: http://www.kayak.com/labs/rss/
            $results = Utils::curl('http://www.kayak.com/h/rss/buzz?'.$url_string);
        
            # Put results into array
            $results = Utils::xml_to_array($results);

            # Get deal list from results; if list contains values add results to items & description arrays
            if (isset($results['channel']['item'])) {
                $item = $results['channel']['item'];
                $items[] = $item;
                $descriptions[] = $description;
            }

        }

        # Pass data to the view
        $this->template->content->items = $items;
        $this->template->content->descriptions = $descriptions;

        # Render the view
        echo $this->template;
    }

} # end of the class