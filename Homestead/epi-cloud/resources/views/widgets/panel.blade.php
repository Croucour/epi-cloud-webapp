<div class="panel panel-{{{ isset($class) ? $class : 'default' }}}">
	@if( isset($header))
		<div class="panel-heading">
			<h3 class="panel-title  @if(isset($add))pull-left @endif ">@yield ($as . '_panel_title')
				@if( isset($controls))
					<div class="panel-control pull-right">
						<a class="panelButton"><i class="fa fa-refresh"></i></a>
						<a class="panelButton"><i class="fa fa-minus"></i></a>
						<a class="panelButton"><i class="fa fa-remove"></i></a>
					</div>
				@endif
			</h3>
			@if(isset($add))
				<div class="panel-control pull-right">
					<a class="panelButton" href="{{$add['url']}}"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{$add['name']}}</button></a>
				</div>
				<div class="clearfix"></div>
			@endif

		</div>
	@endif

	<div class="panel-body">
		@yield ($as . '_panel_body')
	</div>
	@if( isset($footer))
		<div class="panel-footer">@yield ($as . '_panel_footer')</div>
	@endif
</div>

