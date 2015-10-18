var Console = console;

var app = angular.module('myApp', ['angularMoment', 'cgNotify']);

function doNotify(notify, type, message) {
    notify({
        message: message,
        position: 'left',
        classes: (type == 'success' ? 'cg-success' : 'cg-error')
    });
}

var playerTemplate = function(name, elo, isBold) {
    return sprintf(
        '<span class="badge">%s</span> <span class="%s">%s</span>',
        elo,
        isBold == 1 ? 'winner' : isBold == 2 ? '' : 'loser',
        name
    );
};

app.directive('playerHtml', function() {
    return {
        restrict: 'A',
        template: function(elem, attr) {
            return playerTemplate(attr.name, attr.elo, attr.bold)
        }
    }
});

app.directive('gameHtml', function() {
    return {
        restrict: 'A',
        templateUrl: 'templates/game.html'
    }
});

app.controller('CreateGameCtrl', ['$scope', '$http', 'notify', function($scope, $http, notify) {

    $scope.players = [];

    $scope.player1 = undefined;
    $scope.player2 = undefined;
    $scope.games = [];
    $scope.showWinner = false;

    $scope.deleteGame = function(id) {
        $http.delete('/api/game/' + id).then(function successCallback() {
            doNotify(notify, 'success', 'Game deleted');
        }, function errorCallback(resp) {
            doNotify(notify, 'error', 'Game not deleted - ' + resp.data);
        });
    };

    $scope.addGame = function(winner) {
        if (this.player1 && this.player2) {
            $http.post('/api/game/add', {
                p1: this.player1,
                p2: this.player2,
                winner: winner
            }).then(function successCallback(resp) {
                doNotify(notify, 'success', 'Game created');
                $scope.games = [];
                $scope.player1 = undefined;
                $scope.player2 = undefined;
                $scope.showWinner = false;
                //select1.val("").trigger("change");
                //select2.val("").trigger("change");
            });
        }
    };

    $scope.update = function() {
        this.showWinner = false;
        if (this.player1 && this.player2) {
            this.showWinner = true;
            $http.get('/api/game/players', {
                params: {
                    p1: this.player1,
                    p2: this.player2
                },
                responseType: 'json'
            }).then(function successCallback(resp) {
                $scope.games = resp.data;
            })
        }
    };

    channel.bind('player.create', function(data) {
        $scope.init();
    });

    $scope.init = function() {
        $http.get('/api/player/get', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.players = resp.data;
        });
    }

}]);

app.controller('CreatePlayerCtrl', ['$scope', '$http', 'notify', function($scope, $http, notify) {
    $scope.player = undefined;

    $scope.create = function() {
        if (this.player) {
            $http.post('/api/player/add', {
                name: this.player
            }).then(function successCallback(resp) {
                doNotify(notify, 'success', 'Player created');
            }, function errorCallback(resp) {
                doNotify(notify, 'error', 'Player not created - ' + resp.data);
            })
        }
    };

}]);

app.controller('LatestCtrl', ['$scope', '$http', 'notify', function($scope, $http, notify) {

    $scope.games = [];

    channel.bind('game.create', function(data) {
        $scope.init();
    });

    channel.bind('game.deleted', function(data) {
        $scope.init();
    });

    $scope.deleteGame = function(id) {
        $http.delete('/api/game/' + id).then(function successCallback() {
            doNotify(notify, 'success', 'Game deleted');
        }, function errorCallback(resp) {
            doNotify(notify, 'error', 'Game not deleted - ' + resp.data);
        });
    };

    $scope.init = function() {
        $http.get('/api/game/', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.games = resp.data;
        });
    }

}]);

app.controller('StatsCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.stats = [];
    $scope.players = [];

    channel.bind('stats.updated', function(data) {
        $scope.init();
    });

    $scope.init = function() {
        $http.get('/api/stats/total', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.stats = resp.data['gamestats'];
            $.extend($scope.stats, resp.data['playerstats']);
        });

        $http.get('/api/player/get', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.players = resp.data;
        });
    }

}]);
