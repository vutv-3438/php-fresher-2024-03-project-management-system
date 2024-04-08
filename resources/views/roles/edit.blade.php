<x-app-layout>
    {{-- Page navigation--}}
    <x-slot name="navigation"></x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ __('crud.update', ['object' => 'role']) }}
                            </h5>

                            @if (session('type') && in_array(session('type'), ['success', 'danger']) && session('msg'))
                                <x-alert :type="session('type')" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('roles.update', ['role' => $role->id, 'projectId' => getRouteParam('projectId')]) }}"
                                method="POST"
                                class="border p-3 rounded"
                            >
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        {{__('Name')}}
                                        <span class="star-maker">*</span>
                                        @if($role->isManager())
                                            (<span
                                                class="text-sm-start"><i>{{ __('The manager role can not change the name!') }}</i></span>
                                            )
                                        @endif
                                    </label>
                                    <input
                                        id="name"
                                        class="form-control
                                        @if($role->isManager()) bg-body-secondary @endif
                                        @error('name') is-invalid @enderror"
                                        type="text"
                                        name="name"
                                        value="{{ $role->name }}"
                                        @if($role->isManager()) readonly @endif
                                    />
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description"
                                           class="form-label">{{__('Description')}}</label>
                                    <textarea id="description"
                                              name="description"
                                              class="form-control
                                              @error('description') is-invalid @enderror"
                                    >{{ $role->description }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <input name="project_id" type="hidden"
                                       value="{{getRouteParam('projectId')}}"/>
                                @if($role->name !== Role::MANAGER)
                                    @can(Action::VIEW_ANY, \App\Models\RoleClaim::class)
                                        <div class="mb-3">
                                            <label for="claims" class="form-label">{{__('Claims list')}}</label>
                                            <div class="overflow-x-auto w-full border p-3 w-full col-12">
                                                <table id="claims-table" class="cell-border table table-bordered"
                                                       style="width:100%">
                                                    <thead class="bg-gray-50 p-2">
                                                    <tr>
                                                        <th scope="col"
                                                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            #
                                                        </th>
                                                        <th scope="col"
                                                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{__('Claim type')}}
                                                        </th>
                                                        <th scope="col"
                                                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{__('Claim value')}}
                                                        </th>
                                                        <th scope="col"
                                                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{__('Actions')}}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endcan
                                    @can(Action::CREATE, \App\Models\RoleClaim::class)
                                        <a href="{{ route('roleClaims.create', ['roleId' => $role->id, 'projectId' => getRouteParam('projectId')]) }}"
                                           class="underline text-primary">{{ __('Add claim') }}</a>
                                    @endcan
                                @endif
                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary me-2">{{__('Update')}}</button>
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
    @push('scripts')
        <script src="{{ asset('js/pages/roles/edit.js') }}" type="module"></script>
        <script type="module">
            const EDIT_URL = "{{ route('roleClaims.edit', ['roleId' => $role->id, 'roleClaim' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
            const DELETE_URL = "{{ route('roleClaims.destroy', ['roleId' => $role->id, 'roleClaim' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
            const DATA = {!! json_encode($role->roleClaims) !!};
            const CSRF = "{{ csrf_token() }}";

            renderDataTable(DATA, EDIT_URL, DELETE_URL, CSRF, {edit: '{{ __('Edit') }}', delete: '{{ __('Delete') }}'});
        </script>
    @endpush
</x-app-layout>
