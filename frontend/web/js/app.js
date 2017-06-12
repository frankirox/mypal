'use strict';

var app = angular.module('app', [
    'ngRoute',          //$routeProvider
    'mgcrea.ngStrap',   //bs-navbar, data-match-route directives
    'controllers'       //Our module frontend/web/js/controllers.js
]);

app.factory("appServices", ['$http', function ($http) {

    var serviceBase = '/api/v1/pet';
    var obj = {};

    obj.getPet = function (id) {
        return $http.get(serviceBase + '/' + id);
    };

    return obj;
}]);

app.config(['$routeProvider', '$httpProvider',
    function ($routeProvider, $httpProvider) {
        $routeProvider.when('/', {
            templateUrl: 'partials/index.html'
        }).when('/login', {
            templateUrl: 'partials/login.html',
            controller: 'LoginController'
        }).when('/pets', {
            templateUrl: 'partials/pets.html',
            controller: 'PetsController'
        }).when('/create-pet', {
            templateUrl: 'partials/create-pet.html',
            controller: 'PetCreateController'
        }).when('/edit-pet/:petId', {
            templateUrl: 'partials/edit-pet.html',
            controller: 'PetEditController'
        }).otherwise({
            templateUrl: 'partials/404.html'
        });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

app.factory('authInterceptor', function ($q, $window, $location) {
    return {
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                //HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            return config;
        },
        responseError: function (rejection) {
            if (rejection.status === 401) {
                $location.path('/login').replace();
            }
            return $q.reject(rejection);
        }
    };
});