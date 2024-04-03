<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.create', ['object' => 'claim']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ __('crud.create', ['object' => 'claim']) }}
                            </h5>

                            @if (session('type') && session('msg'))
                                <x-alert type="danger" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('roleClaims.store', ['roleId' => getRouteParam('roleId'), 'projectId' => getRouteParam('projectId')]) }}"
                                method="POST"
                                class="border p-3 rounded"
                                style="padding: 10px;"
                            >
                                @csrf
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="type">{{ __('Claim type') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select
                                            class="form-control @error('claim_type') is-invalid @enderror"
                                            id="type"
                                            name="claim_type"
                                        >
                                            <option value="" disabled selected>{{ __('Choose type') }}</option>
                                            @foreach($claimTypes as $index => $claimType)
                                                <option value="{{$claimType}}">{{$claimType}}</option>
                                            @endforeach
                                        </select>
                                        @error('claim_type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="type">{{ __('Claim value') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select
                                            class="form-control @error('claim_value') is-invalid @enderror"
                                            id="value"
                                            name="claim_value"
                                        >
                                            <option value="" disabled selected>{{ __('Choose claim value') }}</option>
                                            @foreach($claimValues as $index => $claimValue)
                                                <option value="{{$claimValue}}">
                                                    {{$claimValue}} - ({{ __(Action::MEANINGS[$claimValue]) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('claim_value')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input name="project_id" type="hidden"
                                       value="{{getRouteParam('projectId')}}"/>
                                <input name="role_id" type="hidden"
                                       value="{{getRouteParam('roleId')}}"/>

                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary me-2">{{__('Create')}}</button>
                                    <a class="underline"
                                       href="{{route('roles.edit', [
                                        'role' => getRouteParam('roleId'),
                                        'projectId' => getRouteParam('projectId')
                                        ])}}"
                                    >
                                        {{ __('Go Back') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/pages/roleClaims/main.js') }}" type="module"></script>
    @endpush
</x-app-layout>
