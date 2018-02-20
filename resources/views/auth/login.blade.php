@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="width: 550px; margin: 15% auto;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontals {{ $errors->has('username') ? ' has-error' : '' }}" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
						
					<div class="form-group">
						<label for="username">Username</label>
						<input id="username" type="text" class="form-control" name="username" value="{{ old('username')}}" placeholder="" required autofocus>
					</div>
					
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" type="password" class="form-control" name="password" placeholder="* * * * * * " required>
						
					</div>
					
						<div>
							@if ($errors->has('username'))
								<span class="help-block">
									<strong>{{ $errors->first('username') }}</strong>
								</span>
							@endif
						</div>

                        <div class="form-group login-container">
                           <button type="submit" class="btn btn-block btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
