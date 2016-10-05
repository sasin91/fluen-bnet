@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="btn-group-vertical">
                        <a type="button" href="{{ route('user.show', $user) }}" class="btn btn-default">My Account</a>
                        <button type="button" class="btn btn-default">API</button>
                        <a href="{{ url('/auth/battleNet') }}" type="button" class="btn btn-default">Attach Battle.Net Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
