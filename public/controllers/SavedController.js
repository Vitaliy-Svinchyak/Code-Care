/**
 * Created by opiru on 25.10.2016.
 */
;
(function () {
    'use strict';
    angular.module('app')
        //Controller for saved words
        .controller('SavedController', ['$scope', '$sce', '$mdDialog',
            'HashModel',
            function ($scope, $sce, $mdDialog,
                      HashModel) {
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
                $scope.selectWord = function (wordId) {
                    HashModel.get(wordId).then(function (r) {
                        var words = r.data.words;
                        $mdDialog.show({
                            controller: 'DialogController',
                            templateUrl: '/views/site/HashedDialog.html',
                            parent: angular.element(document.body),
                            clickOutsideToClose: true,
                            locals: {
                                words: words
                            }
                        });
                    });
                };
            }]);
})();