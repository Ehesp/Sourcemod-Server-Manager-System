// Creates an error message with a given Angular $http promise
function errorExceptionMessage(data, status, config)
{
	message = "<u class='message-heading'>An error occured!</u><br />";
	message += "Error: " + data.error.message + "<br />";
	message += "Exception: " + data.error.type + "<br />";
	message += config.method + " " + config.url + ", HTTP status " + status;

	return message;
}

// Creates an error message with a given parameters
function errorMessage(httpCode, data)
{
	message = "<u class='message-heading'>An error occured!</u><br />";
	message += "HTTP Code: " + httpCode + "<br />";
	message += "Message: " + data + "<br />";

	return message;
}

// Find the key of an object/array by specified value
function findWithAttr(array, attr, value) {
    for(var i = 0; i < array.length; i += 1) {
        if(array[i][attr] === value) {
            return i;
        }
    }
}

// Validates a number
function validateNumber(num)
{
	var regexp = /^[0-9]/g;

	return regexp.test(num);
}

// Validate a string for a valid Steam ID
function validateSteamData(string)
{
	if (! string || /[^a-zA-Z0-9_:]/.test(string)) return false;

	if (! validateNumber(string))
	{
		if(! /^STEAM_[0-5]:[01]:\d+$/.test(string)) return false;
	}

	return true;
}

// Validates an IP Address
function validateIp(ip)
{
	var regexp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/g;

	return regexp.test(ip);
}

// Validates a hostname
function validateHost(host)
{
	var regexp = /^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/g;

	return regexp.test(host);
}

// Validates a HH:MM:SS timestamp
function validateTime(time)
{
	var regexp = /([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]/g;

	return regexp.test(time);
}