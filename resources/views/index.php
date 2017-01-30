<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Time Tracker</title>

    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.css">

    <!-- Application Dependencies -->
    <script type="text/javascript" src="../../public/bower_components/angular/angular.js"></script>
    <script type="text/javascript" src="../../public/bower_components/angular-resource/angular-resource.js"></script>
    <script type="text/javascript" src="../../public/bower_components/angular-bootstrap/ui-bootstrap.min.js"></script>
    <script type="text/javascript" src="../../public/bower_components/angular-bootstrap/ui-bootstrap-tpls.js"></script>
    <script type="text/javascript" src="../../public/bower_components/moment/moment.js"></script>

    <!-- Application Scripts -->
    <script type="text/javascript" src="../../public/js/app.js"></script>
    <script type="text/javascript" src="../../public/js/RecTime.js"></script>
    <script type="text/javascript" src="../../public/js/time.js"></script>
    <script type="text/javascript" src="../../public/js/user.js"></script>
</head>
<body ng-app="timeTracker" ng-controller="RecTime as captureVar" ng-csp>
<div class="collapse navbar-collapse bg-info" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    <ul class="nav navbar-nav">
        <h3 class="user-name" ng-value="user.first_name">Hi, <?php echo Auth::user()->first_name; ?></h3>
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
       <?php if (Auth::guest()): ?>
        <li><a href="<?php echo url('/login'); ?>">Login</a></li>
        <li><a href="<?php echo url('/register'); ?>">Register</a></li>
        <?php else: ?>
       <li>
            <a href="<?php echo url('/logout'); ?>" class="logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
        </li>
        <?php endif; ?>
    </ul>
</div>
<div class="container-fluid form-layout">

    <div class="col-sm-12">
        <div class="time-picker">
            <span class="picker-title label label-primary">Start</span>
            <uib-timepicker ng-model="captureVar.clockStart" hour-step="1" minute-step="1" show-meridian="true"></uib-timepicker>
        </div>
        <div class="time-picker">
            <span class="picker-title label label-primary">Finish</span>
            <uib-timepicker ng-model="captureVar.clockFinish" hour-step="1" minute-step="1" show-meridian="true"></uib-timepicker>
        </div>
    </div>
    <div>
        <div class="col-sm-6">
            <div class="time-picker">
                <input class="form-control" ng-model="captureVar.task_title" placeholder="Enter the task" />
            </div>
            <div class="time-picker">
                <button class="btn btn-primary" ng-click="captureVar.logTime()">Log Time</button>
            </div>
            <input type="hidden" name="user" ng-model="captureVar.recTimeUser" ng-value="<?php echo Auth::user()->id; ?>" value="<?php echo Auth::user()->id; ?>" />
        </div>
    </div>
</div>
</div>

<div class="container">
    <div class="col-sm-8">
        <div class="well captureVar" ng-repeat="time in captureVar.recstime">
            <div class="row">
                <div class="col-sm-8">
                    <div><i class="glyphicon glyphicon-user"></i> {{time.user.first_name}} {{time.user.last_name}}</div>
                    <p><i class="glyphicon glyphicon-pencil"></i> {{time.task_title}}</p>
                </div>
                <div class="col-sm-4 time-numbers">
                    <div><i class="glyphicon glyphicon-calendar"></i> {{time.end_time | date:'MMM dd, yyyy'}}</div>
                    <div>
                        <span class="label label-primary" ng-show="time.loggedTime.duration._data.hours > 0">
                            {{time.loggedTime.duration._data.hours}} hour<span ng-show="time.loggedTime.duration._data.hours > 1">s</span>
                        </span>
                    </div>
                    <div><span class="label label-default">{{time.loggedTime.duration._data.minutes}} minutes</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-primary btn-xs" ng-click="showEditDialog = true">Edit</button>
                    <button class="btn btn-danger btn-xs" ng-click="captureVar.deleteRecTime(time)">Delete</button>
                </div>
            </div>
            <div class="row edit-time-entry" ng-show="showEditDialog === true">
                <h4>Edit Time</h4>
                <div class="time-entry">
                    <div class="timepicker">
                        <span class="timepicker-title label label-primary">Start</span>
                        <uib-timepicker ng-model="time.start_time" hour-step="1" minute-step="1" show-meridian="true"></uib-timepicker>
                    </div>
                    <div class="timepicker">
                        <span class="timepicker-title label label-primary">Finish</span>
                        <uib-timepicker ng-model="time.end_time" hour-step="1" minute-step="1" show-meridian="true"></uib-timepicker>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h5>Task Title</h5>
                    <textarea ng-model="time.task_title" class="form-control">{{time.task_title}}</textarea>
                </div>
                <div class="edit-controls">
                    <button class="btn btn-primary btn-sm" ng-click="captureVar.updateRecTime(time)">Save</button>
                    <button class="btn btn-danger btn-sm" ng-click="showEditDialog = false">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="col-sm-4">
        <div class="well time-numbers">
            <h1><i class="glyphicon glyphicon-time"></i> Total Time</h1>
            <h1><span class="label label-danger">{{captureVar.totalTime.hours}} hours</span></h1>
            <h3><span class="label label-primary">{{captureVar.totalTime.minutes}} minutes</span></h3>
        </div>
    </div>
</div>

</body>



</html>