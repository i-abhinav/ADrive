@extends('layout.master')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card mx-4">
			<div class="card-body p-4">
				<h1>Register</h1>
				<p class="text-muted">Create your account</p>
				<div class="main-signup">
					{!! Form::open(['route' =>'signup.post', 'method'=>'POST', 'id' => 'signupForm']) !!}
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<div class="alert alert-danger fade in" style="display:none;" id="flashError">
							@if(Session::has('flash_error'))
							{{ Session::get('flash_error') }}
							@endif
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-user"></i>
								</span>
							</div>
							{!! Form::text('name', null, ['class' => 'form-control', 'id'=>'name', 'placeholder'=> 'Enter Name', 'required' => true]) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-envelope"></i>
								</span>
							</div>
							{!! Form::email('email', null, ['class' => 'form-control', 'id'=>'email', 'placeholder'=> 'Enter Email', 'required' => true]) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<input type="password" name="password" class="form-control password" id="password" placeholder="Enter Password (Min 6 characters)" required="true">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group mb-4">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<input type="password" name="password_confirmation" class="form-control password" id="confirm_password" placeholder="Enter Confirm Password" required="true">
						</div>
					</div>
					<button class="btn btn-block btn-success" type="submit">Create Account</button>
				</div>
				{!! Form::close() !!}
			</div>
			<div class="card-footer p-4">
				<div class="row">
					<div class="col-6">
						<a href="{{ URL::route('login') }}" class="btn btn-block btn-secondary">
							<span>Already Account? Login</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	@if(Session::has('flash_error'))
		$('#flashError').css("display","block");
	@endif
</script>
@stop