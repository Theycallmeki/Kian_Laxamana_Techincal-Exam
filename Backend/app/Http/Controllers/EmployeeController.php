<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        // This will load the blade view that mounts the Vue component
        return view('employees.index');
    }
}
