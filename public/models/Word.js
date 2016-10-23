/**
 * Created by opiru on 23.10.2016.
 */
;
(function () {
    'use strict';
    angular.module('app').factory("WordModel", ['$http',
        function ($http) {
            var obj = {};

            obj.create = function (word) {
                return $http.post('/word', {word: word});
            }

            obj.search = function (word) {
                return $http.post('/word/find', {word: word});
            }


            return obj;
        }]);
})();