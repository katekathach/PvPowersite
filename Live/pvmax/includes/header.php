<!DOCTYPE html>
<html lang="en">
<head>
<title>PvMax Configurator </title>
<meta charset="iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="css/bootstrap.min.css" />-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//fortawesome.github.io/Font-Awesome/3.2.1/assets/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="css/jquery-ui.css" />     
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/__main__.css" />
<script type="text/javascript" src="//fast.fonts.com/jsapi/af8a1a24-871f-4397-94c7-46abd773ff48.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<link rel="stylesheet"  href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<style>
    
.dataTables_wrapper{
display: none;
}   

.projects{
float:right;    
}

.dataTables_length , .dataTables_filter{
display:none;
}
</style>
 <script type="text/javascript">
 if (typeof jQuery == 'undefined')
 {
         //Load local jQuery if google isn't available
         document.write(unescape("%3Cscript src='js/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
       }
       </script>
     
       <script type="text/javascript">
       if (typeof jQuery.ui == 'undefined')
       {
         //Load local jQuery UI if google isn't available
         document.write(unescape("%3Cscript src='js/jquery-ui.min.js' type='text/javascript'%3E%3C/script%3E"));
       }
       </script>
      
       <!--<script type="text/javascript">
       $(document).ready(function(){
        var cell = $('select[name=cell]').val();
          var codeversion = $('select[name=codeversion]').val();

          if(codeversion == 'ASCE7-10' ) {
            var option = '<option value="110">110 mph</option><option value="115">115 mph</option><option value="140">140 mph</option><option value="160">160 mph</option><option value="180">180 mph</option>';
          }
          else if(codeversion == 'ASCE7-05') {
            var option = '<option value="85">85 mph</option><option value="90">90 mph</option><option value="110">110 mph</option><option value="130">130 mph</option><option value="150">150 mph</option>';  
          }

          $('#wind-value').html(option);
        $('select[name=codeversion]').change(function(){

          var cell = $('select[name=cell]').val();
          var codeversion = $('select[name=codeversion]').val();

          if(codeversion == 'ASCE7-10' ) {
            var option = '<option value="110">110 mph</option><option value="115">115 mph</option><option value="140">140 mph</option><option value="160">160 mph</option><option value="180">180 mph</option>';
          }
          else if(codeversion == 'ASCE7-05') {
            var option = '<option value="85">85 mph</option><option value="90">90 mph</option><option value="110">110 mph</option><option value="130">130 mph</option><option value="150">150 mph</option>';	
          }

          $('#wind-value').html(option);
        })


      })

       $(document).ready(function(){
               var cell = $('select[name=cell]').val();


          if(cell == '72'){
            var option = '<option value="20">20&deg;</option><option value="25">25&deg;</option><option value="30">30&deg;</option>';
          }
          else if(cell == '60'){
            var option = '<option value="15">15&deg;</option><option value="20">20&deg;</option><option value="25">25&deg;</option> <option value="30">30&deg;</option><option value="35">35&deg;</option>';  
          }

          $('#tilt').html(option);
        $('select[name=cell]').change(function(){

          var cell = $('select[name=cell]').val();


          if(cell == '72'){
            var option = '<option value="20">20&deg;</option><option value="25">25&deg;</option><option value="30">30&deg;</option>';
          }
          else if(cell == '60'){
            var option = '<option value="15">15&deg;</option><option value="20">20&deg;</option><option value="25">25&deg;</option> <option value="30">30&deg;</option><option value="35">35&deg;</option>';  
          }

          $('#tilt').html(option);
        })})
       $(document).ready(function(){
               var wind = $('select[name=wind]').val();


          if(wind == '180' || wind =='150'){
            var option = '<option value="0">0 psf</option><option value="5">5 psf</option>';
          }
          else {
            var option = '<option value="0">0 psf</option><option value="5">5 psf</option><option value="10">10 psf</option><option value="15">15 psf</option><option value="20">20 psf</option><option value="25">25 psf</option><option value="30">30 psf</option><option value="35">35 psf</option><option value="40">40 psf</option><option value="45">45 psf</option><option value="50">50 psf</option><option value="55">55 psf</option><option value="60">60 psf</option>'
          }

          $('#snow').html(option);
        $('select[name=wind]').change(function(){

          var wind = $('select[name=wind]').val();


          if(wind == '180' || wind =='150'){
            var option = '<option value="0">0 psf</option><option value="5">5 psf</option>';
          }
          else {
            var option = '<option value="0">0 psf</option><option value="5">5 psf</option><option value="10">10 psf</option><option value="15">15 psf</option><option value="20">20 psf</option><option value="25">25 psf</option><option value="30">30 psf</option><option value="35">35 psf</option><option value="40">40 psf</option><option value="45">45 psf</option><option value="50">50 psf</option><option value="55">55 psf</option><option value="60">60 psf</option>'
          }

          $('#snow').html(option);
        })

      })
       </script>
       <script>
       $(function() {
        $( "#tabs" ).tabs();
      });


       </script>
      <!--[if lt IE 9]>
         <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
         <script type="text/javascript">
            alert('Your browser appears a bit outdated (or in compatibility mode). To take full advantage of all the features available on PV Powerhouse, we recommend upgrading to a modern, full-featured browser.');
         </script>
         <![endif]-->
      <!--[if IE]>
         <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
         <![endif]-->
         <style>
         .glyphicon {
 				 color: #FFF;
			}
         </style>
         
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-30109642-1', 'auto');
  ga('send', 'pageview');

</script>
 <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

<!-- Button trigger modal - Feedback tab at right -->
<div id="quote" class="col-lg-2 hidden-md no-padding">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h3 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          We welcome your feedback...
        </a>
      </h3>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <p>Having problems? Please send us a detailed description of the issue you are experiencing along with the browser you are using (Internet Explorer, Firefox, Chrome, Safari, etc.) and a screenshot of the issue in action, if possible.</p>
        <a href="mailto:marketing@schletter.us?subject=PV Powersite Feedback" class="action-button col-sm-8 pull-right">Send Feedback</a>
      </div>
    </div>
  </div>
</div>
</div>
<!-- end feedback button -->

<nav class="navbar no-margin" role="navigation">
	<div class="container extra-padding">
        <div class="navbar-header">
            <a class="navbar-brand" href="../standard/form.php"><img class="img-responsive no-margin logo-size" src="img/powersite-logo-white.png" alt="PV Powersite"></a>
        </div>
              <div>
            <p class="navbar-text navbar-right"><a href="http://secure.schletter.us/"  target='blank' "navbar-link">Schletter Store &raquo;</a></p>
            <p class="navbar-text navbar-right"><a href="files/Powersite-User-Guide.pdf" target='blank'class="navbar-link">User Guide</a></p>
            <p class="navbar-text navbar-right"><a href="files/Powersite-Guia-de-Usuario.pdf" target='blank' class="navbar-link">User Guide ES</a></p>
              <?php       
//var_dump($warnings);
if(isset($errors) && !empty($errors))
{
   echo "<div class='alert alert-error'>\n";
   echo implode("<br />",$errors);
   echo "</div>\n";
}
else if(isset($warnings) && !empty($warnings))
{
   echo "<p class='navbar-text navbar-right '>\n";
   echo implode("<br />",$warnings);
   echo "</p>\n";   
}
else if(isset($successes) && !empty($successes))
{
   echo "<div class='alert alert-success'>\n";
   echo implode("<br />",$successes);
   echo "</div>\n";   
}
?>   
        </div>
    </div>   
</nav>




