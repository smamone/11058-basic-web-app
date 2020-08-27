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
    
// If record is a tv series
var tvSeries = document.getElementById("tv");
var seasonInput = document.getElementById("season");

foreach($result as $row) {
    if (tvSeries == 1){
        tvSeries.html("Yes");
    } else {
        tvSeries.html("No");
        seasonInput.style("display: none;");
    }
};
    
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