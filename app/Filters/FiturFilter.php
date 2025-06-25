<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FiturFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ($session->get('role_id') === 5) {
            return;
        }

        $allowedFitur = $session->get('fitur') ?? [];

        if ($arguments) {
            $requiredFitur = [];
            foreach ($arguments as $arg) {
                $requiredFitur = array_merge($requiredFitur, array_map('intval', explode(',', $arg)));
            }

            $hasAccess = false;
            foreach ($requiredFitur as $req) {
                if (in_array($req, $allowedFitur)) {
                    $hasAccess = true;
                    break;
                }
            }

            if (!$hasAccess) {
                return redirect()->to('/unauthorized');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu dilakukan apa-apa setelah request
    }
}
