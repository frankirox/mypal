'use strict';

var controllers = angular.module('controllers', []);

controllers.factory("controllerServices", ['$http', function ($http) {

    var serviceBase = '/api/v1/pet';
    var obj = {};

    obj.getPets = function () {
        return $http.get(serviceBase);
    };

    obj.getPet = function (id) {
        return $http.get(serviceBase + '/' + id);
    };

    obj.insertPet = function (pet) {
        return $http.post(serviceBase, pet);
    };

    obj.updatePet = function (id, pet) {
        return $http.put(serviceBase + '/' + id, pet);
    };

    obj.deletePet = function (id) {
        return $http.delete(serviceBase + '/' + id);
    };

    return obj;
}]);

controllers.controller('MainController', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {
        $scope.loggedIn = function () {
            return Boolean($window.sessionStorage.access_token);
        };

        $scope.logout = function () {
            delete $window.sessionStorage.access_token;
            $location.path('/login').replace();
        };
    }
]);

controllers.controller('PetsController', ['$scope', 'controllerServices',
    function ($scope, controllerServices) {
        controllerServices.getPets().success(function (data) {

            $scope.pets = data;

            $scope.deletePet = function (pet) {

                if (confirm("Are you sure to delete pet number: " + pet.id))
                    controllerServices.deletePet(pet.id).then(function () {
                        controllerServices.getPets().success(function (data) {

                            $scope.pets = data;

                        });
                    });
            };

        });
    }
]);

controllers.controller('PetCreateController', ['$scope', '$routeParams', '$location', 'controllerServices', function ($scope, $routeParams, $location, controllerServices) {

    $scope.pet = {};

    $scope.savePet = function (pet) {

        controllerServices.insertPet(pet).then(function () {

            $location.path('/pets').replace();

        });

    };


}]);

controllers.controller('PetEditController', ['$scope', '$routeParams', '$location', 'controllerServices', function ($scope, $routeParams, $location, controllerServices) {

    var petId = ($routeParams.petId) ? parseInt($routeParams.petId) : 0;

    controllerServices.getPet(petId).success(function (data) {

        $scope.pet = data;

        $scope.savePet = function (pet) {

            controllerServices.updatePet(pet.id, pet).then(function () {

                $location.path('/pets').replace();
            });

        };

    });


}]);

controllers.controller('LoginController', ['$scope', '$http', '$window', '$location',
    function ($scope, $http, $window, $location) {
        $scope.login = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('/api/v1/auth/login', $scope.userModel).success(
                function (data) {
                    $window.sessionStorage.access_token = data.access_token;
                    $location.path('/pets').replace();
                }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };
    }
]);