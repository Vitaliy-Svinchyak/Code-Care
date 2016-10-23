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

            $scope.addWord = function () {
                WordModel.create($scope.word).then(function (r) {
                    $scope.words.unshift(r.data.word);
                    $scope.selectedWords.push(r.data.word.id);
                    $scope.word = '';
                });

            };

            $scope.searchWord = function () {
                WordModel.search($scope.word).then(function (r) {
                    $scope.words.unshift(r.data.word);
                    $scope.selectedWords.push(r.data.word.id);
                    $scope.word = '';
                });
            };

            /**
             * Sends a request for creating hashes and displays modal window with result
             * @param Event ev
             */
            $scope.hashWords = function (ev) {
                HashModel.create($scope.selectedWords, $scope.selectedFunctions)
                    .then(function (r) {
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
    //Controller for saved words
    .controller('SavedController', ['$scope', 'HashModel',
        function ($scope, HashModel) {
            $scope.words = [];
            $scope.chosenWord = {};
            //Request for getting all saved words
            HashModel.get()
                .then(function (r) {
                    $scope.words = r.data.words;
                });

            /**
             * Selects a new word to view his hashes
             * @param word
             */
            $scope.selectWord = function (word) {
                $scope.chosenWord = $scope.words[word];
            };

            /**
             * Detects if word needs "FULL" button
             * @param hash
             * @returns {boolean}
             */
            $scope.needsFull = function(hash){
                return hash.length > 24;
            }

            /**
             * Creates a text input to get user a possibility to copy a long hash
             * @param hash
             */
            $scope.full = function (hash) {
                var issetInput = document.querySelector(`[data-hash="${hash}"] input`);
                if (issetInput) {
                    issetInput.value = hash;
                }
                else {
                    var elem = document.querySelector(`[data-hash="${hash}"]`);
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.value = hash;
                    input.classList.add('copy-input');
                    elem.textContent = '';
                    elem.appendChild(input);
                }
            };
        }]);