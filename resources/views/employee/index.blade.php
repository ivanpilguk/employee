@extends('layouts.app')

@section('content')
<div class="container">
	<div class="page-header">
        <h1>Full Employee Tree</h1>
    </div>

    <div class="row">
	    <div class="col-sm-12">
	    @if (count($employee) > 0)
	    	<?php
			function recursion($items)
			{
			?>
				<ul>
				<?php foreach($items as $item)
				{
					?>
					<li><a href="{{ url('/lazy_tree/'.$item->id) }}">{{ $item->surname }} {{ $item->name }} {{ $item->middlename }}</a> ({{ $item->post_name }})</li>
					@if(!empty($item->group))
						<?php recursion($item->group); ?>
					@endif
				<?php
				}
				?>
				</ul>
			<?php
			}

			recursion($employee);
			?>
	    @endif
	    </div>
    </div>
</div>
@endsection
