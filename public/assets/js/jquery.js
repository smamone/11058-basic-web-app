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

// Get the season input
var seasonInput = document.getElementById("season");
    
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