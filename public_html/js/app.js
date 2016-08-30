var app = angular.module('spanish', []);
var base_url = 'http://spanish-clinic.esy.es/';
app.controller('registroController',function($scope,$http){
  $scope.registrar = function(user){
    var urlRegistro = base_url + 'api/registro';
    console.log(user);
    $http.post(urlRegistro,user).success(function($response){

    })
  }
  
})



