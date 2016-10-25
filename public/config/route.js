/**
 * Created by opiru on 25.10.2016.
 */
;
(function () {
    'use strict';
    angular.module('app').config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/site/index.html',
                controller: 'IndexController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }])
})();