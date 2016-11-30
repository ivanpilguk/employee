@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-sm-4">
		<p><a href="{{ url('/list') }}">Back</a></p>
		<h1>Edit Employee</h1>
		
		<form action="{{ url('/update/'.$employee->id) }}" method="POST">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<input type="hidden" name="id" value="{{ $employee->id }}" />
		    <ul class="list-group">
		        <li class="list-group-item">
		            <label>Surname:</label><br/>
		            <input class="form-control" type="text" name="surname" value="@if(old('surname')){{ old('surname') }}@else{{ $employee->surname }}@endif" />
		        </li>
		        <li class="list-group-item">
		            <label>Name:</label><br/>
		            <input class="form-control" type="text" name="name" value="@if(old('name')){{ old('name') }}@else{{ $employee->name }}@endif" />
		        </li>
		        <li class="list-group-item">
		            <label>Middlename:</label><br/>
		            <input class="form-control" type="text" name="middlename" value="@if(old('middlename')){{ old('middlename') }}@else{{ $employee->middlename }}@endif" />
		        </li>
		        <li class="list-group-item">
		            <label>Work from:</label><br/>
		            <input class="form-control" type="text" name="work_from" value="@if(old('work_from')){{ old('work_from') }}@else{{ $employee->work_from }}@endif" placeholder="YYYY-MM-DD" />
		        </li>
		        <li class="list-group-item">
		            <label>Salary:</label><br/>
		            <input class="form-control" type="text" name="salary" value="@if(old('salary')){{ old('salary') }}@else{{ $employee->salary }}@endif" />
		        </li>
		        <li class="list-group-item">
		            <label>Post:</label><br/>
		            <select class="form-control" name="post_id">
		            @foreach($posts as $post)
		            	<option value="{{ $post->id }}"@if(old('post_id')==$post->id||(!old('post_id')&&$employee->post->id==$post->id)) selected="selected"@endif>{{ $post->name }}</option>
		            @endforeach
		            </select>
		        </li>
		        <li class="list-group-item">
		            <label>Boss id:</label><br/>
		            <input class="form-control" type="text" name="boss_id" value="@if(old('boss_id')){{ old('boss_id') }}@else{{ $employee->boss_id }}@endif" />
		        </li>
		        <li class="list-group-item">
		            <input class="btn btn-default btn-info" type="submit" value="Edit" />
		        </li>
		    </ul>
		</form>

		@if ($errors->any())
		    <ul>
		        @foreach ($errors->all() as $error)
	                <li class="error text-danger">{{ $error }}</li>
	            @endforeach
		    </ul>
		@endif
	</div>
</div>
@endsection