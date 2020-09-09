$(document).ready(function(){    
    
    // show/hide season field if DVD is tv series    
    var tvCheckbox = document.getElementById("tv");

    tvCheckbox.addEventListener('change', function(){
        if(this.checked){
            // Checkbox is checked
            $("#season").show();
            $("li>label[for='season']").show();
        }else{
            // Checkbox is not checked
            $("#season").hide();
            $("li>label[for='season']").hide();
        }
    });
    
    // if checkbox is already set to checked, show season field
    if(tvCheckbox.checked == true){
            // Checkbox is checked
            $("#season").show();
            $("li>label[for='season']").show();
    };
    
});