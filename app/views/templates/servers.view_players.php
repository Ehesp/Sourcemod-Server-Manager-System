<div class="modal-header">
	<h4 class="modal-title">
		<i class="fa fa-task"></i> Server Players
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-lg-12">
			<div class="widget">
				<div class="widget-title">
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchPlayers">
					<div class="clearfix"></div>
				</div>
				<div class="widget-body no-padding">

					<loading ng-if="loading"></loading>

					<div class="error" ng-if="!loading && error">
						<span ng-bind-html="message"></span>
					</div>

					<div class="table-responsive" ng-if="!loading && !error">
						<table class="table">
							<thead>
								<tr>
									<th>Option</th>
									<th>Description</th>
									<th>Value</th>
									<th>Last Updated</th>
									<th class="text-right"><i class="fa fa-cog"></i></th>
								</tr>
							</thead>
							<tbody>
								 <tr ng-repeat="option in options | filter:searchOptions">
								 	<td ng-bind="option.friendly_name"></td>
								 	<td ng-bind="option.description"></td>
								 	<td ng-if="option.options === null">
								 		<input class="form-control" type="text" ng-model="option.value" />
								 	</td>
								 	<td ng-if="option.options !== null">
								 		<select class="form-control input-sm" ng-init="option.value = option.value" ng-model="option.value" ng-options="option for option in stringToArray(option.options, '|')"></select>
								 	</td>
								 	<td ng-bind="option.updated_at"></td>
								 	<td>
								 		<button class="btn btn-success btn-sm pull-right" ng-click="editOption(option)" tooltip="Update">
								 			<i class="fa" ng-class="{'fa-check': !saving[option.id], 'fa-spinner fa-spin': saving[option.id]}"></i>
								 		</button>
								 	</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" ng-click="close()">Close</button>
</div>