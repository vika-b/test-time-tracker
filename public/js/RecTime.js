(function() {
    'use strict';

    angular
        .module('timeTracker')
        .controller('RecTime', RecTime);

    function RecTime(time, user, $scope) {

        var captureVar = this;

        captureVar.recstime = [];
        captureVar.totalTime = {};
        captureVar.users = [];
        captureVar.user = [];

        captureVar.clockStart = moment();
        captureVar.clockFinish = moment();

        getTimeEntries();
        getUser();

        function getUser() {
            user.getUser().then(function(result) {
                captureVar.user = result;
            }, function(error) {
                console.log(error);
            });
        }

        time.getTime().then(function(results) {
            captureVar.recstime = results;
            updateTotalTime(captureVar.recstime);
        }, function(error) {
            console.log(error);
        });

        function getTimeEntries() {
            time.getTime().then(function(results) {
                captureVar.recstime = results;

                updateTotalTime(captureVar.recstime);
            }, function(error) {
                console.log(error);
            });
        }

        function updateTotalTime(recstime) {
            captureVar.totalTime = time.getTotalTime(recstime);
        }

        captureVar.logTime = function() {
            if(captureVar.clockFinish < captureVar.clockStart) {
                alert("You can't clock out before you clock in!");
                return;
            }
            if(captureVar.clockFinish - captureVar.clockStart === 0) {
                alert("Your time entry has to be greater than zero!");
                return;
            }

            time.saveTime({
                "user_id": captureVar.user[0],
                "start_time":captureVar.clockStart,
                "end_time":captureVar.clockFinish,
                "task_title":captureVar.task_title
            }).then(function(success) {
                getTimeEntries();
                console.log(success);
            }, function(error) {
                console.log(error);
            });

            getTimeEntries();

            captureVar.clockStart = moment();
            captureVar.clockFinish = moment();
            captureVar.task_title = "";
            captureVar.recTimeUser = "";

            updateTotalTime(captureVar.recstime);

        }

        captureVar.updateRecTime = function(rectime) {

            var updatedRecTime = {
                "id":rectime.id,
                "user_id":rectime.user.id,
                "start_time":rectime.start_time,
                "end_time":rectime.end_time,
                "task_title":rectime.task_title
            }

            time.updateTime(updatedRecTime).then(function(success) {
                getTimeEntries();
                $scope.showEditDialog = false;
                console.log(success);
            }, function(error) {
                console.log(error);
            });

        }

        captureVar.deleteRecTime = function(rectime) {

            var id = rectime.id;

            time.deleteTime(id).then(function(success) {
                getTimeEntries();
                console.log(success);
            }, function(error) {
                console.log(error);
            });

        }
    }
})();