$(document).ready(function() {

    $("#set_clocking").submit(function(e) {

        e.preventDefault();
        var clock_state = '';
        var obj = $(this),
            action = obj.attr('name');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                $.ajax({
                    type: "POST",
                    url: e.target.action,
                    data: obj.serialize() + "&is_ajax=1&type=set_clocking&latitude=" + lat + "&longitude=" + lng + "&form=" + action,
                    cache: false,
                    success: function(JSON) {
                        if (JSON.error != '') {
                            toastr.error(JSON.error);
                            Ladda.stopAll();
                        } else {
                            toastr.success(JSON.result);
                            window.location = '';
                            Ladda.stopAll();
                        }
                    }
                });
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });
});