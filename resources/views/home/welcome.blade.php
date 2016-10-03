@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1>Characters</h1>
                        </div>

                        <div class="panel-body">
                            <!-- Current characters -->
                            @if($user->characters->isEmpty())
                                <p class="m-b-none">
                                    You have not created any characters.
                                </p>
                            @else
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
