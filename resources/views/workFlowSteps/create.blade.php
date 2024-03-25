<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.create', ['object' => 'work flow step']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ __('crud.create', ['object' => 'work flow step']) }}
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
                                <x-alert type="danger" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('workFlowSteps.store', ['workFlowId' => getRouteParam('workFlowId'),'projectId' => getRouteParam('projectId')]) }}"
                                method="POST"
                                class="border p-3 rounded"
                                style="padding: 10px;"
                            >
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Title</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>
                                <input name="project_id" type="hidden"
                                       value="{{getRouteParam('projectId')}}"/>
                                <input name="work_flow_id" type="hidden"
                                       value="{{getRouteParam('workFlowId')}}"/>

                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                                    <a class="underline"
                                       href="{{route('workFlows.edit', ['workFlow' => getRouteParam('workFlowId'), 'projectId' => getRouteParam('projectId')])}}">{{ __('Go Back') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
