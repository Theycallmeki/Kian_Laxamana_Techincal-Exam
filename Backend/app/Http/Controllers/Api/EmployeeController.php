<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('factory')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%");
        }

        return response()->json($query->paginate(10));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());
        return response()->json($employee->load('factory'), 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee->load('factory'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return response()->json($employee->load('factory'));
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }
}
