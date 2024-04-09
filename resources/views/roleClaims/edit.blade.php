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
                                {{ __('crud.update', ['object' => 'claim']) }}
                            </h5>

                            @if (session('type') && session('msg'))
                                <x-alert type="danger" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('roleClaims.update', [
                                    'projectId' => getRouteParam('projectId'),
                                    'roleId' => getRouteParam('roleId'),
                                    'roleClaim' => $roleClaim->id,
                                ])}}"
                                method="POST"
                                class="border p-3 rounded"
                                style="padding: 10px;"
                            >
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="type">{{ __('Claim type') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select
                                            class="form-control @error('claim_type') is-invalid @enderror"
                                            id="type"
                                            name="claim_type"
                                        >
                                            @foreach($claimTypes as $index => $claimTypeItem)
                                                <option
                                                    @if($roleClaim->claim_type === $claimTypeItem) selected @endif
                                                value="{{$claimTypeItem}}"
                                                >
                                                    {{$claimTypeItem}}
                                                </option>
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
                                            @foreach($claimValues as $index => $claimValueItem)
                                                <option
                                                    value="{{$claimValueItem}}"
                                                    @if($roleClaim->claim_value === $claimValueItem) selected @endif
                                                >
                                                    {{$claimValueItem}} - ({{ __(Action::MEANINGS[$claimValueItem]) }})
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
                                    <button type="submit" class="btn btn-primary me-2">{{__('Save')}}</button>
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
