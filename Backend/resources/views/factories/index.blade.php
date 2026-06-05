<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Factories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('factories.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Add Factory</a>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Name</th>
                                <th class="border-b py-2 px-4">Location</th>
                                <th class="border-b py-2 px-4">Email</th>
                                <th class="border-b py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factories as $factory)
                            <tr>
                                <td class="border-b py-2 px-4">{{ $factory->factory_name }}</td>
                                <td class="border-b py-2 px-4">{{ $factory->location }}</td>
                                <td class="border-b py-2 px-4">{{ $factory->email }}</td>
                                <td class="border-b py-2 px-4">
                                    <a href="{{ route('factories.edit', $factory) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('factories.destroy', $factory) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $factories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
