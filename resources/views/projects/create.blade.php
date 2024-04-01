<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">
                {{ __('crud.create', ['object' => 'Project']) }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            {{ __('crud.create', ['object' => 'project']) }}
                        </div>

                        <div class="card-body">
                            @if (session('type') && session('msg'))
                                <x-alert type="danger" :message="session('msg')"/>
                            @endif

                            <form action="{{ route('projects.store') }}" method="POST">
                                @csrf

                                <div class="form-group row mb-4">
                                    <label for="name"
                                           class="col-md-4 col-form-label text-md-right">
                                        {{ __('Name') }}
                                    </label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="key"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Key') }}</label>

                                    <div class="col-md-6">
                                        <input id="key" type="text"
                                               class="form-control @error('key') is-invalid @enderror" name="key"
                                               required autocomplete="key">

                                        @error('key')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="description"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  name="description" required></textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="start_date"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>

                                    <div class="col-md-6">
                                        <input id="start_date" type="date"
                                               class="form-control @error('start_date') is-invalid @enderror"
                                               name="start_date" required>

                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="end_date"
                                           class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>

                                    <div class="col-md-6">
                                        <input id="end_date" type="date"
                                               class="form-control @error('end_date') is-invalid @enderror"
                                               name="end_date" required>

                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save') }}
                                        </button>
                                        <a class="btn btn-link" href="{{ route('projects.index') }}">
                                            {{ __('Go Back') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

