<x-app-layout :isHeaderWidthFull="true" class="flex">
    <x-slot name="navigation">
        @include('layouts.navigation', ['extendedClasses' => '!max-w-none'])
    </x-slot>

    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('crud.list', ['object' => 'Step']) }}
        </h2>
    </x-slot>

    <div class="py-12 grow">
        <div class="sm:pr-6 lg:pr-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('crud.list', ['object' => 'Step']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('issues.create', ['projectId' => $project->id]) }}'">
                    {{ __('crud.create', ['object' => 'step']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="overflow-x-auto w-full border p-3">
                <table class="border-separate divide-y divide-gray-200 border w-full">
                    <thead class="bg-gray-50 p-2">
                    <tr>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Title')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Description')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Actions')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                    @foreach($workflows as $index => $workflow)
                        <tr>
                            <td class="border px-6 py-4 whitespace-nowrap">
                                <div class="primary text-sm text-gray-900 text-center">{{$index}}</div>
                            </td>
                            <td class="border px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{$workflow->title}}</div>
                            </td>
                            <td class="border px-6 py-4">
                                <div class="text-sm text-gray-900 text-center">{{$workflow->description}}</div>
                            </td>
                            <td class="border px-6 py-4 whitespace-nowrap">
                                <x-button class="mr-2 mb-2"
                                          onclick="window.location='{{ route('workFlows.edit', ['workFlow' => $workflow->id, 'projectId'=> $project->id]) }}'">
                                    {{ __('Edit') }}
                                </x-button>
                                <form method="POST"
                                      action="{{ route('workFlows.destroy', ['workFlow' => $workflow->id, 'projectId' => $project->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="mr-2 mb-2">
                                        {{ __('Delete') }}
                                    </x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $workflows->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
