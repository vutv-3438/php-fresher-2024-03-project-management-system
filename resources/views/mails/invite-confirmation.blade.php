@extends('layouts.mail')

@section('content')
    <h1>{{ __('Invitation confirmation') }}</h1>
    <p>{{ __('Hi') }} {{ $user->user_name }},</p>
    <p>{{ __('I got to the join the :project request, please confirm to take to the project!', ['project' => $project->name]) }}</p>
    <p><a href="{{ $confirmationUrl }}">{{ __('Confirm') }}</a></p>
    <p>{{ __('Thanks') }}!</p>
@endsection
