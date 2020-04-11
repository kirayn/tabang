    var app = angular.module('Tabelo', ["ngRoute"]);
  
    app.directive('ngFile', ['$parse', function ($parse) {
        return {
           restrict: 'A',
           link: function(scope, element, attrs) {
              element.bind('change', function(){
              $parse(attrs.ngFile).assign(scope,element[0].files)
                 scope.$apply();
              });
           }
        };
    }]);

    app.service('checkLogin', function($location,$http){
        this.check = function(){
          //console.log('loginCheck');
          
          $mobile=window.localStorage.getItem('username');
          $token=window.localStorage.getItem('token');
          $userId=window.localStorage.getItem('userId');
          //console.log($mobile + "mob "+ $userId +" user "+ $token);
          $userstatus=null;
          if($mobile==null || $token==null){
              $location.path('/login');
              console.log('redirect to login');
          }else{
              var link="app/userstatus.php?userId= " + $userId + "&&mobile=" + $mobile + "&&token=" + $token;
              $http.get(link)
              .then(function(response){
                 var $userstatus=response.data;
                 console.log($userstatus);
                 if($userstatus!="pass"){
                  $location.path('/login');
                  console.log('redirect to login');
                }
              });
          }
        }
    });
     
    app.factory('addAction',function($http,$rootScope){
      return{
        add: function(idEntity, typeEntity, typeAction, response ){
          $userId=window.localStorage.getItem('userId');
          $http.post(
            'app/actions.php',
            {
              'idEntity':idEntity,
              'idUser':$userId,
              'idComment':0,
              'typeEntity':typeEntity,
              'typeAction':typeAction,
              'content':null
            }).then(response);
        }
      }
    });
    
    app.factory('GetData', function ($http) {
      return {
        selectOptions: function (type,passdata, response) {
            var urlLink = "app/selections.php?prop=" + type + "&&value=" + passdata;
            //console.log(urlLink);
            $http.get(urlLink).then(response);
        }
        
      }
    });

    app.factory('GetArticle', function ($http) {
      return {
        articles: function (type, response) {
          $('#loader').addClass('loaderShow');
            var urlLink = "app/articles.php?type=" + type;
            //console.log(urlLink);
            $http.get(urlLink)
            .then(response)
            .finally(function(){
                $('#loader').removeClass('loaderShow');
            });
        }
      }
    });

    app.run(function($rootScope) {
        $rootScope.ShowloginBox = function(){
          $('#loginModal').modal('show');
        }
    });
    app.run(function($rootScope,$location) {
        $rootScope.gotoHome = function(){
          $location.path('/home');
        }
    });
    app.run(function($rootScope,$location) {
        $rootScope.goBack = function(){
          self.history.back();
        }
    });
    app.run(function($rootScope,$location) {
        $rootScope.gotoForum = function(){
          $location.path('/forum');
        }
    });
    app.run(function($rootScope,$location) {
        $rootScope.getList = function(categoryId){
          $location.path( "/list/" + categoryId );
        };
    });

    //Category List Controller
    app.controller('CatController', function($scope,checkLogin,  $http, $location) {
      //console.log("window.localStorage.getItem('username')",window.localStorage.getItem('username'));
      checkLogin.check();   
      $http.get("app/categories.php")
          .then(function(response) {
              $scope.categories = response.data;
          }); 
    });

    //news controller
    app.controller('newsController', function($scope,checkLogin, GetNewsDetails,  $http, $location, $routeParams) {
      checkLogin.check();
      console.log($routeParams.newsItem);
      $scope.newsItem=$routeParams.newsItem;
    });

    //List of Advertisement Controller
    app.controller('listController', function($scope, checkLogin, addAction,  $http, $routeParams, $location) {
      checkLogin.check();
      var likecount = [];
      var tempNum=5;
        $('#loader').addClass('loaderShow');
        var urlLink = "app/list.php?categoryId=" + $routeParams.categoryId;
        $http.get(urlLink)
            .then(function(response) {
                $scope.adverts = response.data;
                //console.log(response.data);
            })
            .finally(function(){
                $('#loader').removeClass('loaderShow');
            })
        $scope.msg="List here";

        $scope.getDetails = function(advId){
            $location.path( "/detail/" + advId );
        };

        $scope.newAdv = function(){
          $location.path("/newadv");
        }
        $scope.addLike = function(index, idEntity, typeEntity, typeAction){
          if(likecount[index]!="done"){
              likecount[index]="done";
              
              addAction.add(idEntity, typeEntity, typeAction, function(response){
                tempNum=response.data;
                if(tempNum==0){
                  $scope.adverts[index].likes=Number($scope.adverts[index].likes)+1;
                }
              });
          }
        }

    });


    //Details of the Advertisements Controller
    app.controller('detailController', function($scope,$rootScope, checkLogin, addAction,  $http ,$routeParams, $location) {
      checkLogin.check();
      
      var userId=window.localStorage.getItem('userId');
      var queryId =$routeParams.advId;

      var likecount = [];
      var tempNum=5;
        $('#loader').addClass('loaderShow');
        var urlLink = "app/detail.php?advId=" + $routeParams.advId;
        $http.get(urlLink)
            .then(function(response) {
                $scope.adverts = response.data;
            })
            .finally(function(){
                $('#loader').removeClass('loaderShow');
            });
        $('#loader').addClass('loaderShow');
        var urlLink = "app/getmedia.php?advId=" + $routeParams.advId;
        $http.get(urlLink)
            .then(function(response) {
                $scope.media = response.data;
            })
            .finally(function(){
                $('#loader').removeClass('loaderShow');
            });
        $scope.msg="Details of the Advertisements";

        $scope.addLike = function(index, idEntity, typeEntity, typeAction){
          if(likecount[index]!="done"){
              likecount[index]="done";
              
              addAction.add(idEntity, typeEntity, typeAction, function(response){
                tempNum=response.data;
                if(tempNum==0){
                  $scope.adverts[index].likes=Number($scope.adverts[index].likes)+1;
                }
              });
             
          }
        }

         //Load the comments
        $scope.usermId=userId;
        $cmntUrl="app/comments.php?queryId=" + queryId + "&&postType=adv";
        $http.get($cmntUrl).then(function(response){
          //console.log(response.data);
          $scope.comments = response.data;
        });

        //delete
        $scope.delCmnt = function (commentId) {
          console.log('delete');
          $delcmUrl="app/comments.php";
          $http({
            url: 'app/comments.php',
            method: 'POST',
            data: {
              'userId': userId,
              'commentId': commentId,
              'idEntity':queryId,
              'postType':'adv'
            }
          })
          .then(function(response){
            console.log(response.data);
            $http.get("app/comments.php?queryId=" + queryId + "&&postType=adv").then(function(response){
                  $scope.comments = response.data;
            })
          });
        } //delCmnt complete

        //delete confirmation modal
        $scope.delcomment = function(commentId){
            $('#cnfModal').modal('show'); 
            $rootScope.itemId=commentId;
            $rootScope.modalmsg="શું આપ ખરેખર આ કમેન્ટ રદ કરવા માંગો છો?";
        }

        //Insert New Comment
        $scope.insertComment = function(){
          //console.log("insertcomment initiated");

          //upload files
                   var fd = new FormData();
                   fd.append('queryId',queryId);
                   fd.append('userId',userId);
                   fd.append('details',$scope.details);
                   fd.append('postType','adv');
                  angular.forEach($scope.uploadfiles,function(file){
                      fd.append('file[]',file);
                  });
                  
            $http({
            url: 'app/comments.php',
            method: "POST",
            data: fd,
            headers: {'Content-Type': undefined},
            })
            .then(function(response) {
                console.log(response.data);
                $scope.queryStatus = "અભિપ્રાય મોકલેલ છે.";
                $http.get("app/comments.php?queryId=" + queryId + "&&postType=adv").then(function(response){
                  $scope.comments = response.data;
                });
                console.log('add action');
                addAction.add(queryId, 'adv', 'cmnt', function(response){
                  console.log(response.data);
                });
            }, function(response) { // optional

            });
        }
    });

    //Forum discussion
    app.controller('discussController', function($scope,checkLogin, $rootScope,$http,$routeParams, $location){
      checkLogin.check();

      var userId=window.localStorage.getItem('userId');
      var queryId =$routeParams.queryId;
      //Load the main query details 
      var urlLink = "app/discuss.php?queryId=" + $routeParams.queryId;
        $http.get(urlLink)
            .then(function(response) {
                $scope.queries = response.data;
            });
        $scope.msg="Details of the Advertisements";

        //Load the comments
        $scope.usermId=userId;
        $cmntUrl="app/comments.php?queryId=" + $routeParams.queryId + "&&postType=que";
        $http.get($cmntUrl).then(function(response){
          $scope.comments = response.data;
        });

        //delete
        $scope.delCmnt = function (commentId) {
          console.log('delete');
          $delcmUrl="app/comments.php";
          $http({
            url: 'app/comments.php',
            method: 'POST',
            data: {
              'userId': userId,
              'commentId': commentId,
              'postType':'que'
            }
          })
          .then(function(response){
            console.log(response.data);
            $http.get("app/comments.php?queryId=" + queryId + "&&postType=que").then(function(response){
                  $scope.comments = response.data;
            })
          });
        } //delCmnt complete

        //delete confirmation modal
        $scope.delcomment = function(commentId){
            $('#cnfModal').modal('show'); 
            $rootScope.itemId=commentId;
            $rootScope.modalmsg="શું આપ ખરેખર આ કમેન્ટ રદ કરવા માંગો છો?";
        }

        //Insert New Comment
        $scope.insertComment = function(){
          //console.log("insertcomment initiated");

          //upload files
                   var fd = new FormData();
                   fd.append('queryId',queryId);
                   fd.append('userId',userId);
                   fd.append('details',$scope.details);
                   fd.append('postType','que');
                  angular.forEach($scope.uploadfiles,function(file){
                      fd.append('file[]',file);
                  });
                  
            $http({
            url: 'app/comments.php',
            method: "POST",
            data: fd,
            headers: {'Content-Type': undefined},
            })
            .then(function(response) {
                console.log(response.data);
                $scope.queryStatus = "અભિપ્રાય મોકલેલ છે.";
                $http.get("app/comments.php?queryId=" + queryId + "&&postType=que").then(function(response){
                  $scope.comments = response.data;
                })
            }, function(response) { // optional
                // failed
                //console.log(response.data);
            });
        }
    });

    //New Advertisement Entry controller
    app.controller('newadvController', function($scope,checkLogin,  GetData, $http){
      
      checkLogin.check();

      var userId = window.localStorage.getItem('userId');
      $scope.insertNewAdv = function(){ 
      $('#waiting').removeClass('hide');
           $http.post(  
                "app/insertadv.php",  
                {'userId':userId ,
                'title':$scope.title, 
                'description':$scope.description, 
                'cost':$scope.cost, 
                'categoryId':$scope.categoryId, 
                'locationId':$scope.locationId, 
                'contactPerson':$scope.contactPerson, 
                'contactNumber':$scope.contactNumber}  
           ).then(function(response){ 
            
                if(response.data[0] == 1) {
                  $lastId = response.data[1];

                  //upload files
                   var fd = new FormData();
                                     
                  angular.forEach($scope.uploadfiles,function(file){
                      fd.append('file[]',file);
                  });
                  fd.append('advId',$lastId);

                  $http({
                    method: 'post',
                    url: 'app/upload.php',
                    data: fd,
                    headers: {'Content-Type': undefined},
                  }).then(function successCallback(response) {
                    // Store response data
                    $scope.response = response.data;
                    //console.log(response.data);
                  });
                  //upload files end
                }
                
           }).finally(function(){
              $scope.status = "આપની જાહેરાત સ્વીકારવામાં આવેલી છે.";
              $('#insbtn').addClass('hide');
              $('#homebtn').removeClass('hide');
              $('#waiting').addClass('hide');
           });  

      }

      GetData.selectOptions('categories',2,function(response){
          $scope.categories=response.data;
      });

      GetData.selectOptions('location',0,function(response){
          $scope.locations=response.data;
      });
    });

    //Login & Registration controller
    app.controller('LoginController', function($scope,checkLogin, $rootScope, $location, $http, $q, $timeout) {
      checkLogin.check(); 
      var countAttempt = 1;
      $scope.message = 'Lets Login';
      $scope.optStatus = "";   
      var repeatUser = null;
      if(window.localStorage.getItem('username')!=null){
        $scope.mobile=window.localStorage.getItem('username');
        repeatUser = true;
      }

      $scope.sendOTP = function(mobile){
        console.log(countAttempt);
        
        if(countAttempt>0){
          countAttempt = countAttempt -1;
            var min= 100000;
            var max= 999999;
            var otp = Math.random() * (+max - +min) + +min;
            var cleanOtp = Math.round(otp);

            var toktext = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 20; i++)
              toktext += possible.charAt(Math.floor(Math.random() * possible.length));

            $http.get("app/checklogin.php?userPhone=" + mobile + "&otpw=" + cleanOtp + "&token=" + toktext)
              .then(function(response){
                //console.log(response.data);
                  $scope.chkLoginStat=response.data.ID;
                  $scope.token=response.data.activation;
                  console.log('sent');
                  window.localStorage.setItem('username', mobile);
              });

              $scope.genOtp = cleanOtp;
              console.log(cleanOtp);
              $('#myModal').modal('show'); 
              $rootScope.modalmsg="6 અંકો નો ઓટીપી આપના મોબાઈલ નંબર પર મોકલવામાં આવ્યો છે.";
              
        }
        else{
          $('#myModal').modal('show'); 
              $rootScope.modalmsg="6 અંકોનો ઓટીપી (OTP) પેહલા જ આપના મોબાઈલ પર મોકલી દેવામાં આવ્યો છે. કૃપા કરી થોડી વાર પ્રતીક્ષા કરો.";
          console.log('sms attempt finished');
        }
      }

      $scope.verifyOTP = function(supOtp){
        var mobile = $scope.mobile;
        if($scope.genOtp == supOtp){
            
            if($scope.chkLoginStat >= 1){
              window.localStorage.setItem("username", $scope.mobile);
              window.localStorage.setItem("userId", $scope.chkLoginStat);
              window.localStorage.setItem("token",$scope.token);
              $location.path('/profile');
            }else{

            }
        } else {
            $scope.optStatus = "દાખલ કરેલ OTP ખોટો છે. કૃપા કરી ફરી દાખલ કરો.";
        }
      }
    });

    //Update PROFILE controller
    app.controller('profileController', function($scope,checkLogin, $http, $location,$timeout){
      checkLogin.check();

      var userId = window.localStorage.getItem('userId');
      var token = window.localStorage.getItem('token');
      $http.get("app/profile.php?userId=" + userId + "&&token=" + token +"&&mode=list")
          .then(function(response){
            if(response.data == "unauthorised"){
              window.localStorage.removeItem("username");
              window.localStorage.removeItem("userId");
              window.localStorage.removeItem("token");
            }else{
              $scope.firstname=response.data.firstName;
              $scope.lastname=response.data.lastName;
              $scope.address=response.data.address;
              $scope.village=response.data.village;
              $scope.city=response.data.city;
              $scope.pincode=response.data.pincode;
              
            }
          });

      $scope.message = 'Update Profile';
      $scope.saveProfile = function(){
        $http({
        url: 'app/updateprofile.php',
        method: "POST",
        data: { 'userId' : userId,
                'firstname' : $scope.firstname,
                'lastname' : $scope.lastname,
                'address' : $scope.address,
                'village' : $scope.village,
                'city' : $scope.city,
                'pincode' : $scope.pincode },
        headers : {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function(response) {
            $scope.queryStatus = "પ્રોફાઈલ ઉપડેટ થઈ ગયેલ છે.";
            $timeout(function() {
              $location.path('/home');
            }, 3000);
        }, 
          function(response) { // optional
            // failed
        });
        //manage profile here
      }
    });

    //My Account controller
    app.controller('AccountController', function($scope,checkLogin, $http, $location,$timeout){
      checkLogin.check();

      var userId = window.localStorage.getItem('userId');
      var token = window.localStorage.getItem('token');
      
      //Load all the advertisement posted by the user
      $('#loader').addClass('loaderShow');
        var urlLink = "app/account.php?userId=" + userId;
        console.log("account list");
        $http.get(urlLink)
            .then(function(response) {
                $scope.adverts = response.data;
                console.log(response.data);
            })
            .finally(function(){
                $('#loader').removeClass('loaderShow');
            })
      $scope.message = 'Update Profile';
      
    });

    //Forum Page Controller
    app.controller('forumController', function($scope,checkLogin,  $location,$http) {
      checkLogin.check();

      $scope.message = 'Forum';
      $scope.newQuery = function(){
            $location.path( "/newquery/");
        };
      $scope.gotoHome = function(){
        $location.path("/home");
      }
      $('#loader').addClass('loaderShow');
      var urlLink = "app/queries.php";
        $http.get(urlLink)
            .then(function(response) {
                $scope.queries = response.data;
            })
            .finally(function(){
                $('#loader').removeClass('loaderShow');
            })
      
      $scope.discussQuery = function(queryId){
        $discussurl = "/discuss/" + queryId;
        $location.path($discussurl);
      }

    });

    //New Query page controller
    app.controller('newQueryController', function($scope,checkLogin, GetData,$http,$location) {
      checkLogin.check();

      var userId = window.localStorage.getItem('userId');
      $scope.insertQuery = function(){  
         $http.post(  
              "app/newquery.php",  
              {'topicId':$scope.topicId,
              'userId':userId ,
              'title':$scope.title, 
              'details':$scope.details 
              }  
         ).then(function(response){ 
              if(response['data'] == 1) {
                $scope.status = "આપના પ્રશ્નનો ફોરમમાં સમાવેશ કરી લેવામાં આવ્યો છે."; 
                $scope.title=null;
                $scope.details=null;
              }
              
         });  
      }
      GetData.selectOptions('topics',0,function(response){
        $scope.topics=response.data;
      });
    });

    //Homepage main menu
    app.controller('homeController', function($scope, GetArticle, checkLogin, $location) {
      checkLogin.check();
      $scope.gotoSection = function(page){
        $url="/" + page;
        $location.path($url);
      }

      GetArticle.articles('news',function(response){
          $scope.news=response.data;
          console.log(response.data);
      });

    });

    //Schemes page controller
    app.controller('schemesController', function($scope,GetArticle, $location) {
      GetArticle.articles('scheme',function(response){
          $scope.schemes=response.data;
          console.log(response.data);
      });
    });

    //Insurance page controller
    app.controller('insuranceController', function($scope,GetArticle, $location) {
      GetArticle.articles('insure',function(response){
          $scope.insures=response.data;
          //console.log(response.data);
      });
    });

    //ABOUT page controller
    app.controller('AboutController', function($scope,$location,$http) {

      $http.get('app/about.php').then(function(response){
          
      });

          $scope.message = "About Tabelo";
    });
    
    //ABOUT page controller
    app.controller('loanController', function($scope,$location,$http) {

      $http.get('app/loan.php').then(function(response){
          
      });

          $scope.message = "How to get Loan for Starting a Tabelo";
    });

    //ABOUT page controller
    app.controller('contactController', function($scope,$location) {
      
      $scope.message = 'Contact Us';
    });
    
    app.controller('policyController', function($scope,$location) {
      
      $scope.message = 'Contact Us';
    });

    //logout controller
    app.controller('logoutController', function($location) {
      window.localStorage.removeItem('userId');
      window.localStorage.removeItem('username');
      window.localStorage.removeItem('token');
      $location.path('/login');
    });

//ROUTES
app.config(function($routeProvider,$locationProvider) {
  $routeProvider

  .when('/directory', {
    templateUrl : 'template/categories.html',
    controller  : 'CatController'
  })

  .when('/login', {
    templateUrl : 'template/login.html',
    controller  : 'LoginController'
  })

  .when('/about', {
    templateUrl : 'template/about.html',
    controller  : 'AboutController'
  })

  .when('/account', {
    templateUrl : 'template/account.html',
    controller  : 'AccountController'
  })

  .when('/list/:categoryId', {
    templateUrl : 'template/list.html',
    controller  : 'listController'
  })

  .when('/detail/:advId', {
    templateUrl : 'template/detail.html',
    controller  : 'detailController'
  })

  .when('/newadv', {
    templateUrl : 'template/insertadv.html',
    controller  : 'newadvController'
  })

  .when('/profile', {
    templateUrl : 'template/profile.html',
    controller  : 'profileController'
  })

  .when('/logout', {
    templateUrl : 'template/logout.html',
    controller  : 'logoutController'
  })

  .when('/home', {
    templateUrl : 'template/home.html',
    controller  : 'homeController'
  })

  .when('/', {
    templateUrl : 'template/home.html',
    controller  : 'homeController'
  })

  .when('/forum', {
    templateUrl : 'template/forum.html',
    controller  : 'forumController'
  })

  .when('/newquery', {
    templateUrl : 'template/newquery.html',
    controller  : 'newQueryController'
  })

  .when('/discuss/:queryId', {
    templateUrl : 'template/discuss.html',
    controller  : 'discussController'
  })

  .when('/contact', {
    templateUrl : 'template/contact.html',
    controller  : 'contactController'
  })

  .when('/insurance', {
    templateUrl : 'template/insurance.html',
    controller  : 'insuranceController'
  })

  .when('/schemes', {
    templateUrl : 'template/schemes.html',
    controller  : 'schemesController'
  })

  .when('/loan', {
    templateUrl : 'template/loan.html',
    controller  : 'loanController'
  })

  .when('/gallery', {
    templateUrl : 'template/gallery.html',
    controller  : 'galleryController'
  })

  .when('/policy', {
    templateUrl : 'template/policy.html',
    controller  : 'policyController'
  })

  .when('/news/:newsItem', {
    templateUrl : 'template/news.html',
    controller  : 'newsController'
  })

  .otherwise({redirectTo: '/home'});

   //$locationProvider.html5Mode(true);
});