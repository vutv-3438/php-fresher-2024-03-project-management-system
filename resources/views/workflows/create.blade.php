<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('crud.create', ['object' => 'Work flow']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('crud.create', ['object' => 'Work flow']) }}
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                <x-alert type="danger" :message="$error"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('type') && session('msg'))
                <x-alert type="danger" :message="session('msg')"/>
            @endif
            <form action="{{ route('workFlows.store', ['projectId' => request()->route()->parameter('projectId')]) }}"
                  method="POST"
                  class="overflow-x-auto w-full border p-3"
                  style="padding: 10px;"
            >
                @csrf
                <div class="form-group">
                    <x-label for="title" value="Title "></x-label>
                    <x-input id="title" name="title" class="w-full"></x-input>
                </div>
                <div class="form-group">
                    <x-label for="description" value="Description"></x-label>
                    <textarea id="description" name="description" class="w-full"></textarea>
                </div>
                <input name="projectId" type="hidden" value="{{request()->route()->parameter('projectId')}}"/>

                <div class="mt-4 mb-4">
                    <x-button>
                        {{__('Create')}}
                    </x-button>
                    <a class="underline" href="{{route('projects.index')}}">{{ __('Go Back') }}</a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
