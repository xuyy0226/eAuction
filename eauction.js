$(document).ready(function() {
    $('#subcategory2').hide();
    $('#subcategory3').hide();
     $('#category').change(function () {
        if ($('#category option:selected').text() == "Gaming_gears"){
            $('#subcategory1').show();
            $('#subcategory2').hide();
            $('#subcategory3').hide();
        }
         else if($('#category option:selected').text() == "Toys"){ 
              $('#subcategory2').show();
              $('#subcategory1').hide();
              $('#subcategory3').hide();
         }
         else if($('#category option:selected').text() == "Apparel"){ 
              $('#subcategory3').show();
              $('#subcategory1').hide();
              $('#subcategory2').hide();
         }
    });
});

