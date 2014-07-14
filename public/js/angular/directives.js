/**
 * Loading Directive
 * Usage: <loading></loading> | <div class="loading"></div>
 */

app.directive('loading', function()
{
	return {
		restrict: 'AE',
		replace: 'false',
		template: '<div class="loading"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>'
	}
});