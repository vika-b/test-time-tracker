(function() {

    'use strict';

    angular
        .module('timeTracker')
        .factory('user', user);

    function user($resource) {

        var User = $resource('/api/users/:id', {}, { 'query':  {method:'GET', isArray:false}});

        function getUser() {
            return User.query().$promise.then(function(results) {
                return results;
            }, function(error) {
                console.log(error);
            });
        }

        return {
            getUser: getUser
        }
    }
})();