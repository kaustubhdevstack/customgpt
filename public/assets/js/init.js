//Table with pagination
$(document).ready( function () {
    $('#jsdata').DataTable({
        responsive: true,
    });
} );

  /* BOOTSTRAP SLIDER */
  $(document).ready( function () {
  $('.slider').bootstrapSlider();
} );

// Generate a password string
function randString(id){
    var length = 15,
        charset = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

// Create a new password on page load
$('input[rel="gp"]').each(function(){
  $(this).val(randString($(this)));
});

// Create a new password
$(".getNewPass").click(function(){
  var field = $(this).closest('div').find('input[rel="gp"]');
  field.val(randString(field));
});

// Auto Select Pass On Focus
$('input[rel="gp"]').on("click", function () {
   $(this).select();
});