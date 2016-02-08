<?php

class URL {

    public function to($normalpath) {
        return Path::to('base') . '/' . $normalpath;
    }

}
