<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\DestroyTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
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

    public function update(UpdateTeacherRequest $request)
    {
        $data = $this->teacherService->updateAccount($request);

        if ($data['result']) {
            return response()->ApiSuccess(
                message : 'updating teacher account in successful.',
                contents: $data,
            );
        }

        return response()->ApiFailed(
            message   : 'failed to update teacher account',
            contents  : $data,
            statusCode: 500,
        );
    }

    public function destroy(DestroyTeacherRequest $request)
    {
        $data = $this->teacherService->deleteAccount($request);

        if ($data['result']) {
            return response()->ApiSuccess(
                message : 'deleting teacher account in successful.',
                contents: $data,
            );
        }

        return response()->ApiFailed(
            message   : 'failed to delete teacher account',
            contents  : $data,
            statusCode: 500,
        );
    }
}