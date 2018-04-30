var loginWindow;
var panelContainer;
var arrayContainer;

$(document).ready( function() {

   panelContainer = $("#panelContainer");
   arrayContainer = $("#arrayContainer");

   // Show the clearance field if necessary
   $('#roof_type').change( function() {
      currentVal = getRealRoofType();
      
      // We need the actual value to see if we should show clearance.
      selectedRoofType = parseInt($('#roof_type option:selected').val());
      
      // Only show rafter dimension for asphalt roofs
      // and Spanish tile.
      if(currentVal == <?php echo ASPHALT; ?> || currentVal == <?php echo ASPHALT_W_CLEARANCE; ?>  || currentVal == <?php echo SPANISH_TILE; ?>)
      {
         $('#raftersDiv').show();
         $('#raftersDiv').removeClass('hidden');
         $('#rafter_size').attr('required', 'required');
      }
      else if(currentVal == <?php echo TRAPEZOIDAL; ?>)
      {
         $('#raftersDiv').hide();
         $('#raftersDiv').addClass('hidden');
         $('#rafter_size').removeAttr('required', 'required');       
      }
         
      
      if(selectedRoofType == <?php echo ASPHALT_W_CLEARANCE; ?>)
      {
         $('#clearanceDiv').removeClass('hidden');
         $('#clearance').attr('required', 'required');
      }
      else
      {
         $('#clearanceDiv').addClass('hidden');
         $('#clearance').removeAttr('required');
         $('#clearance option:first').attr('selected','selected');
      }
      
      getRoofSubtypes();
      
      getConnectorTypes();
   });
   
   $('#roof_subtype').change( function() {getConnectorTypes();});
   $('#clearance').change( function() {getConnectorTypes();});
   $('#rafter_size').change( function() {getConnectorTypes();});

   $('#connectorTypeLink').click( function(e)
   {
      e.preventDefault(); 
      selectedConnector = $('#connector_type option:selected').val();
      if(selectedConnector != '')
      {
         window.open('/mm5/merchant.mvc?Screen=PROD&Store_Code=S&Product_Code='+selectedConnector);
      }
   });
   
   // Image Select Fields
   $(".imgSelect").click( function() {
      $(this).find('img').removeAttr('style');
      $(".imgSelect img").removeClass('selectedImg');
      $(this).find('img').addClass('selectedImg');
   });
   
   // Make sure they're required.
   if($('#envForm').length > 0)
   {
      $('#envForm').submit( function() {
         if($(".imgSelect img.selectedImg").length < 1)
         {
            imgFieldAlert(".imgSelect img");
            return false;
         }
         else
            return true;
      });
   }
   
   // Seismic calculations
   if ($('#seismic_calculations').is(':not(:checked)')) {
       $('#sds').parents('.control-group').hide(); 
   }
   
   if ($('#default_sds').is(':checked')) {
       $('#sds').val(constants.default_sds);
       $('#sds').attr('disabled', 'disabled');
   }
   
   if ($('#sds').val() == constants.default_sds) {
       $('#sds').attr("checked", "checked");
   }
   
   $('#seismic_calculations').change(function() {
       if ($(this).is(':checked')) {
           $('#sds').parents('.control-group').show();
       } else {
           $('#sds').parents('.control-group').hide();
       }
   });
   
   $('#default_sds').change(function() {
       if ($(this).is(':checked')) {
           $('#sds').val(constants.default_sds);
           $('#sds').attr('disabled', 'disabled');
       } else {
           $('#sds').removeAttr('disabled');
       }
   });
   
   $("#module_length").change(calculateMaxRowsAndColumns);   
   $("#module_width").change(calculateMaxRowsAndColumns);   
   $("#orientation").change(calculateMaxRowsAndColumns);   
   
   calculateMaxRowsAndColumns();
   
   // Enable/disable the Schletter module list
   $('#useSchletter').click( function() {
      if($(this).is(':checked'))
      {
         $('#customModuleFields').addClass('hidden');
         $('#schletterModuleFields select,#schletterModuleFields input').attr('required','required');
         $('#customModuleFields select,#customModuleFields input').removeAttr('required');
         $('#schletterModuleFields').removeClass('hidden');
      }
      else
      {
         $('#schletterModuleFields').addClass('hidden');
         //$('#customModuleFields input').val('');
         $('#customModuleFields select,#customModuleFields input').attr('required','required');
         $('#schletterModuleFields select,#schletterModuleFields input').removeAttr('required');
         $('#customModuleFields').removeClass('hidden');
      }
   });
   
   // Update the form based on the selected vendor
   $('#vendor').change( function() {
      getModuleTypes($(this).find('option:selected').val());
   });

   $('#module_type').change( function() {
      modType = $(this).find('option:selected');
      if(modType.val() != '')
      {
         $('#module_thickness').val(modType.attr('data-thickness'));
         $('#module_length').val(modType.attr('data-height'));
         $('#module_width').val(modType.attr('data-width'));
         $('#module_weight').val(modType.attr('data-weight'));
      }
   });
   
   $('#orientation').change( function()
   {
      if(typeof testing !== 'undefined')
         return 0;
         
      roofType = getRealRoofType();
      if($(this).val() == '2' &&  ( roofType == <?php echo ASPHALT; ?> || roofType == <?php echo ASPHALT_W_CLEARANCE; ?>))
      {
         alert('Selecting landscape with a tile or shingle roof may increase material costs.');
      }
   });
   
   $('#modForm').submit( function(e)
   {
      if(!$('#useSchletter').is(':checked'))
      {
         $('#customModuleFields input').each( function() {
            if($(this).val() == "")
               return false;
         });
      }
      else
         $('#customModuleFields input').removeAttr('required');
   });
   
   if(panelContainer.length > 0)
   {
      // Make the module layout draggable.
      limits = panelContainer.offset();
      arrayContainer.draggable({
         //containment: "#panelContainer",
         containment: [
            limits.left,
            limits.top,
            limits.left+(panelContainer.width() - arrayContainer.width() + 2),
            limits.top+(panelContainer.height() - arrayContainer.height())
         ],
         scroll: false,
         distance: 10,
         snap: ".zone",
         snapMode: "outer",
         drag: function() {
            position = $(this).position();
            updateArrows(position.left, position.top);
            updateXOffset(position.left);
            updateYOffset(position.top);
         },
         stop: function() {
            position = $(this).position();
            updateArrows(position.left, position.top);
            updateXOffset(position.left);
            updateYOffset(position.top);
            checkZones();
         }

      });

      $('.panel').dblclick( function() {
         $(this).toggleClass('transparent');
         updateLayout( $(this) );
      });

      // If the input fields change, adjust the layout
      // accordingly.
      $("#xOffset").change( function() {shiftArrayHoriz($(this).val());});
      $("#yOffset").change( function() {shiftArrayVert($(this).val());});
      $("#xOffset").keypress(function(e){if ( e.which == 13 ){shiftArrayHoriz($(this).val());e.preventDefault();}});
      $("#yOffset").keypress(function(e){if ( e.which == 13 ){shiftArrayVert($(this).val());e.preventDefault();}});

      $("#x2Offset").change( function() {shiftArrayRight($(this).val());});
      $("#y2Offset").change( function() {shiftArrayBottom($(this).val());});
      $("#x2Offset").keypress(function(e){if ( e.which == 13 ){shiftArrayRight($(this).val());e.preventDefault();}});
      $("#y2Offset").keypress(function(e){if ( e.which == 13 ){shiftArrayBottom($(this).val());e.preventDefault();}});


      $("#toggleZones").click( function() {
         $(".zone").toggleClass('visible');
         $(".zoneLabel").toggleClass("highlight");
      });
   }
   
   // Add tabs on the last page.
   $("#resultsData").tabs();
   
   // Delete existing project functionality
   $("#deleteProjectsToggle").click( function(e) {
      e.preventDefault(); 
      $("#deleteProjectsContainer").toggleClass('hidden');
      if($("#deleteProjectsContainer").hasClass('hidden'))
      {
         $(this).text("Click here to delete a project...");
      }
      else
      {
         $(this).text("Click to hide deletion options...");
      }
   });
   
   $('#deleteProjectsForm').submit( function(e)
   {
      e.preventDefault(); 
      selectedProject = $('#deleteProject option:selected').val();
      if(selectedProject != '')
      {
         projTitle = $('#deleteProject option:selected').text();
         if(confirm("Are you sure you want to delete the project named '"+projTitle+"'?"))
         {
            deleteProject(selectedProject);
            $("#deleteProjectsContainer").toggleClass('hidden');
         }
      }
   });
   
   $('a.popLogin').click( function() { openLoginWindow(); });

   // Convert titles to tooltips
   $(".icon-question-sign").tooltip(
   {
      content: function() { return $(this).attr('title'); }  // Allows the inclusion of HTML entities for formatting.
   });

   // Setup sales contact form (provided for complex projects)
   $("#salesContactForm").dialog({
      autoOpen: false,
      show: {
         effect: "clip",
         duration: 250
      },
      hide: {
         effect: "clip",
         duration: 250
      },
      modal: true,
      buttons: [{
            text: "Send",
            click: function() {
               
               formName  = $("#uname").val();
               formEmail = $("#email").val();
               formMsg   = $("#msg").val();

               if(formName == "" || formEmail == "" || formMsg == "")
               {
                  errMsg = "Please fill out all required fields.";
                  $("#dynErrorMsg").remove();
                  $("#salesContactForm").prepend("<div id='dynErrorMsg' class='alert alert-error'></div>")
                  $("#dynErrorMsg").text(errMsg);
                  $('#salesContactForm label.required').css('color','#a00');
                  $('#salesContactForm label.required').css('fontWeight','bold');
               }
               else
                  $("#contactSalesForm").submit();
            }
      }],
      title: "Contact a Schletter Sales Associate"
   });
   
   $("#salesContactLink").click( function()
   {
      modalWindow = $("#salesContactForm");
      if(modalWindow.dialog("isOpen"))
         modalWindow.dialog( "close" );
      else
         modalWindow.dialog( "open" );
      event.preventDefault();
   })
   
   // Show the current position of the mouse on the
   // layout tab.
   layoutContainer = $("#layoutContainer");
   layoutContainer.tooltip(
   {
      content: function() { return "<div id='layoutMousePosition'></div>"},
      hide: false,
      track:true
   });
   if(layoutContainer.length > 0)
   {
      layoutContainer.tooltip(
      {
         content: function() { return "<div id='layoutMousePosition'></div>"},
         hide: false,
         track:true
      });

      panelPlacement = layoutContainer.position();
      console.info(panelPlacement);
      panelPlacementX = panelPlacement.left;
      panelPlacementX += parseInt($("#panelContainer").css("marginLeft"));

      panelPlacementY = panelPlacement.top;

      // To account for 1px borders
      panelPlacementX += 2;
      panelPlacementY += 2;

      $("#layoutContainer").mousemove( function(e)
      {
         xPos = (e.clientX - panelPlacementX);
         yPos = (e.clientY - panelPlacementY);
         pos  = convertMousePosition(xPos, yPos);
      
         if(pos.x >= 0 && pos.y >= 0)
         {
         $("#layoutMousePosition").html( pos.x + " &times; " + pos.y + " "+pos.units+"." );
         }
         else
         {
         $("#layoutMousePosition").html("");
            layoutContainer.tooltip("close");
         }
      });
   }
   
   // UK Version only
   // Project province/city/zip
   <?php if(COUNTRY_UK == COUNTRY) { ?>
   $('#project_state').change( function() { getUKCities();});
   $('#project_city').change( function() { getUKZips();});
   if($('#project_zip option').length == 2)
      $('#projectZipGroup').addClass('hidden');      

   // Ajax call for UK cities
   function getUKCities()
   {
      province = $('#project_state option:selected').val();
      data = "a=ukc&pr="+province;

      $.post('js/ajax.php', data, function(response) {      
         var cities = jQuery.parseJSON( response );

         // Remove old options
         $('#project_city option').remove();
         $('#project_zip option').remove();
         $('#projectZipGroup').addClass('hidden');

         // Add empty option
         if(cities.length > 1)
         {
            $('#projectCityGroup').removeClass('hidden');
            $('#project_city').append("<option value=''></option>");
            $('#project_city').attr('required', 'required');
         }
         else
         {
            $('#projectCityGroup').addClass('hidden');
            $('#project_city').removeAttr('required');
         }

         // Add module types
         for(a=0; a < cities.length; a++)
         {
            $('#project_city').append("<option value='"+cities[a].id+"'>"+cities[a].name+"</option>");
         }
      });
   }


   // Ajax call for UK postal codes
   function getUKZips()
   {
      province = $('#project_state option:selected').val();
      city = $('#project_city option:selected').val();
      data = "a=ukz&pr="+province+"&c="+city;

      $.post('js/ajax.php', data, function(response) {      
         var zips = jQuery.parseJSON( response );

         // Remove old options
         $('#project_zip option').remove();

         // Add empty option
         if(zips.length > 1)
         {
            $('#projectZipGroup').removeClass('hidden');
            $('#project_zip').append("<option value=''></option>");
            $('#project_zip').attr('required', 'required');
         }
         else
         {
            $('#projectZipGroup').addClass('hidden');
            $('#project_zip').removeAttr('required');
         }

         // Add module types
         for(a=0; a < zips.length; a++)
         {
            $('#project_zip').append("<option value='"+zips[a].id+"'>"+zips[a].name+"</option>");
         }
      });
   }

   <?php } ?>
});

function calculateMaxRowsAndColumns()
{
   data = {
       "a": "mx",
       "l": $("#module_length").val(), 
       "w": $("#module_width").val(), 
       "o": $("#orientation").val()
   };
       
   $.getJSON('js/ajax.php', data, function(responseData)
   {
      if(responseData.Error == undefined)
      {
         if(responseData.rows != 0)
            $("#max-rows").html('<em>maximum rows: ' + responseData.rows + '</em>');
         else
            $("#max-rows").html('');
         if(responseData.cols != 0)
            $("#max-cols").html('<em>maximum columns: ' + responseData.cols + '</em>');
         else
            $("#max-cols").html('');
      }
   });
}

// Alert to show users that terrain is a required field
function imgFieldAlert(selector)
{
   $(selector).animate( {backgroundColor: "#f00"}, 1000 ).animate( {backgroundColor: "none"}, 1000 );
}

function requiredFieldAlert(selector)
{
   $(selector).animate( {border: "1px solid #f00"}, 1000 ).animate( {border: "0"}, 1000 );  
}

// Ajax call for module types
function getModuleTypes(vendorName)
{
   vendor = $('#vendor option:selected').val();
   data = "a=mt&v="+vendor;
   //data = [{a:'mt', v:vendor}];
   $.post('js/ajax.php', data, function(response) {
      
      var moduleTypes = jQuery.parseJSON( response );
      console.info(moduleTypes);
      // Remove old options
      $('#module_type option').remove();
      
      // Add empty option
      $('#module_type').append("<option value=''></option>");
      
      // Add module types
      for(a=0; a < moduleTypes.length; a++)
      {
         $('#module_type').append("<option value='"+moduleTypes[a].id+"' data-thickness='"+moduleTypes[a].thickness+"' data-height='"+moduleTypes[a].height+"' data-width='"+moduleTypes[a].width+"' data-weight='"+moduleTypes[a].weight+"'>"+moduleTypes[a].name+"</option>");
      }
   
      if(testing != undefined)
         selectRandomOption( $('#module_type') );
   
   });
}


// Ajax call for module types
function getConnectorTypes()
{
   roofType   = getRealRoofType();
   subType    = $('#roof_subtype option:selected').val();
   clearance  = $('#clearance option:selected').val();
   rafterDims = $('#rafter_size option:selected').val();
   
   // Adding fix for trapezoidal spacing connectors
   if(roofType == <?php echo TRAPEZOIDAL; ?> && subType == undefined)
      subType = 9; // Connecting to trusses

   data = "a=ct&t="+roofType+"&st="+subType+"&c="+clearance+"&rd="+rafterDims;

   $.post('js/ajax.php', data, function(response) {      
      var connectionTypes = jQuery.parseJSON( response );

      oldVal = $('#connector_type option:selected').val();
      // Remove old options
      $('#connector_type option').remove();
      
      // Add empty option
      if(connectionTypes.length > 1)
      {
         $('#connectorTypeGroup').show();
         $('#connector_type').append("<option value=''></option>");
         $('#connector_type').attr('required', 'required');
      }
      else
      {
         $('#connectorTypeGroup').hide();
         $('#connector_type').removeAttr('required');
      }
      
      // Add module types
      for(a=0; a < connectionTypes.length; a++)
      {
         if(oldVal == connectionTypes[a].item_number)
            $('#connector_type').append("<option selected='selected' value='"+connectionTypes[a].item_number+"'>"+connectionTypes[a].name+"</option>");
         else
            $('#connector_type').append("<option value='"+connectionTypes[a].item_number+"'>"+connectionTypes[a].name+"</option>");
      }
      
      realRoofType = parseInt($('#roof_type option:selected').val());
      if(realRoofType == <?php echo ASPHALT_W_CLEARANCE; ?> && clearance == 0)
      {
         $('#connectorTypeGroup').hide();
         $('#connector_type').removeAttr('required');
      }
   });
}

// Ajax call for module types
function getRoofSubtypes()
{
   roofType   = getRealRoofType();
   data = "a=rt&t="+roofType;

   $.post('js/ajax.php', data, function(response) {      
      var subroofTypes = jQuery.parseJSON( response );
      oldVal = $('#roof_subtype option:selected').val();
      // Remove old options
      $('#roof_subtype option').remove();
      
      // Add empty option
      if(subroofTypes.length > 1)
      {
         $('#roofSubtypeDiv').show();
         $('#roof_subtype').append("<option value=''></option>");
         $('#roof_subtype').attr('required', 'required');
      }
      else
      {
         $('#roofSubtypeDiv').hide();
         $('#roof_subtype').removeAttr('required');
      }
      
      // Add module types
      for(a=0; a < subroofTypes.length; a++)
      {
         if(oldVal == subroofTypes[a].id)
            $('#roof_subtype').append("<option selected='selected' value='"+subroofTypes[a].id+"'>"+subroofTypes[a].subtype+"</option>");
         else
            $('#roof_subtype').append("<option value='"+subroofTypes[a].id+"'>"+subroofTypes[a].subtype+"</option>");
      }

   });
}

// Ajax call for deleting existing projects
function deleteProject(id)
{
   data = "a=dp&p="+id;
   $.post('js/ajax.php', data, function(response) {

      // Remove the project from the list
      // of existing projects.
      
      $("#existing_project option[value='"+id+"']").remove();
      $("#deleteProject option[value='"+id+"']").remove();
   
   });
}

function openLoginWindow()
{
   var margin  = 100;
   var wWidth  = parseInt(screen.availWidth - (margin*2));
   var wHeight = parseInt(screen.availHeight - (margin*2));
   loginWindow = window.open('login.php','','width='+wWidth+',height='+wHeight+',top='+margin+',left='+margin+',scrollbars=no,toolbar=no,status=no');
}

function closeLoginWindow()
{
   loginWindow.close();
   document.location.reload(true);
}

function getRealRoofType()
{
   var rt = parseInt($('#roof_type option:selected').val());
   if(rt == <?php echo ASPHALT_W_CLEARANCE; ?>)
      rt = <?php echo ASPHALT; ?>;
   
   return rt;
}

/*************** get city and state *************/

jQuery(function($) {
   //$("input[name='project_city']").prop('disabled', true);
   //$("input[name='project_state']").prop('disabled', true);
   if($("input[name='project_zip']").val())
   {
//      $("input[name='project_city']").val(stateinfo.city).css('display' , 'block');
//      $("input[name='project_state']").val(stateinfo.state).css('display' , 'block');
      $("input[name='project_city']").css('display' , 'block');
      $("input[name='project_state']").css('display' , 'block');
   }
   else
   {
      $("#project-state").css('display' , 'none');
      $("#project-city").css('display', 'none');
   }
	
   $("input[name='project_zip']").on('keyup',function()
   {
      var zip = $(this);
      console.log(zip.val());
      var zipAPI = "http://ziptasticapi.com/"+zip.val()+"";
      if(zip.val().length === 5  && $.isNumeric(zip.val()))
      {
         $.ajax({
            url: zipAPI,
            cache: false,
            success: function(data,success){
               //console.log(data)
               var stateinfo = jQuery.parseJSON(data);
               console.log("the data" + data);
               console.log ("The state and city is " + stateinfo.state + " " + stateinfo.city);
               $('#project-state').show('fast');
               $('#project-city').show('fast');
               $("input[name='project_city']").val(stateinfo.city).css('display' , 'block');
               $("input[name='project_state']").val(stateinfo.state).css('display' , 'block');
            }
         });
      } 
   });
   
});