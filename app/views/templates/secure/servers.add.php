<div class="modal-header">
	<h4 class="modal-title">
		<i class="fa fa-task"></i> Add new server
	</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal" role="form">
		<div class="form-group" ng-class="{'has-success has-feedback': errorStatus == 'success', 'has-warning has-feedback': errorStatus == 'warning', 'has-error has-feedback': errorStatus == 'error'}">
			<label for="steam" class="col-sm-2 control-label">Search</label>
			<div class="col-sm-3">
				<input  type="text" class="form-control" id="server" ng-model="server.ip" placeholder="IP or Host" ng-disabled="errorStatus == 'success'">	
				<span ng-if="errorType == 'ip'" class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control" id="server" ng-model="server.port" placeholder="Port" ng-disabled="errorStatus == 'success'">	
				<span ng-if="errorType == 'port'" class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="server" ng-model="server.rcon" placeholder="RCON Password" ng-disabled="errorStatus == 'success'">	
				<span ng-if="errorType == 'rcon'" class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
			</div>
			<div class="row" ng-if="message">
				<div class="col-sm-offset-2 col-sm-10">
					<span ng-bind-html="message" class="help-block"></span>
				</div>
			</div>
		</div>
		<div ng-if="errorStatus == 'success'">
			<div class="form-group">
				<label for="server" class="col-sm-2 control-label">Server:</label>
				<div id="server" class="input-mask col-sm-10">
					<div>{{ newServer.serverName }} - {{ newServer.numberOfPlayers }}/{{ newServer.maxPlayers }} Players</div>
				</div>
			</div>
			<div ng-if="options.companion" class="form-group">
				<label for="option" class="col-sm-2 control-label">Script Options:</label>
				<div id="option" class="input-mask col-sm-10">
					<div>Options would go here for companion script, as it's enabled.</div>
				</div>
			</div>
			<div ng-if="options.companion">
				<div class="form-group">
					<label for="settings" class="col-sm-2 control-label">Server Settings:</label>
					<div id="settings" class="col-sm-3">
						<label for="multi-console" class="control-label">Allow in Multi-Console?</label>
						<select id="roles" ng-init="newServer.multiConsole = bools[1].value" ng-model="newServer.multiConsole" class="form-control input-sm" ng-options="b.value as b.name for b in bools"></select>
					</div>
					<div class="col-sm-3" popover="Whether server is hidden from guests or any custom external plugins." popover-trigger="mouseenter">
						<label for="multi-console" class="control-label" >Hidden Server?</label>
						<select id="roles" ng-init="newServer.hidden = bools[0].value" ng-model="newServer.hidden" class="form-control input-sm" ng-options="b.value as b.name for b in bools"></select>
					</div>
					<div class="col-sm-4">
						<label for="multi-console" class="control-label" >Auto-update enabled?</label>
						<select id="roles" ng-init="newServer.autoUpdate = bools[1].value" ng-model="newServer.autoUpdate" class="form-control input-sm" ng-options="b.value as b.name for b in bools"></select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-3">
						<label for="multi-console" class="control-label">Daily Restart?</label>
						<select id="roles" ng-init="newServer.dailyRestart = bools[0].value" ng-model="newServer.dailyRestart" ng-change="dailyRestartToggle(newServer.dailyRestart)" class="form-control input-sm" ng-options="b.value as b.name for b in bools"></select>
					</div>
					<div ng-if="dailyRestartEnabled">
						<div class="col-sm-3">
							<label for="multi-console" class="control-label">Restart Time (hh:mm:ss)</label>
							<input type="text" ng-init="newServer.restartTime = '00:00:00'" ng-model="newServer.restartTime" class="form-control input-sm" placeholder="hh:mm:ss"></select>
						</div>
						<div class="col-sm-4">
							<label for="multi-console" class="control-label">Restart Commands</label>
							<input type="text" ng-init="newServer.restartCommands = '_restart'" ng-model="newServer.restartCommands" class="form-control input-sm"></select>
						</div>
					</div>
				</div>
				<div ng-if="addStatus == 'warning' || addStatus == 'error'" class="form-group" ng-class="{'has-warning has-feedback': addStatus == 'warning', 'has-error has-feedback': addStatus == 'error'}">
					<div class="col-sm-offset-2 col-sm-10">
						<span ng-bind-html="addMessage" class="help-block"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div ng-if="errorStatus != 'success'">
					<button type="submit" class="btn btn-info" ng-if="!searching" ng-click="search(server)">Search!</button>
					<button type="submit" class="btn btn-info" ng-if="searching" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Searching...</button>
				</div>
				<div ng-if="errorStatus == 'success'">
					<button type="submit" class="btn btn-info" ng-if="!adding" ng-click="addServer(newServer)">Add Server!</button>
					<button type="submit" class="btn btn-info" ng-if="adding" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Adding...</button>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" ng-click="close()">Close</button>
	<button type="submit" class="btn btn-warning" ng-click="reset()">Reset</button>
</div>