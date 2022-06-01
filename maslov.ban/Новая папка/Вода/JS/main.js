$(function() {
    $('#subcategory').find('optgroup').hide(); // initialize
    $('#category').change(function() {
    var $cat = $(this).find('option:selected');
    var $subCat = $('#subcategory').find('.' + $cat.attr('class'));
    $('#subcategory').find('optgroup').not("'"+ '.' + $cat.attr('class') + "'").hide(); // hide other optgroup
    $subCat.show();
    $subCat.find('option').first().attr('selected', 'selected');
    });
});



$('input[type="file"][preview-target-id]').on('change', function() {
    var input = $(this)
    if (!window.FileReader) return false // check for browser support
    if (input[0].files && input[0].files[0]) {
        var reader = new FileReader()
        reader.onload = function (e) {
            var target = $('#' + input.attr('preview-target-id'))
            var background_image = 'url(' + e.target.result + ')'
            target.css('background-image', background_image)
            target.parent().show()
        }
        reader.readAsDataURL(input[0].files[0]);
    }
})

function SupressInput($event)
{
  $event.preventDefault();
}


// $(".forma_cena_ot").keypress(function(event){
//   event = event || window.event;
//   if (event.charCode && event.charCode!=0 && event.charCode!=46 && (event.charCode < 48 || event.charCode > 57) )
//     return false;
// });

// $(".forma_cena_do").keypress(function(event){
//   event = event || window.event;
//   if (event.charCode && event.charCode!=0 && event.charCode!=46 && (event.charCode < 48 || event.charCode > 57) )
//     return false;
// });



$('input.forma_cena_ot').keydown(function(){
    var max = $(this).data('max');
    if( this.value.length==max ) this.value = this.value.slice(0,-1)
});

$('input.forma_cena_do').keydown(function(){
    var max = $(this).data('max');
    if( this.value.length==max ) this.value = this.value.slice(0,-1)
});

$('input.forma_probeg_ot').keydown(function(){
    var max = $(this).data('max');
    if( this.value.length==max ) this.value = this.value.slice(0,-1)
});

$('input.forma_probeg_do').keydown(function(){
    var max = $(this).data('max');
    if( this.value.length==max ) this.value = this.value.slice(0,-1)
});




$('input.forma_cena_ot').on('keydown', function(e){
  if(e.key.length == 1 && e.key.match(/[^0-9'".]/)){
    return false;
  };
})

$('input.forma_cena_do').on('keydown', function(e){
  if(e.key.length == 1 && e.key.match(/[^0-9'".]/)){
    return false;
  };
})
