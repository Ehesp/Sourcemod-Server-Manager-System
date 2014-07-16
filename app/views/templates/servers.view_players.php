<div class="modal-header">
	<h4 class="modal-title">
		<i class="fa fa-task"></i> Server Players
	</h4>
</div>
<div class="modal-body table">
	<div class="row">
		<div class="col-lg-12">
			<loading ng-if="loading"></loading>

					<div class="error" ng-if="!loading && error">
						<span ng-bind-html="message"></span>
					</div>

					<div class="table-responsive" ng-if="!loading && !error">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>Name</th>
									<th>Score</th>
									<th>Ping</th>
									<th>Steam ID</th>
									<th>Connection Time</th>
									<th>IP</th>
								</tr>
							</thead>
							<tbody>
								 <tr ng-repeat="player in players | filter:searchPlayers">
								 	<td ng-bind="player.name"></td>
								 	<td ng-bind="player.score"></td>
								 	<td ng-bind="player.ping"></td>
								 	<td ng-bind="player.steam_id"></td>
								 	<td ng-bind="player.connection_time"></td>
								 	<td ng-bind="player.ip_address"></td>
								</tr>
							</tbody>
						</table>
					</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" ng-click="close()">Close</button>
</div>