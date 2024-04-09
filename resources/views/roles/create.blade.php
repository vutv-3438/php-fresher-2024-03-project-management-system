<x-app-layout>
    {{-- Page navigation--}}
    <x-slot name="navigation"></x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ __('crud.create', ['object' => 'role']) }}
                            </h5>

                            @if (session('type') && session('msg'))
                                <x-alert type="danger" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('roles.store', ['projectId' => getRouteParam('projectId')]) }}"
                                method="POST"
                                class="border p-3 rounded"
                                style="padding: 10px;"
                            >
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">{{ __('Name') }}</label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                    />
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea id="description"
                                              name="description"
                                              class="form-control
                                              @error('description') is-invalid @enderror"
                                    ></textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <input name="projectId" type="hidden"
                                       value="{{getRouteParam('projectId')}}"/>

                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary me-2">{{ __('Create') }}</button>
                                    <a class="underline"
                                       href="{{ route('roles.index', ['projectId' => getRouteParam('projectId')]) }}">{{ __('Go Back') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
