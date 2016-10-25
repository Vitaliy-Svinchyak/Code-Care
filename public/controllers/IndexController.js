/**
 * Created by opiru on 25.10.2016.
 */
;
(function () {
    'use strict';
    angular.module('app')
        //Controller for everything with hashes
        .controller('IndexController', ['$scope', '$http', '$mdDialog', '$mdBottomSheet',
            'WordModel', 'HashModel',
            function ($scope, $http, $mdDialog, $mdBottomSheet,
                      WordModel, HashModel) {
                $scope.word = '';
                $scope.words = [];
                $scope.functions = [];
                $scope.selectedFunctions = [];
                $scope.selectedWords = [];
                $scope.showSaved = false;

                //First load of words and hash algorithms
                $http.get('/getInfo')
                    .then(function (r) {
                        $scope.words = r.data.words;
                        $scope.functions = r.data.functions;
                    });

                /**
                 * Checks if given algorithm is checked
                 * @param item
                 * @returns {boolean}
                 */
                $scope.existsFunction = function (item) {
                    return $scope.selectedFunctions.indexOf(item) > -1;
                };

                /**
                 * Checks if given word is checked
                 * @param item
                 * @returns {boolean}
                 */
                $scope.existsWord = function (item) {
                    return $scope.selectedWords.indexOf(item) > -1;
                };

                /**
                 * Checks/Uncheks given word or function
                 * @param item
                 * @param array
                 */
                $scope.toggle = function (item, array) {
                    var index = array.indexOf(item);
                    if (index > -1) {
                        array.splice(index, 1);
                    }
                    else {
                        array.push(item);
                    }
                };

                /**
                 * Adds a new word
                 */
                $scope.addWord = function () {
                    if ($scope.word.trim().length != 0) {
                        WordModel.create($scope.word).then(function (r) {
                            $scope.words.unshift(r.data.word);
                            $scope.selectedWords.push(r.data.word.id);
                            $scope.word = '';
                        });
                    }
                };

                /**
                 * Find similar words
                 */
                $scope.searchWord = function () {
                    WordModel.search($scope.word).then(function (r) {
                        $scope.words = r.data.words;
                    });
                };

                /**
                 * Sends a request for creating hashes and displays modal window with result
                 * @param Event ev
                 */
                $scope.hashWords = function (ev) {

                    HashModel.create($scope.selectedWords, $scope.selectedFunctions)
                        .then(function (r) {
                            console.log(r.data.words);
                            $mdDialog.show({
                                controller: 'DialogController',
                                templateUrl: '/views/site/HashedDialog.html',
                                parent: angular.element(document.body),
                                targetEvent: ev,
                                clickOutsideToClose: true,
                                locals: {
                                    words: r.data.words
                                }
                            });
                        });
                };

                /**
                 * Opens saved words
                 */
                $scope.getSaved = function () {
                    $scope.showSaved = true;
                    $mdBottomSheet.show({
                        templateUrl: '/views/site/savedHashes.html',
                        controller: 'SavedController'
                    })
                };

                /**
                 * Checks if user selects at least 1 word &7 1 algorithm
                 * @returns {Number}
                 */
                $scope.sthSelected = function () {
                    return $scope.selectedFunctions.length && $scope.selectedWords.length;
                };

            }])
})();