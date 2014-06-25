@if(Session::has('flash_notification'))
	<div class="row">
          <div class="col-xs-12">
			<div class="alert 
				@if(Session::has('flash_notification_level')) 
					[[ 'alert-' . Session::get('flash_notification_level') ]]
				@else
					[[ 'alert-info' ]]
				@endif
			">
				<span>[[ Session::get('flash_notification') ]]</span>
			</div>
		</div>
	</div>
@endif