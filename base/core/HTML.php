<?php

class HTML {
    public function image($normalpath, $attrib = []) {
        $stringFinal = "<img src='" . URL::to('public') . '/' . $normalpath . "'";
        foreach ($attrib as $key => $value) {
            $stringFinal .= " " . $key . "='" . $value . "'";
        }
        return $stringFinal . ">";
    }

    public function style($normalpath) {
        return "<link rel='stylesheet' type='text/css' href='" . URL::to('public') . '/' . $normalpath . "'>";
    }

    public function script($normalpath) {
        return "<script type='text/javascript' src='" . URL::to('public') . '/' . $normalpath . "'></script>";
    }
}
