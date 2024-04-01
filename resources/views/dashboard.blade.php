<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                @if(auth()->user()->is_admin)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ __("Manage users") }}
                                </h5>
                                <p class="card-text">
                                    {{ __("Go to manage users pages!") }}
                                </p>
                                <a href="{{ route('users.index') }}" class="btn btn-primary">
                                    {{ __("Go") }}
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ __("Manage projects") }}
                                </h5>
                                <p class="card-text">
                                    {{ __("View your projects!") }}
                                </p>
                                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                                    {{ __("Go") }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ __("Messages") }}
                                </h5>
                                <p class="card-text">
                                    {{ __("Check your messages!") }}
                                </p>
                                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                                    {{ __("Go") }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
