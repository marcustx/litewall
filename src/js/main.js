var routeArray = new Array();

var resetHolds = function(){
  $(".inUse").remove();
}

var paintRouteArray = function(){
  resetHolds();

  routeArray.forEach((hold, index) => {

  var holdLength = hold.length;

  var elementId = hold.substring(0, holdLength - 1);

  var elementHand = hold.substring(holdLength - 1 , holdLength);

  var element = $("#" + elementId);

  var existingHtml = element.html();

  element.html(existingHtml + "<div class=\"" + elementHand + " inUse\"><span>" + index + "</span></div>");
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

var saveUpdatedRoute = function(routename){
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
}

var getRoute = function(routename, callback){

  var url = "api/route.php?routename=";

  if(routename){
    url = "api/route.php?routename=" + routename;
  };

  $.ajax({
     type: "GET",
     url: url,
     success: function(responseArray) {

       if(responseArray.length == 0){
         return;
       }

       if(Array.isArray(responseArray)){
         routeArray = responseArray;

         callback(responseArray);
       }else{
         alert(responseArray);
       }
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

    getRoute(routename, setupRoute);

    $('#replay-sequence').on('click', function(e) {

      var url = "api/sequence.php?routename=";

      if(routename){
        url = "api/sequence.php?routename=" + routename;
      };

      $.ajax({
         type: "GET",
         url: url,
         success: function(responseArray) {

           if(responseArray.length == 0){
             return;
           }

           if(Array.isArray(responseArray)){
             routeArray = responseArray;

             callback(responseArray);
           }else{
             alert(responseArray);
           }
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
    });

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

          return;
        }

        var hand = handLabel.find("input").val();

        var routename = getRouteName();

        routeArray.push(position + hand);

        paintRouteArray(routeArray);

        saveUpdatedRoute(routename);

        return false;
    });

    $('#undo-last-hold').on('click', function(e) {
        e.preventDefault();

        var routename = getRouteName();

        var updatedArray = routeArray.slice(0, routeArray.length -1);

        routeArray = updatedArray;

        saveUpdatedRoute(routename);

        paintRouteArray(routeArray);

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
