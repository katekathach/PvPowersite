var testing = true;
var lorem = new Array("andouille", "bacon", "ball", "beef", "belly", "biltong", "boudin", "bresaola", "brisket", "chicken", "chop", "corned", "frankfurter", "ham", "Hamburger", "hock", "kielbasa", "leberkas", "meatloaf", "pancetta", "Pancetta", "pastrami", "pig", "pork", "prosciutto", "ribs", "salami", "sausage", "shank", "short", "sirloin", "spare", "steak", "strip", "tail", "t-bone", "tenderloin", "tip", "tri-tip", "turkey", "venison");

$(document).ready( function() {
   $('#fillForm').click( function() {
      if($(this).is(':checked'))
      {
         $('input').not('.noTouching').each( function() {
            if($(this).hasClass('integer'))
            {
               min = $(this).attr('min');
               max = $(this).attr('max');
               $(this).val( rand(min, max) );
            }
            else if($(this).hasClass('decimal'))
            {
               min = $(this).attr('min');
               max = $(this).attr('max');
               $(this).val( randDec(min, max) );
            }
            else
            {
               index = rand(0, lorem.length-1);
               $(this).val(lorem[index]);
            }
         });
         
         $('select').not('.noTouching').each( function() {
            selectRandomOption($(this));
         })

      }
      else
      {
         $('input').not('#submit').val('');
         $('select').find('option:selected').removeAttr('selected');
      }
   });
var icons = {
      header: "ui-icon-circle-arrow-e",
      activeHeader: "ui-icon-circle-arrow-s"
    };
    
//    $( "#resultsData" ).accordion({
//      icons: icons,
//      collapsible: true
//    });

//   $("#resultsData").accordion({
//      collapsible: true
//    });
   
});

function rand(min, max)
{
   min = parseInt(min);
   max = parseInt(max);

   val = Math.floor( Math.random() * (max - min + 1) ) + min;
   return val;
}

function randDec(min, max)
{
   min = parseFloat(min);
   max = parseFloat(max);

   val = ( Math.random() * (max - min + 1) ) + min;
   return roundOff(val, 2);
}

function roundOff(dec, places)
{
   for(a=0; a<places; a++)
      dec *= 10;
   dec = Math.round(dec);
   for(a=0; a<places; a++)
      dec /= 10;
   
   // Because JavaScript is horrible at math...
   dec = dec.toString();
   dec = dec.substr(0, (dec.lastIndexOf('.')+places+1));
   dec = parseFloat(dec);
   
   return dec;
}

function selectRandomOption(selectField)
{
   options = selectField.find('option');
   index = rand(2, options.length);
   selectedVal = selectField.find('option:nth-child('+index+')').val();
   selectField.val(selectedVal);
   selectField.trigger('change');
}