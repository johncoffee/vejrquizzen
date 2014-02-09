angular.module('myApp.controllers', []).controller('SubmissionController', ["$scope", "SubmissionsService", function($scope, SubmissionsService) {

        $scope.hasGivenAnswer = SubmissionsService.has();
        $scope.selectedAnswer = -1;
        $scope.guessImage = null;

        $scope.votingTime = false;

        $scope.postnr = 1000;

        // construct       
        function construct() {
            $scope.options = [
                {id: 1, file: "sun"},
                {id: 3, file: "clouds_sun"},
                {id: 2, file: "clouds"},
                {id: 8, file: "fog"},
                {id: 6, file: "sun_rain"},
                {id: 4, file: "rain"},
                {id: 10, file: "rain_heavy"},
                {id: 13, file: "rain_snow"},
                {id: 11, file: "snow"},
                {id: 12, file: "snow_heavy"},
            ];

            if ($scope.hasGivenAnswer)
                setGuessImage(parseInt(SubmissionsService.get(), 10));

//            $scope.$watch('selectedAnswer', function(n, o) {
//                console.log(n, o)
//            });
            
            $scope.$watch("postnr", function(n,o) {
                
            });
            
           var now = moment();
           
           
           var hour = now.format("HH");
           var minute = now.format("mm");
           
           if ((hour == 12 || hour == 11) && (minute > 45 || minute < 15)) {               
               $scope.votingTime = true;
           }
            
            $scope.hour = hour;
//            $scope.points = (24/(hour+1))/24 * 100;
        }

        $scope.submit = function(selectedAnswer) {
            SubmissionsService.set(selectedAnswer);
            $scope.hasGivenAnswer = true;
            setGuessImage(selectedAnswer);
        };

        $scope.tryDeleteAnswer = function() {
            SubmissionsService.remove();
            $scope.guessImage = null;
            $scope.hasGivenAnswer = false;
        };


        // private

        function setGuessImage(id) {
            $scope.guessImage = _.select($scope.options, {'id': id})[0].file;
            console.log($scope.options, _.select($scope.options, {'id': id}))
        }


        construct();
    }
]);