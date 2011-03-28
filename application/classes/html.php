<?php defined('SYSPATH') or die('No direct script access.');

class HTML extends Kohana_HTML {

    public static function link($route, $params, $title, $attr = NULL) {

        if (isset($params['action']))  {
            $curr_act = $params['action'];
            if ($curr_act == Request::instance()->action) {
                if (isset($params['controller'])) {
                    $curr_ctrl = $params['controller'];
                   if ($curr_ctrl == Request::instance()->controller) {
                       $attr = self::mark_as_active($attr);
                   }
                } else {
                    $attr = self::mark_as_active($attr);
                }

            }
        } 
        return html::anchor(Route::get($route)->uri($params), $title, $attr);
    }

    private static function mark_as_active($attr) {
                if (isset($attr['class'])) {
                    $class = $attr['class'];
                    $class .= ' active';
                    $attr['class'] = $class;
                } else {
                    $attr['class'] = 'active';
                }
                return $attr;
    }
}
?>