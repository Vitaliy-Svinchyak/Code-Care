/**
 * Created by opiru on 23.10.2016.
 */
;
(function () {
    'use strict';
    angular.module('app').factory("HashModel", ['$http',
        function ($http) {
            var obj = {};

            obj.create = function (selectedWords, selectedFunctions) {
                return $http.post('/hash', {words: selectedWords, algorithms: selectedFunctions});
            }

            obj.get = function (wordId) {
                if (wordId) {
                    return $http.get(`/hash/${wordId}`);
                }
                else {
                    return $http.get('/hash');
                }
            }


            return obj;
        }]);
})();