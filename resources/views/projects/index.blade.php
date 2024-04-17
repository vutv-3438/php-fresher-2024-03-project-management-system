<x-app-layout :class="'d-flex justify-content-center'">
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('Manage project') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 w-full">
        <div class="container">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('crud.list', ['object' => 'Projects']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('projects.create') }}'" class="btn btn-primary">
                    {{ __('crud.create', ['object' => 'project']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="text-center"> # </th>
                        <th scope="col" class="text-center">{{__('Name')}}</th>
                        <th scope="col" class="text-center">{{__('Key')}}</th>
                        <th scope="col" class="text-center">{{__('Description')}}</th>
                        <th scope="col" class="text-center">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $index => $project)
                        <tr>
                            <td class="text-center">{{++$index}}</td>
                            <td class="text-center">{{$project->name}}</td>
                            <td class="text-center">{{$project->key}}</td>
                            <td>{{$project->description}}</td>
                            <td class="text-center">
                                <x-button class="btn btn-primary mr-2 mb-2"
                                          onclick="window.location='{{ route('projects.edit', ['projectId'=> $project->id]) }}'">
                                    {{ __('Edit') }}
                                </x-button>
                                <x-button class="btn btn-primary mr-2 mb-2"
                                          onclick="window.location='{{ route('issues.index', ['projectId' => $project->id]) }}'">
                                    {{ __('View') }}
                                </x-button>
                                <form method="POST"
                                      action="{{ route('projects.destroy', ['projectId' => $project->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="btn btn-danger mr-2 mb-2">
                                        {{ __('Delete') }}
                                    </x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $projects->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
