var app = angular.module('searchModule', []);

// Defines the search controller by bringing the data into the scope.
//
app.controller('searchController', function($scope) {
  $scope.data = data;

  $scope.setQuery = function(query) {
    $scope.query = query;
    $scope.focus = false;
  };
});

// Returns the search function that will perform the filter on the data.
//
app.filter('search', function() {
  return search;
});

// Returns an array of items where the item text matches the search query. In
// this example, both the query and item are converted to lower case for easier
// matching.
//
function search(arr, query) {
  if (!query) {
    return arr;
  }

  var results = [];
  query = query.toLowerCase();

  angular.forEach(arr, function(item) {
    if (item.toLowerCase().indexOf(query) !== -1) {
      results.push(item);
    }
  });

  return results;
};