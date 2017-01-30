(function() {
    'use strict';

    angular.module('timeTracker')
           .factory('time', time);

    function time($resource) {

        var timeR = $resource('/api/time/:id', {}, {
            update: {
                method: 'PUT'
            }
        });

        function getTime() {
            return timeR.query().$promise.then(function(results) {
                angular.forEach(results, function(result) {
                    result.loggedTime = getTimeDiff(result.start_time, result.end_time);
                });
                return results;
            }, function(error) {
                console.log(error);
            });
        }

        function saveTime(data) {
            return timeR.save(data).$promise.then(function(success) {
                console.log(success);
            }, function(error) {
                console.log(error);
            });
        }

        function getTimeDiff(start, end) {
            var diff = moment(end).diff(moment(start));
            var duration = moment.duration(diff);
            return {
                duration: duration
            }
        }

        function updateTime(data) {
            return timeR.update({id:data.id}, data).$promise.then(function(success) {
                console.log(success);
            }, function(error) {
                console.log(error);
            });
        }

        function deleteTime(id) {
            return timeR.delete({id:id}).$promise.then(function(success) {
                console.log(success);
            }, function(error) {
                console.log(error);
            });
        }

        function getTotalTime(recstime) {
            var totalMilliseconds = 0;

            angular.forEach(recstime, function(key) {
                totalMilliseconds += key.loggedTime.duration._milliseconds;
            });

            return {
                hours: Math.floor(moment.duration(totalMilliseconds).asHours()),
                minutes: moment.duration(totalMilliseconds).minutes()
            }
        }

        return {
            getTime: getTime,
            getTimeDiff: getTimeDiff,
            getTotalTime: getTotalTime,
            saveTime: saveTime,
            updateTime: updateTime,
            deleteTime: deleteTime
        };
    }
})();