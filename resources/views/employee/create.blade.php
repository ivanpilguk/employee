@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-sm-4">
		<p><a href="{{ url('/list') }}">Back</a></p>
		<h1>Create Employee</h1>
		
		<form action="{{ url('/add') }}" method="POST">
			{{ csrf_field() }}
		    <ul class="list-group">
		        <li class="list-group-item">
		            <label>Surname:</label><br/>
		            <input class="form-control" type="text" name="surname" value="{{ old('surname') }}" />
		        </li>
		        <li class="list-group-item">
		            <label>Name:</label><br/>
		            <input class="form-control" type="text" name="name" value="{{ old('name') }}" />
		        </li>
		        <li class="list-group-item">
		            <label>Middlename:</label><br/>
		            <input class="form-control" type="text" name="middlename" value="{{ old('middlename') }}" />
		        </li>
		        <li class="list-group-item">
		            <label>Work from:</label><br/>
		            <input class="form-control" type="text" name="work_from" value="{{ old('work_from') }}" placeholder="YYYY-MM-DD" />
		        </li>
		        <li class="list-group-item">
		            <label>Salary:</label><br/>
		            <input class="form-control" type="text" name="salary" value="{{ old('salary') }}" />
		        </li>
		        <li class="list-group-item">
		            <label>Post:</label><br/>
		            <select class="form-control" name="post_id">
		            @foreach($posts as $post)
		            	<option value="{{ $post->id }}"@if(old('post_id')==$post->id) selected="selected"@endif>{{ $post->name }}</option>
		            @endforeach
		            </select>
		        </li>
		        <li class="list-group-item">
		            <label>Boss id:</label><br/>
		            <input class="form-control" type="text" name="boss_id" value="{{ old('boss_id') }}" />
		        </li>
		        <li class="list-group-item">
		            <input class="btn btn-default btn-primary" type="submit" value="Add" />
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