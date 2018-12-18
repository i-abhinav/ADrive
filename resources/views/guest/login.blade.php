@extends('layout.master')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card mx-4">
			<div class="card-body p-4">
				@if(Session::has('flash_success'))
					<div class="alert alert-success">
					<h4>{{ Session::get('flash_success') }}</h4>
					</div>
				{{-- <div style="max-width:750px; margin:0 auto;"></div> --}}
				@endif
				<h1>User Login</h1>
				{{-- <p class="text-muted">Create your account</p> --}}
				<div class="main-signup">
					{!! Form::open(['route' =>'login.post', 'method'=>'POST', 'id' => 'loginForm']) !!}
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if(Session::has('flash_error'))
						<div class="alert alert-danger" id="flashError">
						{{-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> --}}
							<span>{{ Session::get('flash_error') }}</span>
						</div>
					@endif
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-user"></i>
							</span>
						</div>
						{!! Form::email('email', null, ['class' => 'form-control', 'id'=>'email', 'placeholder'=> 'Enter Email', 'required' => true]) !!}
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-lock"></i>
							</span>
						</div>
						<input type="password" name="password" class="form-control password" id="password" placeholder="Enter Password" required="true">
					</div>
					<button class="btn btn-block btn-success" type="submit">Login</button>
				</div>
				{!! Form::close() !!}
			</div>
			<div class="card-footer p-4">
				<div class="row">
					<div class="col-6">
						<a href="{{ URL::route('signup') }}" class="btn btn-block btn-secondary">
						<span>Have not Account? Signup</span>
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

$("#loginOTP").click(function(e) {
	$('#waitLoader').modal();
	var groupID = $('#group-id').val(),
		mobile = $('#mobile').val(),
		loader = $('#waitLoader'),
		err = $('#flashError');
	if(groupID == '' || mobile.length != 10) {
		// err.css("display","block").find('span').html("Please enter valid Group ID and Mobile number.")
		err.css("display","block").html("Please enter valid Group ID and Mobile number.");
		loader.modal('hide');
		return false;
	}
	
	$.ajax({
		url: "{{URL::route('login') }}",
		type: "POST",
		data: $("form#loginForm").serialize(),
		async: true,
		// callback: 'jsonLogin',
		dataType:'json',
		success: function (result) {
			// console.log(result);
		if(result.success==true)
		{
			window.location.href = "{{ URL::route('login') }}";
			loader.modal('hide');
		}
		else
		{
			err.css("display","block").html(result.responseText);
			loader.modal('hide');
		}
		},
		error: function (result) {
			// console.log(result);
			if(result.status === 500) {
			err.css("display","block").html("Somethng went wrong! Internal Server Error.");
				loader.modal('hide');
				return false;
			}
			err.css("display","block").html(result.responseText);
				loader.modal('hide');
		},
	});
});
</script>
@stop