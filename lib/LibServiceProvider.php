<?php

namespace Lib;

use Form;

/**
 * ServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author Kamran Ahmed <kamranahmed.se@gmail.com>
 * @package App\Modules
 */
class LibServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        Form::macro('nestedSelect', function ($name, $list = [], $selected = null, $options = [], $disabled = []) {
            $html = '<select name="' . $name . '"';
            foreach ($options as $attribute => $value) {
                $html .= ' ' . $attribute . '="' . $value . '"';
            }
            $html .= '">';
            foreach ($list as $value => $text) {
                $html .= '<option value="' . $value . '"' .
                    ($value == $selected ? ' selected="selected"' : '') .
                    (in_array($value, $disabled) ? ' disabled="disabled"' : '') . '>' .
                    $text . '</option>';
            }
            $html .= '</select>';
            return $this->toHtmlString($html);
        });

        Form::macro('nestedSelectName', function ($name, $list = [], $selected = null, $options = [], $disabled = []) {
            $html = '<select name="' . $name . '"';
            foreach ($options as $attribute => $value) {
                $html .= ' ' . $attribute . '="' . $value . '"';
            }
            $html .= '">';
            foreach ($list as $value => $text) {
                $html .= '<option value="' . str_replace('-', '', $text) . '"' .
                    ($value == $selected ? ' selected="selected"' : '') .
                    (in_array($value, $disabled) ? ' disabled="disabled"' : '') . '>' .
                    $text . '</option>';
            }
            $html .= '</select>';
            return $this->toHtmlString($html);
        });
        setlocale(LC_TIME, 'id');
    }

    public function register()
    {
    }
}