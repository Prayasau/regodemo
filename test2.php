<!DOCTYPE html>
<html>
<body>
<style type="text/css">
.slide-image {

  display: none;
}
.active {
  display: block;
}
</style>
<div class="grid-item">
  <div class="slide-image active">1</div>
  <div class="slide-image">2</div>
  <div class="slide-image et_pb_text_1">3</div>
</div>




</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

$(function(){

var slides = $('.slide-image');

let interval = 5000; // initial condition
let run = setInterval(request, interval); // start setInterval as "run"

function request() {

    console.log(interval); // firebug or chrome log
    clearInterval(run); // stop the setInterval()

    var currentactive = $('.active');
	  var _target = currentactive.is(':last-child') ? slides.first() : currentactive.next();
	   slides.removeClass('active')
	  _target.addClass('active')

	  var testtt =  _target.hasClass('et_pb_text_1');

    // dynamically change the run interval
    if (testtt == true) {
        interval = 15000;
    } else {
        interval = 5000;
    }

    run = setInterval(request, interval); // start the setInterval()
}

});
</script>