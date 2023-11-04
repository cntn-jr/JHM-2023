<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeacherRequest;
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

    public function confirm(CreateTeacherRequest $request)
    {
        $data = $this->teacherService->confirm($request);

        return response()->ApiSuccess(
            message : 'confirming teacher columns in successful.',
            contents: $data,
        );
    }

    public function finalize(CreateTeacherRequest $request)
    {
        $data = $this->teacherService->createAccount($request);

        if ($data) {
            return response()->ApiSuccess(
                message : 'creating teacher account in successful.',
                contents: $data,
            );
        }

        return response()->ApiFailed(
            message   : 'failed to create teacher account',
            contents  : $data,
            statusCode: 500,
        );
    }
}