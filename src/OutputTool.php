<?php

namespace PeterDeKok\OutputTool;

/**
 * Class OutputTool
 * @method static error($string, $color = true, $background_color = true);
 * @method static warning($string, $color = true, $background_color = true);
 * @method static notice($string, $color = true, $background_color = true);
 * @method static success($string, $color = true, $background_color = true);
 * @method static title($string, $color = true, $background_color = true, $separate_title = false);
 * @method static output($string, $title = null, $color = null, $background_color = null, $separate_title = true)
 */
class OutputTool {

    public static $error_level = 0;
    private static $instance;

    protected function __construct () {}

    public function output_error ($string, $color = true, $background_color = true) {
        if ($this->getErrorLevel() >= 1) {
            $color = $color ? '38;5;1' : null;
            $background_color = $background_color ? '7' : null;
            $this->output_output($string, '>>  ERROR  >>', $color, $background_color);
        }
    }

    public function output_warning ($string, $color = true, $background_color = true) {
        if ($this->getErrorLevel() >= 2) {
            $color = $color ? '38;5;3' : null;
            $background_color = $background_color ? '7' : null;
            $this->output_output($string, '>> WARNING >>', $color, $background_color);
        }
    }

    public function output_notice ($string, $color = true, $background_color = true) {
        if ($this->getErrorLevel() >= 3) {
            $color = $color ? '38;5;8' : null;
            $background_color = $background_color ? '7' : null;
            $this->output_output($string, '>> NOTICE  >>', $color, $background_color);
        }
    }

    public function output_success ($string, $color = true, $background_color = true) {
        if ($this->getErrorLevel() >= 1) {
            $color = $color ? '38;5;2' : null;
            $background_color = $background_color ? '7' : null;
            $this->output_output($string, '>> SUCCESS >>', $color, $background_color);
        }
    }

    public function output_title ($string, $color = true, $background_color = true, $separate_title = false) {
        $this->something = 2;
        if ($this->getErrorLevel() >= 1) {
            $color = $color ? '38;5;8' : null;
            $background_color = $background_color ? '7' : null;
            $this->output_output($string, '             ', $color, $background_color, $separate_title);
        }
    }

    public function output_output ($string, $title = null, $color = null, $background_color = null, $separate_title = true) {
        if ($this->getErrorLevel() >= 1) {
            $preset = "";
            if (PHP_SAPI === 'cli') {
                $preset = "\x1b[";
                $preset .= is_null($background_color) ? "" : "$background_color;";
                $preset .= is_null($color) ? "" : "$color";
                $preset .= "m";
            }

            $preset .= is_null($title) ? "" : " $title ";
            $preset .= (PHP_SAPI === 'cli' && $separate_title) ? "\x1b[0m " : "";
            $preset .= $string;
            $preset .= (!$separate_title) ? "\x1b[0m " : "";
            $preset .= PHP_EOL;

            echo $preset;
        }
    }

    protected function getErrorLevel () {
        return static::$error_level;
    }

    protected static function setErrorLevel ($error_level) {
        static::$error_level = $error_level;
    }

    public static function __callStatic ($name, $arguments) {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return call_user_func_array([static::$instance, 'output_' . $name], $arguments);
    }

    private function __clone () {
    }

    private function __wakeup () {
    }
}