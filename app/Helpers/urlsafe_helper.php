<?php 
/**
 * Fungsi untuk melakukan URL safe base64 encode.
 * Mengubah hasil base64_encode agar tidak mengandung karakter yang bermasalah di URL.
 *
 * @param mixed $data Data yang akan dienkode
 * @return string Data yang telah dienkode secara URL safe
 */
if (!function_exists('urlsafe_b64encode')) {
    function urlsafe_b64encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

/**
 * Fungsi untuk melakukan URL safe base64 decode.
 * Mengembalikan string hasil decode yang awalnya telah diubah dengan urlsafe_b64encode.
 *
 * @param string $data Data yang telah dienkode secara URL safe
 * @return mixed Data asli setelah didekode
 */
if (!function_exists('urlsafe_b64decode')) {
    function urlsafe_b64decode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
