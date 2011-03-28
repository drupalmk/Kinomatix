<?php defined('SYSPATH') or die('No direct script access');

    class Model_MoviesMaker extends ORM {
        protected $_belongs_to = array('movie' => array(), 'maker' => array());
    }

?>
