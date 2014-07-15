<div class="modal-header">
	<h4 class="modal-title">
		<i class="fa fa-task"></i> Add new server
	</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal" role="form">
		<div class="form-group" ng-class="{'has-success has-feedback': success, 'has-warning has-feedback': warning.main, 'has-error has-feedback': error}">
			<label for="steam" class="col-sm-2 control-label">Search</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="server" ng-model="server.ip" placeholder="Server IP Address">
				<span ng-if="warning.ip" class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
			</div>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="server" ng-model="server.port" placeholder="Server Port">
				<span ng-if="warning.port" class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
			</div>
			<div class="row" ng-if="message">
				<div class="col-sm-offset-2 col-sm-10">
					<span ng-bind-html="message" class="help-block"></span>
				</div>
			</div>
		</div>
		<div ng-if="success">
			<div class="form-group">
				<label for="server" class="col-sm-2 control-label">Server:</label>
				<div id="server" class="input-mask col-sm-10">
					<div>{{ newServer.serverName }} - {{ newServer.numberOfPlayers }}/{{ newServer.maxPlayers }} Players</div>
				</div>
			</div>
			<div class="form-group" ng-class="{'has-success has-feedback': successRcon, 'has-error has-feedback': errorRcon}">
				<label for="options" class="col-sm-2 control-label">Config:</label>
				<div id="options" class="col-sm-10">
					<div class="row">
						<div class="col-xs-12">
							<label for="roles" class="control-label">RCON Password:</label>
							<input class="form-control input-sm" type="text" ng-model="server.rcon">
							<span ng-if="successRcon" class="glyphicon glyphicon-success-sign form-control-feedback"></span>
							<span ng-if="errorRcon" class="glyphicon glyphicon-error-sign form-control-feedback"></span>
							<span nf-if="!validating" ng-bind-html="messageRcon" class="help-block"></span>
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
				<button type="submit" class="btn btn-info" ng-if="!searching && !found" ng-click="search(server)">Search!</button>
				<button type="submit" class="btn btn-info" ng-if="searching" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Searching...</button>
				<div ng-if="found">	
					<button ng-if="!validating" type="submit" class="btn btn-success" ng-click="validate(server)">Validate Password</button>
					<button ng-if="validating" type="submit" class="btn btn-success" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Validating Password...</button>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" ng-click="close()">Close</button>
	<button type="submit" class="btn btn-warning" ng-click="reset()">Reset</button>
</div>