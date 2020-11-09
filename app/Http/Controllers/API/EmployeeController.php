<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Employee\CreateEmployeeRequest;
use App\Http\Requests\API\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function index(): JsonResponse
    {
        $employees = Employee::all();

        return response()->json($employees);
    }

    public function store(CreateEmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());

        return response()->json($employee, Response::HTTP_CREATED);
    }

    public function show(Employee $employee):JsonResponse
    {
        return response()->json($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $employee->update($request->validated());

        return response()->json($employee);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
