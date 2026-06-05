<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4 flex justify-end">
                    <a href="{{ route('employees.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Employee
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b py-2 px-4">First Name</th>
                            <th class="border-b py-2 px-4">Last Name</th>
                            <th class="border-b py-2 px-4">Factory</th>
                            <th class="border-b py-2 px-4">Email</th>
                            <th class="border-b py-2 px-4">Phone</th>
                            <th class="border-b py-2 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td class="border-b py-2 px-4">{{ $employee->firstname }}</td>
                                <td class="border-b py-2 px-4">{{ $employee->lastname }}</td>
                                <td class="border-b py-2 px-4">
                                    {{ $employee->factory ? $employee->factory->factory_name : 'N/A' }}</td>
                                <td class="border-b py-2 px-4">{{ $employee->email }}</td>
                                <td class="border-b py-2 px-4">{{ $employee->phone }}</td>
                                <td class="border-b py-2 px-4 text-center">
                                    <a href="{{ route('employees.show', $employee) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                                    <a href="{{ route('employees.edit', $employee) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>