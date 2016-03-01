<?php

class URL {

    public static function to($normalpath) {
        return Path::to('base') . '/' . $normalpath;
    }

}
