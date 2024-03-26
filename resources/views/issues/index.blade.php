<x-app-layout class="d-flex">
    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.list', ['object' => 'Issue']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12 flex-grow-1">
        <div class="sm-6 lg-8">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('crud.list', ['object' => 'Issue']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('issues.create', ['projectId' => $project->id]) }}'">
                    {{ __('crud.create', ['object' => 'issue']) }}
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
                        <th scope="col" class="text-center text-uppercase">#</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Name')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Key')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Description')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">

                    @foreach($issues as $index => $issue)
                        <tr>
                            <td class="text-center">{{++$index}}</td>
                            <td class="text-center">{{$issue->name}}</td>
                            <td class="text-center">{{$issue->key}}</td>
                            <td>{{$issue->description}}</td>
                            <td class="text-center">
                                <x-button class="btn btn-primary me-2 mb-2"
                                          onclick="window.location='{{ route('projects.edit', ['id'=> $project->id]) }}'">
                                    {{ __('Edit') }}
                                </x-button>
                                <form method="POST" action="{{ route('projects.destroy', ['id' => $project->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="btn btn-danger mb-2">{{ __('Delete') }}</x-button>
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
