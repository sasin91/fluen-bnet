@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="well well-sm">
                    <div class="row">

                        <div class="col-sm-6 col-md-2">
                            <img src="{{ Avatar::create($user->name)->toBase64() }}" class="img-rounded img-responsive" draggable="false" />

                        </div>
                        <div class="col-sm-6 col-md-4">
                            @if (auth()->user()->getAuthIdentifier() === $user->getAuthIdentifier())
                                <a type="button"  class="btn btn-danger" href="{{ route('user.edit', $user) }}">Edit</a>
                            @endif
                            <h4>{{ $user->name }}</h4>
                            <p>
                                <i class="fa fa-envelope-o"></i> {{ $user->email }} <br />
                                <i class="fa fa-birthday-cake"></i> {{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="col-sm-6 col-md-12">
                            <div class="row nav">
                                <div class="col-md-12" style="margin: 0px;">
                                    <h1>Characters</h1>
                                    <hr>
                                    <table class="table table-borderless m-b-none">
                                        <thead>
                                        <th>Avatar</th>
                                        <th>Name</th>
                                        <th>Realm</th>
                                        <th>Level</th>
                                        <th>Guild</th>
                                        </thead>

                                        <tbody>
                                        @foreach($user->characters->groupBy('realm') as $realm => $characters)
                                            @foreach($characters as $character)
                                                <tr>
                                                    <!-- Avatar -->
                                                    <td style="vertical-align: middle;">
                                                        <img src="{{ $character->thumbnail }}" class="img-responsive" alt="Avatar">
                                                    </td>

                                                    <!-- Name -->
                                                    <td style="vertical-align: middle;">
                                                        {{ $character->name }}
                                                    </td>

                                                    <!-- Realm -->
                                                    <td style="vertical-align: middle;">
                                                        {{ $character->realm }}
                                                    </td>

                                                    <!-- Level -->
                                                    <td style="vertical-align: middle;">
                                                        {{ $character->level }}
                                                    </td>

                                                    <!-- Guild -->
                                                    <td style="vertical-align: middle;">
                                                        {{ $character->guild }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
