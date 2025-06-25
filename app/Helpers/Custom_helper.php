<?php
if (!function_exists('urlsafe_b64encode')) {
    function urlsafe_b64encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
if (!function_exists('urlsafe_b64decode')) {
    function urlsafe_b64decode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
