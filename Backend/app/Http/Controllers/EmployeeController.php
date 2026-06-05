<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Factory;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetch employees with pagination (10 entries per page)
        $employees = Employee::with('factory')->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        // Get all factories to populate the dropdown when adding an employee
        $factories = Factory::all();
        return view('employees.create', compact('factories'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $factories = Factory::all();
        return view('employees.edit', compact('employee', 'factories'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
