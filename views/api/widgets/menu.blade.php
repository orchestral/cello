<div class="navbar">
  <div class="navbar-inner">

  		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#cellonav">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		
		{{ HTML::link(handles('orchestra::resources/cello'), 'Cello CMS', array('class' => 'brand')) }}

		<div id="cellonav" class="collapse nav-collapse">
		  	<ul class="nav">
				<li class="{{ URI::is('*/resources/cello.pages*') ? 'active' : '' }}">
					{{ HTML::link(handles('orchestra::resources/cello.pages'), 'Pages') }}
				</li>
				<!--li class="{{ URI::is('*/resources/cello/help*') ? 'active' : '' }}">
					{{ HTML::link(handles('orchestra::resources/cello/help'), 'Help') }}
				</li-->
			</ul>

			<ul class="nav pull-right">
				<li>
					<a href="{{ handles('cello') }}" target="_blank"><i class="icon-home"></i> Website</a>
				</li>
			</ul>
		</div>
	</div>
</div>