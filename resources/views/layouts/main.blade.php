<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Code&Care</title>

    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet prefetch"
          href="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.1/angular-material.css">
</head>
<body ng-controller="IndexController">
<div id="main" class="container">
    <!-- Здесь будет динамическое содержимое -->
    <div ng-view class="main-view"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-route.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
<script src="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.1/angular-material.js"></script>
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/controllers/main.js') }}"></script>
{{--<script src="{{ asset('/models/HashedWord.js') }}"></script>--}}
</body>
</html>