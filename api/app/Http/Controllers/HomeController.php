<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct(private readonly HomeService $homeService)
    {}

    public function manager()
    {
        $data = $this->homeService->manager();
        return response()->ApiSuccess(
            message : 'getting home data of manager in successful.',
            contents: $data,
        );
    }
}
