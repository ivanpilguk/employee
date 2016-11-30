@extends('layouts.app')

@section('content')
<div class="container">
	<div class="page-header">
	    <h1>List of Employee</h1>
	</div>

	<p><a href="{{ url('/create') }}">Add new employee</a></p>

	<div id="employee_search" class="well">
	    <div class="row">
		   	<form id="employee_search_form" action="" method="get">
			   	<div class="col-xs-2">
			   		<input id="query_input" class="form-control" type="text" name="query" value="{{ Request::input('query') }}" placeholder="search text" />
			   	</div>
				<div class="col-xs-2">
			    	<select name="search_field" class="form-control">
			    		<option value="surname"@if(Request::input("search_field")=="surname") selected="selected"@endif>Surname</option>
			    		<option value="name"@if(Request::input("search_field")=="name") selected="selected"@endif>Name</option>
			   			<option value="middlename"@if(Request::input("search_field")=="middlename") selected="selected"@endif>Middlename</option>
			   			<option value="id"@if(Request::input("search_field")=="id") selected="selected"@endif>Id</option>
			   			<option value="work_from"@if(Request::input("search_field")=="work_from") selected="selected"@endif>Work from</option>
			   			<option value="salary"@if(Request::input("search_field")=="salary") selected="selected"@endif>Salary</option>
		    			<option value="post_id"@if(Request::input("search_field")=="post_id") selected="selected"@endif>Post id</option>
		    			<option value="boss_id"@if(Request::input("search_field")=="boss_id") selected="selected"@endif>Boss id</option>
		    		</select>
		    	</div>
		    	<div class="col-xs-1">
		    		<input class="btn btn-default btn-primary" type="submit" value="Search" />
		    	</div>
		    	<div class="col-xs-1">
		    		<input id="reset_filter" class="btn btn-default" type="button" onclick="location.href='{{ url('/list') }}';" value="View all" />
		    	</div>
	    	</form>
	  	</div>
	</div>

	<div id="employee_list">
		<div id="employee_list_inner">    
		    <div class="panel panel-default">
		    	<div class="panel-heading">
			    	<div class="row">
			    		<div class="col-sm-1"><a href="{{ URL::action('EmployeeController@grid', array_merge(Request::all(),['sort'=>'id'])) }}">Id</a></div>
						<div class="col-sm-2"><a href="{{ URL::action('EmployeeController@grid', array_merge(Request::all(),['sort'=>'surname'])) }}">Full Name</a></div>
						<div class="col-sm-1"><a href="{{ URL::action('EmployeeController@grid', array_merge(Request::all(),['sort'=>'work_from'])) }}">Work from</a></div>
						<div class="col-sm-1"><a href="{{ URL::action('EmployeeController@grid', array_merge(Request::all(),['sort'=>'salary'])) }}">Salary</a></div>
						<div class="col-sm-3"><a href="{{ URL::action('EmployeeController@grid', array_merge(Request::all(),['sort'=>'post_id'])) }}">Post</a></div>
						<div class="col-sm-2"><a href="{{ URL::action('EmployeeController@grid', array_merge(Request::all(),['sort'=>'boss_id'])) }}">Boss</a></div>
			    	</div>
		    	</div>

		        <div class="panel-body">
			    	@foreach($employee as $ind=>$e)
			    	@if($ind!=0)<hr/>@endif
			    	<div class="row">
						<div class="col-sm-1">{{ $e->id }}</div>
						<div class="col-sm-2">{{ $e->surname }} {{ $e->name }} {{ $e->middlename }}</div>
						<div class="col-sm-1">{{ $e->work_from }}</div>
						<div class="col-sm-1">{{ $e->salary }}</div>
						<div class="col-sm-3">@if ($e->post){{ $e->post->name }} (id:{{ $e->post->id }})@else-@endif</div>
						<div class="col-sm-2">@if ($e->boss){{ $e->boss->surname }} (id:{{ $e->boss->id }})@else-@endif</div>
						<div class="col-sm-1"><input class="btn btn-default btn-info" type="button" value="Edit" onclick="location.href='{{ url('/edit/'.$e->id) }}';" /></div>
						<div class="col-sm-1">
							<form action="{{ url('/delete/'.$e->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-default btn-danger">Delete</button>
                            </form>
                        </div>
					</div>
					@endforeach
				</div>
			</div>

			{{ $employee->links() }}
		</div>
	</div>
</div>
@endsection