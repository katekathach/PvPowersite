      <div id='footer' class="clear"> &copy; Schletter Store | <a href="http://www.secure.schletter.us">secure.schletter.us</a> | <a href="http://secure.schletter.us">Store</a> |
     <a href='files/PVPowerhouse-Terms-Of-Use.pdf' target='_blank'>Terms of Use</a> | <a href="../mm5/support/Schletter_ConditionsOfUse.pdf"> Conditions of Use</a> | <a href="../mm5/support/Schletter_Privacy_Policy.pdf">Privacy Policy</a>
      </div>
  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="projectajax.js"></script>
<script>
$(function(){   
    //find error label
$("#savedprojects").on('click',function(){
     $(this).text(function(i, text){
          return text === "Show Projects" ? "Hide Projects" : "Show Projects";
      })
    $(".dataTables_wrapper").toggle("blind");
})
})
</script>
 </body>
</html>