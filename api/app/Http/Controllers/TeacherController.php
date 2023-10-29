<?php

namespace App\Http\Controllers;

use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function __construct(readonly private TeacherService $teacherService)
    {}

    public function index()
    {
        $data = $this->teacherService->index();

        return response()->ApiSuccess(
            message : 'getting teacher data of manager in successful.',
            contents: $data,
        );
    }
}
