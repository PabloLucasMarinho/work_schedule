<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(?Employee $employee = null)
    {
        if ($employee) {
            Gate::authorize('view', $employee);
        }

        $schedule = Schedule::query()
            ->with(['employee'])
            ->whereHas('employee', fn ($query) => $query->where('user_id', Auth::id()))
            ->when($employee, fn ($query) => $query->where('employee_id', $employee->id))
            ->get();

        return ScheduleResource::collection($schedule);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request, Employee $employee)
    {
        Gate::authorize('view', $employee);

        $employee->schedules()->create($request->validated());

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        Gate::authorize('view', $schedule);

        return new ScheduleResource($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        Gate::authorize('update', $schedule);

        $schedule->update($request->validated());

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        Gate::authorize('delete', $schedule);

        $schedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
