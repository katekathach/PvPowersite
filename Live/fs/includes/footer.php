      <div id='footer' class="clear"> &copy; Schletter Inc. All Rights Reserved | <a href="../mm5/support/Schletter_Privacy_Policy.pdf">Privacy Policy</a> |  <a href='files/PVPowerhouse-Terms-Of-Use.pdf' target='_blank'>Terms of Use</a> | 1001 Commerce Center Dr. &#8226; Shelby, NC 28150  (888) 608 0234 | <a href="mailto:store@schletter.us" target="_blank">store@schletter.us</a> <!--| <a href="../mm5/support/Schletter_ConditionsOfUse.pdf"> Conditions of Use</a>-->
      </div>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="projectajax.js"></script>
   </body>
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
</html>