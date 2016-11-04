'use strict';

/* App Module */
var app = angular.module('rjtApp', ['ngRoute', 'CDcontrollers']);

app.run(['$rootScope', '$location',
    function ($rootScope, $location) {
        $rootScope.$on('$routeChangeError', function (event, next, previous, error) {
            if (error == 'AUTH_REQUIRED') {
                $rootScope.message = "Sorry, you must login in to access this page";
                $location.path('/login');
            }
        })
    }]);

app.config(['$routeProvider',
  function ($routeProvider) {
      $routeProvider.
          when('/films', {
              templateUrl: 'views/films.html',
              controller: 'filmsCtrl'
          }).
          when('/films/:mvid', {
              templateUrl: 'views/filmDetails.html',
              controller: 'mvDetailsCtrl'
          }).
          when('/tvshows', {
              templateUrl: 'views/tvshows.html',
              controller: 'tvCtrl'
          }).
          when('/tvshows/:tvid', {
              templateUrl: 'views/showDetails.html',
              controller: 'tvDetailsCtrl'
          }).
          when('/tvshows/:tvid/:season', {
              templateUrl: 'views/showEpisodes.html',
              controller: 'episodesCtrl'
          }).
          when('/addTVactor', {
              templateUrl: 'views/addtvactor.html',
              controller: 'tvActorCtrl'
          }).
          when('/addFilmActor', {
            templateUrl: 'views/addmvactor.html',
            controller: 'mvActorCtrl'
          }).
          when('/staff', {
              templateUrl: 'views/staff.html',
              controller: 'staffCtrl',
              resolve: {
                  currentAuth: function (Authentication) {
                      return Authentication.requireAuth();
                  }
              }
          }).
          when('/addEpisode', {
              templateUrl: 'views/addEpisode.html',
              controller: 'addEpCtrl',
              resolve: {
                  currentAuth: function (Authentication) {
                      return Authentication.requireAuth();
                  }
              }
          }).
          when('/addFilm', {
              templateUrl: 'views/addFilm.html',
              controller: 'addFilmCtrl',
              resolve: {
                  currentAuth: function (Authentication) {
                      return Authentication.requireAuth();
                  }
              }
          }).
          when('/login', {
              templateUrl: 'views/login.html',
              controller: 'staffCtrl'
          }).
          when('/register', {
              templateUrl: 'views/register.html',
              controller: 'staffCtrl',
              resolve: {
                  currentAuth: function (Authentication) {
                      return Authentication.requireAuth();
                  }
              }
          }).
          otherwise({
              redirectTo: '/films'
      });
  }]);