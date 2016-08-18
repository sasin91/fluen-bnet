@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(!isset($user->name))
                        <div class="modal fade show in" id="newUserModal">
                        	<div class="modal-dialog">
                        		<div class="modal-content">
                        			<div class="modal-header">
                        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        				<h4 class="modal-title">
                                            Oh, hello there & welcome.. <br/>
                                            Just one more thing before we can get started :)
                                        </h4>
                        			</div>
                        			<div class="modal-body">
                        				<form action="{{ route('api.bnet::user.create') }}" id="newUserForm" method="post" class="form-inline" role="form">
                                            {{ csrf_field() }}
                        					<div class="form-group">
                        						<label class="sr-only" for="">Name</label>
                        						<input type="text" class="form-control" name="name" id="name" placeholder="John smith" value="{{ old('name') }}" autofocus>
                        					</div>
                                        </form>
                        			</div>
                                    <!-- @TODO: Vue-ify this -->

                        			<div class="modal-footer">
                        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        				<button type="button" onclick="$('#newUserForm').submit()" class="btn btn-primary">Save changes</button>
                        			</div>
                        		</div><!-- /.modal-content -->
                        	</div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    @else

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
