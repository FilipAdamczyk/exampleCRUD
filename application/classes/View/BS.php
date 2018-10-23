<?php
namespace View;

/**
 * Class for generating bootstrap-stylized view elements
 * @package View
 */
class BS {
    const PRIMARY = 'primary';
    const WARNING = 'warning';
    const DANGER = 'danger';
    const SUCCESS = 'success';
    const INFO = 'info';

    /**
     * Bootstrap-stylized form input
     * @param string $name
     * @param mixed $value
     * @param string $label
     * @param string $error
     * @return string
     */
    public static function input(string $name, $value, string $label, string $error): string
    {
        $html = '<div class="form-group">';
        $html .= \Form::label($name, $label, ['class' => 'col-sm-2 control-label']);
        $html .= '<div class="col-sm-10">';
        $html .= \Form::input(
            $name,
            $value,
            [
                'class' => 'form-control' . ($error ? ' is-invalid' : ''),
                'id' => $name
            ]
        );
        $html .= $error;
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Formatted button
     * @param string $url
     * @param string $label
     * @param string $type
     * @return string
     */
    public static function button(string $url, string $label, string $type = self::INFO): string
    {
        return \HTML::anchor(
            $url,
            $label,
            [
                'class' => 'btn btn-' . $type,
                'role'=>'button'
            ]
        );
    }
}