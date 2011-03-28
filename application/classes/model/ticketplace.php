<?php defined('SYSPATH') or die('No direct script access allowed');

    class Model_Ticketplace extends Model_Kinomatix {
        
        protected $_belongs_to = array('ticket' => array(),'place'  => array());
    }

?>
