<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">First Name *</label>
                        <input type="text" name="firstname" class="w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('firstname') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Last Name *</label>
                        <input type="text" name="lastname" class="w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('lastname') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Factory</label>
                        <select name="factory_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Factory --</option>
                            @foreach($factories as $factory)
                                <option value="{{ $factory->id }}" {{ old('factory_id') == $factory->id ? 'selected' : '' }}>
                                    {{ $factory->factory_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('email') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Phone</label>
                        <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ old('phone') }}">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('employees.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save
                            Employee</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>