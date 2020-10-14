var routeArray = new Array();

var paintRouteArray = function(){
  routeArray.forEach((hold, index) => {

  var elementId = hold.substring(0, 2);

  var elementHand = hold.substring(2, 3);

  var element = $("#" + elementId);

  element.addClass(elementHand);

  element.text(index);
  });
};

var setupRoute = function(route){
  paintRouteArray();
}

var getRouteName = function(){
  const queryString = window.location.search;

  const urlParams = new URLSearchParams(queryString);

  return urlParams.get('routename');
}

var getRoute = function(routename, callback){
  $.ajax({
     type: "GET",
     url: "api/route.php?routename=" + routename,
     success: function(responseArray) {
       routeArray = responseArray;

       callback(responseArray);
       // route[routename] = response;
       // paintRouteArray(response);
       //alert(response['response']);
     },
     error: function(jqXHR, exception) {
       console.log("get route error, see below");
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        console.log(msg);
     }
  });
}

$( document ).ready(function() {
    var routename = getRouteName();

    if(routename){
      getRoute(routename, setupRoute);
    }

    $('#holdModal').on('show.bs.modal', function (event) {
      var holdButton = $(event.relatedTarget);

      var holdId = holdButton.data('climbing-hold');

      var modal = $(this);

      modal.find('.modal-title').text('Are you sure you want to add ' + holdId + '?');

      modal.find('#climbingHoldId').val(holdId);
    });

    $('#holdModal').on('hidden.bs.modal', function (event) {
      var modal = $(this)

      $("#holdModal").find(".active").removeClass("active");
    });

    $('#update-route').on('click', function(e) {
        e.preventDefault();

        var position = $("#climbingHoldId").val();

        var handLabel = $('#holdModal').find(".active");

        if(handLabel.length < 1 ){
          alert("you need to select a hand option");
        }

        var hand = handLabel.find("input").val();

        var routename = getRouteName();

        routeArray.push(position + hand);

        paintRouteArray(routeArray);

        var payload = {};

        payload[routename] = routeArray ;

        var jsonPayload = JSON.stringify(payload);

        $.ajax({
           type: "PUT",
           url: "api/route.php",
           data: jsonPayload,
           success: function(response) {
             if(response.length > 0){
               alert(response);
             }else{
               $("#holdModal").modal('hide');
             }
           },
           error: function(e) {
               alert('Error' + e.toString());
           }
        });
        return false;
    });

    $('#delete-route').on('click', function(e) {
        e.preventDefault();

        var routename = getRouteName();

        $.ajax({
           type: "DELETE",
           url: "api/route.php",
           data: JSON.stringify(routename),
           success: function(response) {
             if(response.length > 0){
               alert(response);
             }else{
               window.location.href = '/';
             }
           },
           error: function(e) {
               alert('Error' + e.toString());
           }
        });
        return false;
    });

    $('#save-new-route').on('click', function(e) {
        e.preventDefault();

        var routeName = $("#newRouteName").val();

        $.ajax({
           type: "POST",
           url: "api/route.php",
           data: JSON.stringify(routeName),
           success: function(response) {
             if(response.length > 0){
               alert(response);
             }else{
               $("#newRouteModal").modal('hide');
               window.location.href = '?routename=' + routeName;
             }
           },
           error: function(e) {
               alert('Error' + e.toString());
           }
        });
        return false;
    });
});
