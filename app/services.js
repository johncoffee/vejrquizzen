angular.module('myApp.services', []).service("SubmissionsService", function() {
    var that = {};

    var _value = localStorage.getItem("s");
    var _has = (_value !== null);

    that.has = function() {
        return _has;
    };

    that.get = function() {
        return _value;
    };

    that.remove = function() {
        try {
            localStorage.removeItem("s");
        }
        catch (e) {
            // probably Safari
        }
        _value = null;
        _has = false;
    };

    that.set = function(value) {
        try {
            localStorage.setItem("s", value);
            _value = value;
            _has = true;
        }
        catch (e) {
            // probably Safari
        }
    };


    return that;
});
