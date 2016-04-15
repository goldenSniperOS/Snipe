<?php

class Android {

    public static function get($item) {
        $post = json_decode(file_get_contents('php://input'));
        Debug::varDump($post);
        if (property_exists($post, $item)) {
            return $post->{$item};
        }

        return '';
    }

    public static function all() {
        $post = json_decode(file_get_contents('php://input'));
        return $post;
    }

}
