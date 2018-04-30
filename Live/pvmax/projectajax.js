/**
 * @author kateka.thach
 */
$(document).ready(function(){
  
  var userid = $("input[name='userid']").val();
 // console.log(userid);
    // On page load: datatable
  var table_companies = $('#table_projects').dataTable({
    "ajax": "saveproject.php?job=get_projects&userid=" + userid,
    // "bJQueryUI": true,
    //"sDom": 'lfrtip',
     
   
     "info" : false,
    //"scrollY" : '50vh',
    "scrollCollapse": false,
    "columns": [
    	
      //{ "data": "project_name" },
      /*{ "data": "project_address" },
      { "data": "project_city" },
      { "data": "project_state"},
      { "data": "project_zip"},*/
      { "data": "function",    "sClass": "functions" }
    
    ],
    "aoColumnDefs": [
     { "bSortable": false, "aTargets": [-1] }
    ],
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "oLanguage": {
     "sEmptyTable": "No Saved Projects",
      "oPaginate": {
        "sFirst":       " ",
        "sPrevious":    " ",
        "sNext":        " ",
        "sLast":        " ",
        
      },
      "sLengthMenu":    "Records per page: _MENU_",
      "sInfo":          "Total of _TOTAL_ records (showing _START_ to _END_)",
      "sInfoFiltered":  "(filtered from _MAX_ total records)"
    }
    //console.log(table_companies);
  });
  
    // Show message
  function show_message(message_text, message_type){
    $('#message').html('<p>' + message_text + '</p>').attr('class', message_type);
    $('#message_container').show();
    if (typeof timeout_message !== 'undefined'){
      window.clearTimeout(timeout_message);
    }
    timeout_message = setTimeout(function(){
      hide_message();
    }, 5000);
  }
  // Hide message
  function hide_message(){
    $('#message').html('').attr('class', '');
    $('#message_container').hide();
  }

  // Show loading message
  function show_loading_message(){
    $('#loading_container').show();
  }
  // Hide loading message
  function hide_loading_message(){
    $('#loading_container').hide();
  }

  // Show lightbox
  function show_lightbox(){
    $('.lightbox_bg').show();
    $('.lightbox_container').show();
  }
  // Hide lightbox
  function hide_lightbox(){
    $('.lightbox_bg').hide();
    $('.lightbox_container').hide();
  }
  // Lightbox background
  $(document).on('click', '.lightbox_bg', function(){
    hide_lightbox();
  });
  // Lightbox close button
  $(document).on('click', '.lightbox_close', function(){
    hide_lightbox();
  });
  // Escape keyboard key
  $(document).keyup(function(e){
    if (e.keyCode == 27){
      hide_lightbox();
    }
  });
 
  
  // Add project submit form
  $(document).on('click', '#saveProjectBtn', function(e){
     e.preventDefault();     
     // Validate form
     var formdata = $("#projectform");
     var calcspan = $("#calcspan").val();
     var isUpdate = $("#update_id").val();
    
     if(formdata.valid() == true){
     	var form_data = $('#projectform').serialize();    
     	var request   = $.ajax({
        url:          'saveproject.php?job=check_project&calcspan='+calcspan+'&userid='+userid+'&isupdate='+isUpdate,
        cache:        false,
        data:         form_data,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'get'
     });
          
      addNewProjectRequest = request.then(function(data){ 
      	  console.log("request data " + data["data"].data);
      	   // table_companies.api().ajax.reload(function(){  
     		if(data["data"].data < 3){
     			var result = "success";
     			return result;
      	     		
      		}else if(data["data"].data  >= 3){
              show_message('Add request failed: '+ "Maximum 3 projects. Please delete a project.", 'error');
            }            
     		//hide_loading_message();
           // }, true);
      	 })
      
     addNewProjectRequest.done(function(data){
      	 console.log(data);
        	if(data == "success"){
		var addproject  =  $.ajax({
      			url:          'saveproject.php?job=add_project&calcspan='+calcspan+'&userid='+userid+'&isupdate='+isUpdate,
        		cache:        false,
        		data:         form_data,
        		dataType:     'json',
        		contentType:  'application/json; charset=utf-8',
        		type:         'get',
       });
        	table_companies.api().ajax.reload(function(){       
             //console.log("output" + output );
            	var project_name = $('input[name="projectname"]').val();
            	show_message("Project '" + project_name + "' added successfully.", 'success');
                hide_loading_message();
             }, true);
     	}
      })
     
     
      request.done(function(output){
     		
        if (output.message  == 'success' || output.data == 'success update'){
        	// Reload datable]
        	//console.log(output);           
            table_companies.api().ajax.reload(function(){       
             //console.log("output" + output );
            	var project_name = $('input[name="projectname"]').val();
            	//show_message("Project '" + project_name + "' added successfully.", 'success');
                hide_loading_message();
             }, true);
		} else {
           // hide_loading_message();
           show_message('Add request failed', 'error');
        }
     });
     
     request.fail(function(jqXHR, textStatus){
          //hide_loading_message();
          show_message('Add request failed: ' + textStatus, 'error');
     });

     addNewProjectRequest.fail(function(jqXHR, textStatus){
          //hide_loading_message();
          show_message('Add request failed: ' + textStatus, 'error');
     });

     }
     
  
   });  
   

  	
  	 /* if (formdata.valid() == true){        	    
   
     var form_data = $('#projectform').serialize();    
     var request   = $.ajax({
        url:          'saveproject.php?job=add_project&calcspan='+calcspan+'&userid='+userid+'&isupdate='+isUpdate,
        cache:        false,
        data:         form_data,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'get'
     });
         
     request.done(function(output){
     		//console.log(output);
        if (output.message  == 'success' || output.data == 'success update'){
        	// Reload datable]
        	console.log(output);   
         
            table_companies.api().ajax.reload(function(){       
                console.log("updated value" + isUpdate);
            	var project_name = $('input[name="projectname"]').val();
        	if(isUpdate != null){
        		show_message("Project '" + project_name + "' updated successfully.", 'success');
        		
        	}else if(isUpdate = null){
        		
        		show_message("Project '" + project_name + "' added successfully.", 'success');
        	}
            hide_loading_message();
            
          }, true);
		} else {
           // hide_loading_message();
           show_message('Add request failed', 'error');
        }
     });
     request.fail(function(jqXHR, textStatus){
          //hide_loading_message();
          show_message('Add request failed: ' + textStatus, 'error');
     });
       }*/

 //Edit company button
 $(document).on('click', '.function_edit ', function(e){
      e.preventDefault();
   	  // Get project information from database   	 
      show_loading_message();
      var project_name = $(this).data('name'); 
      var id      = $(this).data('id');
      $('#update').show();
      $(".update_id").val(id);
      var request = $.ajax({
      url:          'saveproject.php?job=get_project',
      cache:        false,
      data:         'userid=' + userid + "&project_name="+project_name+"&id="+id,
      dataType:     'json',
      contentType:  'application/json; charset=utf-8',
      type:         'get'
      });
    
      request.done(function(output){
      console.log(output.message + "" + output.data.project_cell_type );
      var codeversion,seis;
      if (output.message == 'success'){
      	$("#saveProjectBtn").hide();
      		//var editzip = $("#projzip").val();
   	   		localStorage.setItem('editzip', output.data.project_zip);
   	   		console.log("local storage " + localStorage.getItem("editzip"));
   	   	   	   		
  			$("input[name='projectname']").val(output.data.project_name);
  			$("input[name='projectaddress']").val(output.data.project_address)	
  			$("input[name='projzip']").val(output.data.project_zip)	
  			$("#cell").val(output.data.project_cell_type)	
  			$("input[name='modulewidth']").val(output.data.project_width)	
  			$("input[name='modulethickness']").val(output.data.project_thickness)
  			$("#tilt").val(output.data.project_tilt)
  			$("input[name='modulecount']").val(output.data.project_column)
  			
  			if(output.data.project_building_code == "ASCE7-10") {
  				codeversion = "ASCE7-10";
  			}else{
  				codeversion = "ASCE7-05";
  			}
  			
  			$("#codeversion").val(codeversion)
  			$("#seismic").val(output.data.project_seis)
  			$("#wind-value").html("<option value='" + output.data.project_wind_load + "'>"+output.data.project_wind_load+"</option>")
  			$("#snow").html("<option value='" + output.data.project_snow_load + "'>" + output.data.project_snow_load+"</option>")
  			$("input[name='number-racks']").val(output.data.project_num_racks)
      
      } else {
            hide_loading_message();
            show_message('Information request failed', 'error');
      }
    
    });
    request.fail(function(jqXHR, textStatus){
      hide_loading_message();
      show_message('Information request failed: ' + textStatus, 'error');
    });
      

});
  
  
// update project submit form
$(document).on('click', '#update', function(e){
     
     e.preventDefault();
     var zipval;
     //if(localStorage.getItem("editzip") === null) {
     zipval = $("#projzip").val();
   	 console.log("update - " + zipval);
     //}else{    
   	 //zipval = localStorage.getItem("editzip");  
   	 //localStorage.setItem("editzip", zipval);
   	 //console.log(zipval); 
   	 getZip(zipval);	   	 	
   	 //}   	     
     // Validate form
     var formdata = $("#projectform");
     //var calcspan = $("#calcspan").val();
     var isUpdate = $("#update_id").val();     
     
     if (formdata.valid() == true){    	
      	// Send company information to database
      	// hide_ipad_keyboard();
      	hide_lightbox();
      	show_loading_message();
        var project_name = $(this).data('name'); 
        var id      = $(this).data('id');
        // var id        = formdata.attr('data-id');
        var form_data = formdata.serialize();
        console.log(form_data)
        var request   = $.ajax({
        url:          'saveproject.php?job=update_project&userid='+userid+"&isupdate="+isUpdate,
        cache:        false,
        data:         form_data,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'get'        
      
     });
      
      request.done(function(output){      	
        if (output.message == 'success'){
        	$("#saveProjectBtn").show("fast");
        	$("#update").hide("fast");
          // Reload datable
          $("#update_id").val(""); 
          table_companies.api().ajax.reload(function(){
            hide_loading_message();
          var project_name = $('input[name="projectname"]').val();
            show_message("project '" + project_name + "' updated successfully.", 'success');
             $("#projectform").trigger("reset");
          }, true);
         
        } else {
          hide_loading_message();
          show_message('Edit request failed', 'error');
        }
      });
      
      request.fail(function(jqXHR, textStatus){
        hide_loading_message();
        show_message('Edit request failed: ' + textStatus, 'error');
        
      	});
    }
        
        
    function getZip(zip){
    	var states = ["AL", "AZ", "CA", "CO", "CT","DE" , "FL" , "GA" , "MD", "ME" , "MI" , "NC" , "MN" , "NE" , "NH" , "NJ" , "NM", "NY" ,"OH", "PA" , "SC" , "TX" , "UT" , "VT", "WA" , "WI" ];
	//console.log(projzip.val());
	//var zipAPI = "http://ziptasticapi.com/"+zip.val()+"";
	var zipGoogleAPI = "http://maps.googleapis.com/maps/api/geocode/json?address="+zip+"&region=us&sensor=false";
	
	if(zip.length === 5  && $.isNumeric(zip)){
	$.ajax({
  	url: zipGoogleAPI ,
  	cache: false,
  	success: function(data,success){
  	
  	var stateinfo = data;
 	var city = stateinfo.results[0].address_components[1].short_name;
 	var state;
  	//var state = stateinfo.results[0].address_components[3].short_name;
  	//var lat = stateinfo.results[0].geometry.location.lat;
  	//var lng = stateinfo.results[0].geometry.location.lng;
  	
  	//$( stateinfo.result[0]. ).each(function() {
    //console.log($( this ).address_component.types);
  
  	 for (var i = 0; i < stateinfo.results[0].address_components.length; i++) {
  	 	 if(stateinfo.results[0].address_components[i].types[0] == "administrative_area_level_1"){
  	 	 	 state = stateinfo.results[0].address_components[i].short_name;
  	 	 		console.log(state);
  	 	 	}
  	 	//console.log(stateinfo.results[0].address_components[i].types);
  	 }  
  	 
  	 $('input[name="City"]').val(city);
  	 $('input[name="State"]').val(state);
	} 

	});

	} 
    }
    
  });
  
  // Delete company
  $(document).on('click', '.function_delete', function(e){
    e.preventDefault();    
    var project_name = $(this).data('name');    
    console.log($(this).data());
    if (confirm("Are you sure you want to delete '" + project_name + "'?")){
      show_loading_message();
      var id      = $(this).data('id');
     // console.log(id)
      var request = $.ajax({
          url:          'saveproject.php?job=delete_project&userid='+userid+"&project_name="+project_name+"&id="+id,
          cache:        false,
          dataType:     'json',
          contentType:  'application/json; charset=utf-8',
          type:         'get'
      });
      request.done(function(output){
         if (output.message == 'success'){
            //Reload data table
            table_companies.api().ajax.reload(function(){
            hide_loading_message();
            show_message("project '" + project_name + "' deleted successfully.", 'success');
          }, true);
          
         }else{
            hide_loading_message();
            show_message('Delete request failed', 'error');
         }
      });
      request.fail(function(jqXHR, textStatus){
        hide_loading_message();
        show_message('Delete request failed: ' + textStatus, 'error');
      });
    }
  });



    
  });