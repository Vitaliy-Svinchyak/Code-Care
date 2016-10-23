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
    .controller('IndexController', ['$scope', '$http', '$mdDialog', '$mdBottomSheet',
        function ($scope, $http, $mdDialog, $mdBottomSheet) {
            $scope.word = '';
            $scope.words = [];
            $scope.functions = [];
            $scope.selectedFunctions = [];
            $scope.selectedWords = [];
            $scope.showSaved = false;

            $http.get('/getInfo')
                .then(function (r) {
                    $scope.words = r.data.words;
                    $scope.functions = r.data.functions;
                });

            $scope.existsFunction = function (item) {
                return $scope.selectedFunctions.indexOf(item) > -1;
            };

            $scope.existsWord = function (item) {
                return $scope.selectedWords.indexOf(item) > -1;
            };

            $scope.toggle = function (item, array) {
                var idx = array.indexOf(item);
                if (idx > -1) {
                    array.splice(idx, 1);
                }
                else {
                    array.push(item);
                }
            };

            $scope.addItem = function () {
                $http.get('/getInfo')
                    .then(function (r) {
                        $scope.words = r.data.words;
                        $scope.functions = r.data.functions;
                    });
            };

            $scope.addWord = function () {
                $http.post('/word', {word: $scope.word})
                    .then(function (r) {
                        $scope.words.unshift(r.data.word);
                        $scope.selectedWords.push(r.data.word.id);
                        $scope.word = '';
                    });
            };

            $scope.searchWord = function () {
                $http.post('/word/find', {word: $scope.word})
                    .then(function (r) {
                        $scope.words = r.data.words;
                        $scope.selectedWords = [];
                    });
            };

            $scope.hashWords = function (ev) {
                $http.post('/hash', {words: $scope.selectedWords, algorithms: $scope.selectedFunctions})
                    .then(function (r) {
                        console.log(r.data.words)
                        $mdDialog.show({
                            controller: 'DialogController',
                            templateUrl: '/views/site/HashedDialog.html',
                            parent: angular.element(document.body),
                            targetEvent: ev,
                            clickOutsideToClose: true,
                            locals: {
                                words: r.data.words
                            },
                        });
                    });
            };

            $scope.showListBottomSheet = function () {
                $mdBottomSheet.show({
                    templateUrl: 'bottom-sheet-list-template.html',
                    controller: 'ListBottomSheetCtrl'
                });
            };

            $scope.getSaved = function () {
                $scope.showSaved = true;
                $mdBottomSheet.show({
                    templateUrl: '/views/site/savedHashes.html',
                    controller: 'SavedController'
                })
            };

            $scope.sthSelected = function () {
                return $scope.selectedFunctions.length && $scope.selectedWords.length;
            };

        }])
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
    .controller('SavedController', ['$scope', '$http',
        function ($scope, $http) {
            $scope.words = [];
            $scope.chosenWord = {};
            $http.get('/hash')
                .then(function (r) {
                    $scope.words = r.data.words;
                });

            $scope.selectWord = function (word) {
                $scope.chosenWord = $scope.words[word];
            };

            $scope.full = function (hash) {
                var issetInput = document.querySelector(`[data-hash ="${hash}"] input`);
                if(issetInput){
                    issetInput.value = hash;
                }
                else{
                    var elem = document.querySelector(`[data-hash ="${hash}"]`);
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.value = hash;
                    input.classList.add('copy-input');
                    elem.textContent = '';
                    elem.appendChild(input);
                }
            };
        }]);