<?php

use Snipe\Core\URL;
use Snipe\Core\HTML;
use Snipe\Core\View;

if (! function_exists('view')) {
    function view($path,$params = [])
    {
      View::render($path, $params);
    }
}

if (! function_exists('url')) {
    function url($path)
    {
        return URL::to($path);
    }
}

if (! function_exists('image_tag')) {
    function image_tag($normalpath, $attrib = [])
    {
        return HTML::image($normalpath, $attrib);
    }
}

if (! function_exists('link_tag')) {
    function link_tag($normalpath, $attrib = [])
    {
        return HTML::link($normalpath, $attrib);
    }
}

if (! function_exists('style')) {
    function style($normalpath)
    {
        return HTML::style($normalpath);
    }
}
if (! function_exists('script')) {
    function script($normalpath)
    {
        return HTML::script($normalpath);
    }
}
if (! function_exists('asset')) {
    function asset($normalpath)
    {
        return HTML::file($normalpath);
    }
}
