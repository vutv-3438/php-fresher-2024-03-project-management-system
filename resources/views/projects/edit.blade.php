@if(isset($project))
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('crud.update', ['object' => 'project']) }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ __('crud.update', ['object' => 'project']) }}
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

                <form action="{{ route('projects.update', ['id' => $project->id]) }}"
                      method="POST"
                      class="overflow-x-auto w-full border p-3"
                      style="padding: 10px;"
                >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <x-label for="name" value="Name"></x-label>
                        <x-input id="name" name="name" class="w-full" :value="$project->name"></x-input>
                    </div>
                    <div class="form-group">
                        <x-label for="key" value="Key"></x-label>
                        <x-input id="key" name="key" class="w-full" :value="$project->key"></x-input>
                    </div>
                    <div class="form-group">
                        <x-label for="description" value="Description"></x-label>
                        <textarea id="description" name="description"
                                  class="w-full">{{$project->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <x-label for="type" value="Type"></x-label>
                        <x-input id="type" name="type" class="w-full" :value="$project->type"></x-input>
                    </div>
                    <div class="form-group">
                        <x-label for="start_date" value="Start date"></x-label>
                        <input id="start_date" name="start_date" type="date"
                               value="{{$project->start_date}}"/>
                    </div>
                    <div class="form-group">
                        <x-label for="end_date" value="End date"></x-label>
                        <input id="end_date" name="end_date" type="date" value="{{$project->end_date}}"/>
                    </div>
                    <div class="mt-4 mb-4">
                        <x-button>
                            {{__('Save')}}
                        </x-button>
                        <a class="underline" href="{{route('projects.index')}}">{{ __('Go Back') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </x-app-layout>
@endif
