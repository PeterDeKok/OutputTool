<?php

namespace PeterDeKok\OutputTool;

class OutputTool {

    private $error_level;

    public function __construct ($error_level = 0) {
        $this->error_level = $error_level;
    }

    public function error ($string, $color = true, $background_color = true) {
        if ($this->error_level >= 1) {
            $color = $color ? '38;5;1' : null;
            $background_color = $background_color ? '7' : null;
            self::output($string, '>>  ERROR  >>', $color, $background_color);
        }
    }

    public function warning ($string, $color = true, $background_color = true) {
        if ($this->error_level >= 2) {
            $color = $color ? '38;5;3' : null;
            $background_color = $background_color ? '7' : null;
            self::output($string, '>> WARNING >>', $color, $background_color);
        }
    }

    public function notice ($string, $color = true, $background_color = true) {
        if ($this->error_level >= 3) {
            $color = $color ? '38;5;8' : null;
            $background_color = $background_color ? '7' : null;
            self::output($string, '>> NOTICE  >>', $color, $background_color);
        }
    }

    public function success ($string, $color = true, $background_color = true) {
        if ($this->error_level >= 1) {
            $color = $color ? '38;5;2' : null;
            $background_color = $background_color ? '7' : null;
            self::output($string, '>> SUCCESS >>', $color, $background_color);
        }
    }

    public function title ($string, $color = true, $background_color = true, $separate_title = false) {
        if ($this->error_level >= 1) {
            $color = $color ? '38;5;8' : null;
            $background_color = $background_color ? '7' : null;
            self::output($string, '             ', $color, $background_color, $separate_title);
        }
    }

    protected function output ($string, $title = null, $color = null, $background_color = null, $separate_title = true) {
        if ($this->error_level >= 1) {
            $preset = "";
            if (PHP_SAPI === 'cli') {
                $preset = "\x1b[";
                $preset .= is_null($background_color) ? "" : "$background_color;";
                $preset .= is_null($color) ? "" : "$color";
                $preset .= "m";
            }

            $preset .= is_null($title) ? "" : " $title ";
            $preset .= (PHP_SAPI === 'cli' && $separate_title) ? "\x1b[0m " : "" ;
            $preset .= $string;
            $preset .= (!$separate_title) ? "\x1b[0m " : "";
            $preset .= PHP_EOL;

            echo $preset;
        }
    }
}