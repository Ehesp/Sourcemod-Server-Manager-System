/**
 * HTTP Request Service
 * 
 */

app.factory('http', function ($http) {

    var headers = {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    };

    return {
        post: function (path, data)
        {
            if (! angular.isDefined(data)) data = null;

            return $http({
                method: 'POST',
                url: path,
                headers: headers,
                data: data,
            });
        },
    }
});