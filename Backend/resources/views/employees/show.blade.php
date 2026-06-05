<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Employee Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">Employee Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <strong class="text-gray-700">First Name:</strong>
                            <p class="text-gray-900">{{ $employee->firstname }}</p>
                        </div>

                        <div>
                            <strong class="text-gray-700">Last Name:</strong>
                            <p class="text-gray-900">{{ $employee->lastname }}</p>
                        </div>

                        <div>
                            <strong class="text-gray-700">Factory:</strong>
                            <p class="text-gray-900">{{ $employee->factory ? $employee->factory->factory_name : 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <strong class="text-gray-700">Email:</strong>
                            <p class="text-gray-900">{{ $employee->email ?: 'N/A' }}</p>
                        </div>

                        <div>
                            <strong class="text-gray-700">Phone:</strong>
                            <p class="text-gray-900">{{ $employee->phone ?: 'N/A' }}</p>
                        </div>

                        <div>
                            <strong class="text-gray-700">Added On:</strong>
                            <p class="text-gray-900">{{ $employee->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 border-t pt-4">
                    <a href="{{ route('employees.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to List</a>
                    <a href="{{ route('employees.edit', $employee) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Employee</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>