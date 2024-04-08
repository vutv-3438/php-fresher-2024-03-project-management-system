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
                                {{ __('crud.invite', ['object' => 'member']) }}
                            </h5>

                            @if ($errors->any())
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            <x-alert type="danger" :message="$error"/>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if (session('type') && session('msg'))
                                <x-alert :type="session('type')" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('members.request', ['projectId' => getRouteParam('projectId')]) }}"
                                method="POST"
                                class="border p-3 rounded"
                                style="padding: 10px;"
                            >
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        {{ __('Name') }} {{__('or') }} {{__('Email')}}
                                        <span class="text-sm">({{ __('Separated by commas') }})</span>
                                    </label>
                                    <textarea
                                        type="text"
                                        id="name"
                                        name="names_or_emails"
                                        class="form-control"
                                    >@if(session('type') === Status::DANGER){{ old('names_or_emails') }}@endif</textarea>
                                </div>
                                <input name="projectId" type="hidden"
                                       value="{{getRouteParam('projectId')}}"/>

                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary me-2">{{__('Invite')}}</button>
                                    <a class="underline"
                                       href="{{route('members.index', ['projectId' => getRouteParam('projectId')])}}">{{ __('Go Back') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
