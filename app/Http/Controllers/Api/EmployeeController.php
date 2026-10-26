<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::query()
            ->with(['user'])
            ->where('user_id', Auth::id())
            ->get();

        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        Gate::authorize('view', $employee);

        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        Gate::authorize('update', $employee);

        $employee->update($request->validated());

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        Gate::authorize('delete', $employee);

        $employee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
