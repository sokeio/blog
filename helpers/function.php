<?php

//code php
if (!function_exists('post_with_builder')) {
    function post_with_builder()
    {
        return function_exists('module_active') && !!module_active('builder');
    }
}
