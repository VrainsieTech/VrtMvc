<?php
namespace Vrainsietech\Core\Controller;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\Response;

class Controller
{
    protected function isAjax(Request $request)
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    protected function jsonResponse(Response $response, $data, $status = 200)
    {
        return $response->json($data, $status);
    }
}
