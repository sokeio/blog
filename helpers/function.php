<?php

//code php
if (!function_exists('postWithBuilder')) {
    function postWithBuilder()
    {
        return function_exists('moduleIsActive') && !!moduleIsActive('builder');
    }
}
