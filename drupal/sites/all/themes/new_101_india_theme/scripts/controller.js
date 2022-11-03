var app = angular.module('loadMore', [])
.constant("constants", {
    "site_url" : "http://101indiatest.experiencecommerce.com/"
});

app.controller('recentContCtrl', function($scope, constants){
    console.log(constants.site_url);
});