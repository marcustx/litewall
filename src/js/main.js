var paintRoute = function(route){
  route["routename"].forEach((hold, index) => {

  var elementId = hold.substring(0, 2);

  var elementHand = hold.substring(2, 3);

  var element = $("#" + elementId);

  element.addClass(elementHand);

  element.text(index);
  });
};

$( document ).ready(function() {
    console.log( "ready!" );

    //sample data
    var route = { "routename": ["A1L", "B2R", "C3M"] };

    paintRoute(route);

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

        route["routename"].push(position + hand);

        console.log(route);

        paintRoute(route);

        // $.ajax({
        //     type: "POST",
        //     url: "saveroute/",
        //     data: routeObject,
        //     success: function(response) {
        $("#holdModal").modal('hide');
        //         alert(response['response']);
        //     },
        //     error: function() {
        //         alert('Error');
        //     }
        // });
        return false;
    });
});
