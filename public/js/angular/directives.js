/**
 * Loading Directive
 * Usage: <loading></loading> | <div class="loading"></div>
 */

app.directive('loading', function()
{
	return {
		restrict: 'AE',
		replace: 'false',
		templateUrl: window.template_path + 'loading.html',
	}
});