<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('crud.list', ['object' => 'Project']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('crud.list', ['object' => 'Project']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('projects.create') }}'">
                    {{ __('crud.create', ['object' => 'project']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="overflow-x-auto w-full border p-3">
                <table class="divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50 p-2">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Name')}}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Key')}}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Description')}}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Type')}}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Roles with users')}}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Actions')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($projects as $index => $project)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="primary text-sm text-gray-900 text-center">{{$index}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{$project->name}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{$project->key}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{$project->description}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{$project->type}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <b>Roles:</b>
                                @foreach($project->roles as $index => $role)
                                    <div class="text-sm text-gray-900">
                                        <div>{{++$index}}: {{ $role->name}}</div>
                                        <ul>
                                            <b>Users by role:</b>
                                            @foreach($role->users as $index => $user)
                                                <li>{{++$index}}: {{ $user->first_name }} {{ $user->last_name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </td>
                            <td class="flex items-center justify-center px-6 py-4 whitespace-nowrap">
                                <x-button class="mr-2"
                                          onclick="window.location='{{ route('projects.edit', ['id'=> $project->id]) }}'">
                                    {{ __('Edit') }}
                                </x-button>
                                <form method="POST"
                                      action="{{ route('projects.destroy', ['id' => $project->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-button>
                                        {{ __('Delete') }}
                                    </x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
