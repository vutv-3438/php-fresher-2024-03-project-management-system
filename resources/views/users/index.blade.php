<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('user.list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__("user.list")}}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('users.create') }}'">
                    {{ __('user.create') }}
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
                            {{__('Email')}}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Actions')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $index => $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="primary text-sm text-gray-900 text-center">{{$index}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="text-sm text-gray-900 text-center">{{$user->first_name}} {{$user->last_name}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{$user->email}}</div>
                            </td>
                            <td class="flex items-center justify-center px-6 py-4 whitespace-nowrap">
                                <x-button class="mr-2"
                                          onclick="window.location='{{ route('users.edit', ['user'=> $user->id]) }}'">
                                    {{ __('Edit') }}
                                </x-button>
                                <form method="POST"
                                      action="{{ route('users.destroy', ['user' => $user->id]) }}">
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
