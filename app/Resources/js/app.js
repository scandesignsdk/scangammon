var Console = console;

var app = angular.module('myApp', ['angularMoment', 'cgNotify', 'ng-sweet-alert']);

function doNotify(notify, type, message) {
    notify({
        message: message,
        position: 'left',
        classes: type == 'success' ? 'cg-success' : 'cg-error'
    });
}

app.filter('cutheader', function() {
    return function(value) {
        return value.replace('[PLAYER]', '');
    }
});

app.directive('playerHtml', function() {
    return {
        restrict: 'A',
        scope: {
            player: '=',
            bold: '=',
            wintype: '='
        },
        templateUrl: '../templates/player.html'
    }
});

app.directive('statsHtml', function() {
    return {
        restrict: 'A',
        scope: {
            stat: '='
        },
        templateUrl: '../templates/stats.html'
    }
});

app.directive('statHtml', function() {
    return {
        restrict: 'A',
        scope: {
            stat: '='
        },
        templateUrl: '../templates/stat.html'
    }
});

app.directive('gameHtml', function() {
    return {
        restrict: 'A',
        templateUrl: '../templates/game.html'
    }
});

app.directive('games', function() {
    return {
        restrict: 'A',
        scope: {
            games: '=gameslist'
        },
        templateUrl: '../templates/games.html'
    }
});

app.directive('playerStats', function() {
    return {
        restrict: 'A',
        scope: {
            player: '=player'
        },
        templateUrl: '../templates/playerstats.html'
    }
});

app.controller('CreateGameCtrl', ['$scope', '$http', 'notify', function($scope, $http, notify) {

    $scope.players = [];

    $scope.player1 = undefined;
    $scope.player2 = undefined;
    $scope.wintype = 0;
    $scope.showWinner = false;
    $scope.stats = undefined;

    channel.bind('player.create', function(data) {
        $scope.players.push(JSON.parse(data));
    });

    $scope.playerSelect = function() {
        var playerlist = [];
        $scope.players.forEach(function(player) {
            playerlist.push({id: player.id, text: player.name, elo: player.elo});
        });
        return playerlist;
    }

    $scope.deleteGame = function(id) {
        $http.delete('/api/game/' + id).then(function successCallback() {
            doNotify(notify, 'success', 'Game deleted');
        }, function errorCallback(resp) {
            doNotify(notify, 'error', 'Game not deleted - ' + resp.data);
        });
    };

    $scope.addGame = function(winner) {
        if (this.player1 && this.player2 && this.player1 != this.player2) {
            $http.post('/api/game/add', {
                p1: this.player1,
                p2: this.player2,
                winner: winner,
                wintype: this.wintype
            }).then(function successCallback() {
                $scope.games = [];
                $scope.player1 = undefined;
                $scope.player2 = undefined;
                $scope.showWinner = false;
                $scope.wintype = 0;

                if(!$scope.$$phase) {
                    select1.val("").trigger("change");
                }

                if(!$scope.$$phase) {
                    select2.val("").trigger("change");
                }
            });
        }
    };

    $scope.update = function() {
        $scope.showWinner = false;
        if ($scope.player1 && $scope.player2 && this.player1 != this.player2) {
            $scope.showWinner = true;
            $http.get('/api/game/players', {
                params: {
                    p1: this.player1,
                    p2: this.player2,
                    limit: 100
                },
                responseType: 'json'
            }).then(function successCallback(resp) {
                $scope.stats = resp.data;
            })
        }
    };

    $scope.init = function() {
        $http.get('/api/player', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.players = resp.data;
        });
    }

}]);

app.controller('CreatePlayerCtrl', ['$scope', '$http', 'notify', function($scope, $http, notify) {
    $scope.player = undefined;

    channel.bind('player.create', function(data) {
        var player = JSON.parse(data);
        doNotify(notify, 'success', player.name + ' has entered the arena');
    });

    $scope.create = function() {
        if (this.player) {
            $http.post('/api/player/add', {
                name: this.player
            }).then(function successCallback() {
            }, function errorCallback(resp) {
                doNotify(notify, 'error', 'A new player could not enter the arena - ' + resp.data);
            })
        }
    };

}]);

app.controller('LatestCtrl', ['$scope', '$http', 'notify', function($scope, $http, notify) {

    $scope.games = [];

    channel.bind('game.create', function(data) {
        var game = JSON.parse(data);
        console.log('gamecreate', game);
        $scope.games.unshift(game);
        var winnerplayer = '';
        var loserplayer = '';
        if (game.winner == 1) {
            winnerplayer = game.player1.name;
            loserplayer = game.player2.name;
        } else {
            winnerplayer = game.player2.name;
            loserplayer = game.player1.name;
        }

        var msg = winnerplayer + ' has just beaten ' + loserplayer;
        if (game.wintype == 1) {
            msg = msg + ' with a gammon';
        }

        if (game.wintype == 2) {
            msg = msg + ' with a backgammon';
        }

        doNotify(notify, 'success', msg);
    });

    channel.bind('game.deleted', function() {
        $scope.init();
    });

    $scope.deleteGame = function(id) {
        $http.delete('/api/game/' + id).then(function successCallback() {
            doNotify(notify, 'success', 'The game is gone forever');
        }, function errorCallback(resp) {
            doNotify(notify, 'error', 'Oh ohh... the game could be deleted - ' + resp.data);
        });
    };

    $scope.init = function() {
        $http.get('/api/game/', {
            params: {
                limit: 100
            },
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
        var stats = JSON.parse(data);
        $scope.stats = setStats(stats);
    });

    channel.bind('player.create', function(data) {
        $scope.players.push(JSON.parse(data));
    });

    $scope.init = function() {
        $http.get('/api/stats/all', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.stats = setStats(resp.data);
            Console.log($scope.stats);
        });

        loadPlayerTopList();
    };

    function setStats(data) {
        var stats = [];
        data.gamestats.stats.forEach(function(elm) {
            stats.push(elm);
        });

        data.playerstats.stats.forEach(function(elm) {
            stats.push(elm);
        });

        return stats;
    }

    function loadPlayerTopList() {
        $http.get('/api/player', {
            responseType: 'json'
        }).then(function successCallback(resp) {
            $scope.players = resp.data;
        });
    };

}]);
