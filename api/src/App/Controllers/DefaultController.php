<?php

namespace App\Controllers;

use Com\Tnqsoft\Helper\Response;
use Com\Tnqsoft\Helper\JsonResponse;
use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Helper\Paginator;
use Com\Tnqsoft\Exceptions\HttpException;
use Com\Tnqsoft\Controllers\Controller;
use Com\Tnqsoft\Providers\DatabaseProvider;

class DefaultController extends Controller
{
    public function indexAction(Request $request): Response
    {
        return new Response(200, 'All Working');
    }
}
