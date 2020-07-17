<?php

if (!function_exists('is_json')) {
    function is_json($argument)
    {
        return (json_decode(json_encode($argument)) != null) ? true : false;
    }
}
