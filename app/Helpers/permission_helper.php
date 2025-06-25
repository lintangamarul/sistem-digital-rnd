<?php
if (!function_exists('has_permission')) {
    function has_permission($id_fitur) {
        $session = session();
        if ($session->get('role_id') === '5' ) {
            return true;
        }
        // Ambil fitur yang diizinkan dari session, pastikan berbentuk array
        $allowedFitur = $session->get('fitur') ?: [];
        return in_array($id_fitur, $allowedFitur);
    }
}
