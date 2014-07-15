<div class="modal-header">
	<h4 class="modal-title">
		<i class="fa fa-users"></i> Add new SSMS users
	</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal" role="form">
		<div class="form-group" ng-class="{'has-success has-feedback': success, 'has-warning has-feedback': warning, 'has-error has-feedback': error}">
			<label for="steam" class="col-sm-2 control-label">Search Steam</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="steam" ng-model="steam.id" placeholder="Steam ID or Community ID">
				<span ng-if="success" class="glyphicon glyphicon-ok form-control-feedback"></span>
				<span ng-if="warning" class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
				<span ng-if="error" class="glyphicon glyphicon-remove form-control-feedback"></span>
				<span ng-if="message" ng-bind-html="message" class="help-block"></span>
			</div>
		</div>
		<div ng-if="success">
			<div class="form-group">
				<label for="user" class="col-sm-2 control-label">User:</label>
				<div id="user" class="steam-search-profile col-sm-10">
					<div class="pull-left">
						<img class="" src="{{ user.avatar }}" alt="Avatar" />
					</div>
					<div class="nickname pull-left" ng-bind="user.nickname"></div>
				</div>
			</div>
			<div class="form-group">
				<label for="options" class="col-sm-2 control-label">Options:</label>
				<div id="options" class="col-sm-10">
					<div class="row">
						<div class="col-xs-4">
							<label for="roles" class="control-label">Roles:</label>
							<select id="roles" ng-init="user.role = null" multiple ng-multiple="true" ng-model="user.role" class="form-control input-sm" ng-options="r.friendly_name for r in roles"></select>
						</div>
						<div class="col-xs-4">
							<label for="state" class="control-label">Disabled/Enabled:</label>
							<select id="state" ng-init="user.state = states[0].value" ng-model="user.state" class="form-control input-sm" ng-options="s.value as s.name for s in states"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group has-error" ng-if="addUserError">
				<label for="error" class="col-sm-2 control-label">Error:</label>
				<div id="user" class="col-sm-10">
					<span ng-bind-html="addUserError" class="form-group-inline-error help-block"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-info" ng-if="!searching && !found" ng-click="search(steam)">Search!</button>
				<button type="submit" class="btn btn-info" ng-if="searching" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Searching...</button>
				<div ng-if="found">		
					<button ng-if="!adding" type="submit" class="btn btn-success" ng-click="addUser(user)">Add user</button>
					<button ng-if="adding" type="submit" class="btn btn-success" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Adding user...</button>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" ng-click="close()">Close</button>
	<button type="submit" class="btn btn-warning" ng-click="reset()">Reset</button>
</div>