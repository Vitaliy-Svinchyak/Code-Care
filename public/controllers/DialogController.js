/**
 * Created by opiru on 25.10.2016.
 */
;
(function () {
    'use strict';
    angular.module('app')
        //Controller for modal window with result of new hashing
        .controller('DialogController', ['$scope', '$mdDialog', 'words',
            function ($scope, $mdDialog, words) {
                $scope.words = words;

                $scope.hide = function () {
                    $mdDialog.hide();
                };

                $scope.cancel = function () {
                    $mdDialog.cancel();
                };

                $scope.close = function () {
                    $mdDialog.hide();
                };
            }])
})();