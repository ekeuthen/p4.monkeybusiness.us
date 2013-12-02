<?php
class flights_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        
        //getting deal list from kayak's rss feed
        $results = Utils::curl('http://www.kayak.com/h/rss/buzz?code=BOS');
        
        //putting deal list results into array
        $results = Utils::xml_to_array($results);

        //getting results and displaying them
        $items = $results['channel']['item'];
        foreach($items as $deal) {
            echo $deal['title']."<br>";
            echo $deal['link']."<br><br>";
        }

        //how to get at namespace data?
        //http://www.sitepoint.com/simplexml-and-namespaces/
        //http://stackoverflow.com/questions/1186107/simple-xml-dealing-with-colons-in-nodes
        //http://www.sitepoint.com/parsing-xml-with-simplexml/

        //echo Debug::dump($items,"Results");
    }

} # end of the class