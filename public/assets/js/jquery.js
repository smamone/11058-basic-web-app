$(document).ready(function(){

//$("#createRecord").on('change keyup keydown', 'input, textarea, select', function (e) {
//    $(this).addClass('changed-input');
//});
//    
//$(window).on('beforeunload', function () {
//    if ($('.changed-input').length) {
//        return 'You haven\'t saved your changes.';
//    }
//});
    
// Shrink nav on scroll
//if(position >= 200) {
//      $('#header').removeClass('header');
//      $('#header').addClass('customNav');
//    } else {
//      $('#header').removeClass('customNav');
//      $('#header').addClass('header');
//}
var scrollTop = 0;
$(window).scroll(function(){
    scrollTop = $(window).scrollTop();
    $('.counter').html(scrollTop);

    if (scrollTop >= 100) {
          $('#header').removeClass('header');
          $('#header').addClass('customNav');
        } else if (scrollTop < 100) {
          $('#header').removeClass('customNav');
          $('#header').addClass('header');
    }
});
    
// If record is a tv series
var tvSeries = document.getElementById("tv");
var seasonInput = document.getElementById("season");

//foreach($result as $row) {
//    if (tvSeries == 1){
//        tvSeries.html("Yes");
//    } else {
//        tvSeries.html("No");
//        seasonInput.style("display: none;");
//    }
//};
    
// Get the checkbox
var tvCheckBox = document.getElementById("tv").addEventListener("click", function(tvSeries) { // Show season input if tv checkbox == true

  // If the checkbox is checked, display the output text
  if (tvCheckBox.checked == true){
    seasonInput.style.display = "block";
  } else {
    seasonInput.style.display = "none";
  }
});
    
});