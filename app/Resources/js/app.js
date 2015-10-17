var Console = console;

var app = angular.module('myApp', ['angularMoment']);

var playerTemplate = function(name, elo, isBold) {
    return sprintf(
        '%s%s <span class="badge">%s</span>%s',
        isBold ? '<b>' : '',
        name,
        elo,
        isBold ? '</b>' : ''
    );
};

app.directive('playerHtml', function() {
    return {
        template: function(elem, attr) {
            return playerTemplate(attr.name, attr.elo, attr.bold)
        }
    }
});

app.directive('gameHtml', function() {
    return {
        template: function(elem, attr) {
            return sprintf(
                '<div class="row"><div class="md4">%s</div><div class="md4 text-right">%s</div><div class="md2"><span am-time-ago="%s"></span>%s</div></div>',
                playerTemplate(attr.player1name, attr.player1elo, attr.gamewinner == 1),
                playerTemplate(attr.player2name, attr.player2elo, attr.gamewinner == 2),
                attr.gamedate,
                attr.gamedate
            );
        }
    }
});

app.controller('CreateGameCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.players = [];

    $scope.init = function() {
        $scope.players = [];
        $http.get('/api/player/get', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.players = resp.data;
        });
    }

}]);

app.controller('CreatePlayerCtrl', ['$scope', function($scope) {

}]);

app.controller('LatestCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.games = [];

    $scope.init = function() {
        $scope.games = [];
        $http.get('/api/game/', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.games = resp.data;
            Console.log($scope.games);
        });
    }

}]);

app.controller('StatsCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.stats = [];

    $scope.init = function() {
        $scope.stats = [];
        $http.get('/api/stats/total', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.stats = resp.data['gamestats'];
            $.extend($scope.stats, resp.data['playerstats']);
        });
    }

}]);
