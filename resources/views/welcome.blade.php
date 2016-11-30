@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <ul class="list-group submenu">
                        <li class="list-group-item"><a href="{{ url('/lazy_tree') }}">View employee tree</a></li>
                        <li class="list-group-item"><a href="{{ url('/list') }}">View list of employee</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection