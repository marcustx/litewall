var routeArray = [];

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
     error: function(a,b,c) {
         //alert('Error' + e.toString());
         console.log(a,b,c);
     }
  });
}

$( document ).ready(function() {
    console.log( "ready!" );

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

    $('#save-route').on('click', function(e) {
        e.preventDefault();

        var position = $("#climbingHoldId").val();

        var handLabel = $('#holdModal').find(".active");

        if(handLabel.length < 1 ){
          alert("you need to select a hand option");
        }

        var hand = handLabel.find("input").val();

        var routename = getRouteName();

        routeArray.push(position + hand);

        console.log(routeArray);

        paintRouteArray(routeArray);

        var payload = {};

        payload[routename] = routeArray ;

        console.log(payload);

        var jsonPayload = JSON.stringify(payload);

        $.ajax({
           type: "PUT",
           url: "api/route.php",
           data: jsonPayload,
           success: function(response) {
             $("#holdModal").modal('hide');
             //alert(response['response']);
           },
           error: function(e) {
               alert('Error' + e.toString());
           }
        });
        return false;
    });
});
