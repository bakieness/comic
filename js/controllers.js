'use strict';

/* Controllers */
var CDcontrollers = angular.module('CDcontrollers', ['firebase'])
    .constant('FIREBASE_URL', 'https://comicdatabase.firebaseio.com/');;

CDcontrollers.controller('filmsCtrl', function ($scope, $http) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var j = 0;
    var k = 0;
    var arr = [];
    var arr2 = [];

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;

    getFilms();

    function getFilms() {
        $http.post("php/getFilms.php").success(function (data) {
            for (var i = 0; i < data.length; i++) {
                if (Date.parse(data[i].sortRelease) < Date.parse(today)) {
                    arr[j] = data[i];
                    j++;
                }
                if (Date.parse(data[i].sortRelease) > Date.parse(today)) {
                    arr2[k] = data[i];
                    k++;
                }
            }
            
            $scope.films = arr;
            $scope.upcoming = arr2;
        });
    };
});

CDcontrollers.controller('tvCtrl', function ($scope, $http) {
    var today = new Date();
    var yyyy = today.getFullYear();
    var j = 0;
    var k = 0;
    var arr = [];
    var arr2 = [];

    today = yyyy;

    getShows();

    function getShows() {
        $http.post("php/getShows.php").success(function (data) {
            for (var i = 0; i < data.length; i++) {
                if (Date.parse(data[i].release) <= Date.parse(today)) {
                    arr[j] = data[i];
                    j++;
                }
                if (Date.parse(data[i].release) > Date.parse(today)) {
                    arr2[k] = data[i];
                    k++;
                }
            }
            $scope.shows = arr;
            $scope.upcoming = arr2;
        });
    };
});

CDcontrollers.controller('tvDetailsCtrl', function ($scope, $http, $routeParams) {
    var id = $routeParams.tvid;
    var arr = [];
    var arrCast = [];
    var arr1 = [];
    var arr2 = [];
    var j, k, l, m;
    j = k = l = m = 0;

    getShow();
    getCast();
    getEpisodes();
    getRelatedShows();

    function getShow() {
        $http.post("php/getShows.php").success(function (data) {
            $scope.show = data[id - 1];
        });
    };

    function getCast() {
        $http.post("php/getShowCast.php").success(function (cast) {
            for (var i = 0; i < cast.length; i++) {
                if (cast[i].tid == id) {
                    arrCast[k] = cast[i];
                    k++;
                }
            }
            $scope.cast = arrCast;
        });
    };

    function getEpisodes() {
        $http.post("php/getShowEps.php").success(function (episodes) {
            for (var i = 0; i < episodes.length; i++) {
                if (episodes[i].tvid == id) {
                    arr2[l] = episodes[i];
                    l++;
                }
            }
            for (var i = 0; i < arr2.length; i++) {
                if (typeof (arr2[i + 1]) != 'undefined')
                {
                    if (arr2[i].seasons < arr2[i + 1].seasons) {
                        arr1[m] = arr2[i];
                        m++;
                    }
                }
            }
            arr1[m] = arr2[arr2.length - 1];

            $scope.eps = arr1;
        });
    };

    function getRelatedShows() {
        $http.post("php/getShows.php").success(function (item) {
            for (var i = 0; i < item.length; i++) {
                if (item[i].universe == $scope.show.universe && item[i].title != $scope.show.title) {
                    arr[j] = item[i];
                    j++;
                }
            }
            $scope.related = arr;
        });
    };
});

CDcontrollers.controller('mvDetailsCtrl', function ($scope, $http, $routeParams, $sce) {
    var id = $routeParams.mvid;
    var arr = [];
    var arrCast = [];
    var j, k;
    j = k = 0;

    getFilm();
    getCast();
    getRelatedFilm();

    function getFilm() {
        $http.post("php/getFilms.php").success(function (data) {
            $scope.film = data[id - 1];
            $scope.film.trailer = $sce.trustAsResourceUrl(data[id - 1].trailer);
            if ($scope.film.runTime == "0") {
                $scope.film.runTime = "TBD";
            } else {
                $scope.film.runTime += " minutes";
            }
        });
    };

    function getCast() {
        $http.post("php/getFilmCast.php").success(function (cast) {
            for (var i = 0; i < cast.length; i++) {
                if (cast[i].mvid == id) {
                    arrCast[k] = cast[i];
                    k++;
                }
            }
            $scope.cast = arrCast;
        });
    };

    function getRelatedFilm() {
        $http.post("php/getFilms.php").success(function (item) {
            for (var i = 0; i < item.length; i++) {
                if (item[i].universe == $scope.film.universe && item[i].title != $scope.film.title) {
                    arr[j] = item[i];
                    j++;
                }
            }
            if (arr[0] == null) {
                arr[0] = item[0];
                arr[0].title = "No Related Films";
                arr[0].id = null;
                arr[0].poster = null;
            }
            $scope.related = arr;
        });
    };
});

CDcontrollers.controller('episodesCtrl', function ($scope, $http, $routeParams) {
    var id = $routeParams.tvid;
    var season = $routeParams.season;
    var arr = [];
    var j = 0;

    $scope.season = season;
    getShow();
    getEpisodes();

    function getShow() {
        $http.post("php/getShows.php").success(function (data) {
            $scope.show = data[id - 1];
        });
    };

    function getEpisodes() {
        $http.post("php/getEpisodes.php").success(function (data) {
            for (var i = 0; i < data.length; i++) {
                if (data[i].tvid == id && data[i].season == season) {
                    arr[j] = data[i];
                    j++;
                }
            }
            $scope.episodes = arr;
        });
    };
});

CDcontrollers.controller('tvActorCtrl', function ($scope, $http) {
    getShows();

    $scope.check_credentials = function () {
        $http.post("php/addTVactor.php", { 'fname': $scope.fname, 'lname': $scope.lname, 'show': $scope.show, 'role': $scope.role })
            .success(function (data) {
                $scope.fname = "";
                $scope.lname = "";
                $scope.role = "";
            });
    };

    function getShows() {
        $http.post("php/getShows.php").success(function (data) {
            $scope.shows = data;
        });
    };
});

CDcontrollers.controller('mvActorCtrl', function ($scope, $http) {
    getShows();

    $scope.check_credentials = function () {
        $http.post("php/addFilmActor.php", { 'fname': $scope.fname, 'lname': $scope.lname, 'film': $scope.film, 'role': $scope.role })
            .success(function () {
                $scope.fname = "";
                $scope.lname = "";
                $scope.role = "";
            });
    };

    function getShows() {
        $http.post("php/getFilms.php").success(function (data) {
            $scope.films = data;
        });
    };
});

CDcontrollers.controller('addEpCtrl', function ($scope, $http) {
    getShows();

    function getShows() {
        $http.post("php/getShows.php").success(function (data) {
            $scope.shows = data;
        });
    };

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    $scope.check_credentials = function () {
        var newrelease = formatDate($scope.release);
        $http.post("php/addEpisode.php", {
            'show': $scope.show, 'season': $scope.season, 'ep_no': $scope.ep_no, 'title': $scope.title,
            'director': $scope.director, 'release': newrelease, 'plot': $scope.plot
        })
            .success(function () {
                //$scope.season = "";
                //$scope.ep_no = "";
                //$scope.title = "";
                //$scope.director = "";
                //$scope.release = "";
                //$scope.plot = "";
            });
    };
});

CDcontrollers.controller('staffCtrl', ['$scope', 'Authentication', function ($scope, Authentication) {
    $scope.login = function () {
        Authentication.login($scope.user);
    };

    $scope.logout = function () {
        Authentication.logout();
    };

    $scope.register = function () {
        Authentication.register($scope.user);
    };
}]);

CDcontrollers.controller('addFilmCtrl', function ($scope, $http) {

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    $scope.check_credentials = function () {
        //var newrelease = formatDate($scope.release);
        $http.post("php/addFilm.php").success(function () {
                $scope.season = "";
                $scope.ep_no = "";
                $scope.title = "";
                $scope.director = "";
                $scope.release = "";
                $scope.plot = "";
            });
    };
});