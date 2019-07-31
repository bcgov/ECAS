@extends('app')

@section('api_token'){{ $api_token }}@endsection

@section('content')
    <div id="app">
        <dashboard-component
            :user="{{ json_encode($user) }}"
            :user_credentials="{{ json_encode($user_credentials) }}"
            :assignments="{{ json_encode($assignments) }}"
            :sessions="{{ json_encode($sessions) }}"
            :subjects="{{ json_encode($subjects) }}"
            :districts="{{ json_encode($districts) }}"
            :regions="{{ json_encode($regions) }}"
            :credentials="{{ json_encode($credentials) }}"
            :schools="{{ json_encode($schools) }}"
        >
        </dashboard-component>
    </div>
@endsection
h