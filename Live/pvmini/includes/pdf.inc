<!DOCTYPE html>
<html>
   <head>
      <title>PVMini - Project Calculations</title>
      <style type="text/css" rel="stylesheet">
         body
         {
            margin: .75in;
            line-height:120%;
            font-family:Helvetica, Arial;
            font-size:12px;
            color:#333;
         }

         h1
         {
            font-size:150%;
            margin-top:1.5em;
            padding-top:1.5em;
         }
         
         h1 img
         {
            width: 25%; 
         }
         
         h2 
         {
            font-size: 117%;
            margin-top:1.3em;
            padding-top:1.3em;
            border-top:1px solid #bbb;
            color:#004628;
            font-weight:bold;
         }
         
         h3
         {
            font-size: 100%;
            margin-top:1.3em;
            margin-left:1.3em;
            color:#004628;
            font-weight:bold;
         }
         
         dt 
         {
            font-weight: bold;
         }
         
         p
         {
            margin: 0;
         }
         
         div.notes p
         {
            margin: 1.2em;
         }
         
         span.label 
         {
            display: inline-block;
            width: 13em;
         }
         
         table
         {
            margin-left:auto;
            margin-right:auto;
            margin-bottom:1.3em;
            border-spacing: 0;
            border-collapse: collapse;
         }
         
         td
         {
            padding:3px 6px;
            border:1px solid #aaa;
         }
         
         th
         {
            text-align:right;
            background-color:#999;
            border:1px solid #aaa;
            color:white;
            font-weight:bold;
            padding:5px;
         }
         
         #zoneData,
         #zoneData tr,
         #zoneData td
         {
            border:0;
            border:2px solid white;
         }
         
         #zoneData td
         {
            border:0;
            vertical-align: top;
            padding:5px 20px;
         }
         
         table.calcTable 
         {
            margin-top:1in;
            font-size:75%;
            width:6in;
         }
         table.calcTable th
         {
            text-align: center;
         }
         
         table.calcTable th.caption{
            background-color:black;
            text-align:left;
         }
         
         table td.emptyCol
         {
            border:0;
         }
         
         div.pagebreak
         {
            page-break-after: before;
         }

         div.partsDisclaimer,
         div.thermalExpansionDisclaimer
         {
            font-size:75%;
            font-style:italic;
            width:100%;
            text-align:left;
            line-height:130%;
         }
         
         .pageHeader
         {
            text-align: right;
            font-size:70%;
         }
         
         .pageFooter
         {
            margin:0px auto;
            font-size: 80%;
            line-height:120%;
            text-align: right;
            border-top: 1px solid #666;
         }
         
         .description,
         #navigationList,
         #onlineOrderLink,
         #docs,
         #footer
         {
            display: none;
         }
         
         table#projectDetails,
         table#projectDetails th,
         table#projectDetails td
         {
            border: 0;
            background-color: none;
            vertical-align: top;
         }

         table#projectDetails th
         {
            font-weight: bold;
            text-align: right;
            color: #000;
         }

         table#projectDetails td
         {
            text-align: left;
            padding-left: 1em;
            padding-right: 4em;
         }
     </style>
   </head>
   <body>

   <h1>
       <img src="img/powersite-logo-green.png" title="PVMini" />
   </h1>

   <h1>Project Information</h1>
   <table id="projectDetails">
      <tr>
         <th>
            Client Name:
         </th>
         <td>
             <?php echo $_POST["cname"]; ?>
         </td>
         <th>
             Project Name:
         </th>
         <td>
             <?php echo isset($_SESSION['projectname']) ? $_SESSION['projectname'] : ''; ?>
         </td>
      </tr>
      <tr>
         <th>
            Client Address:
         </th>
         <td>
             <?php
               echo $_POST["caddress"] . "<br />";
               echo $_POST["ccity"] . ", ". $_POST["cstate"]." " . $_POST["czipcode"] . "<br />";
             ?>
         </td>
         <th>
            Project Address:
         </th>
         <td>
             <?php
               echo isset($_SESSION['projectaddress']) ? $_SESSION['projectaddress'] : '';
               echo " - ";
               echo isset($_SESSION['projzip']) ? $_SESSION['projzip'] : '';
             ?>
         </td>
      </tr>
      <tr>
         <th>
            Client Email Address:
         </th>
         <td>
            <?php echo $_POST["cemail"]; ?>
         </td>
         <td></td>
         <td></td>
      </tr>
      <tr>
         <th>
            Schletter Sales Associate:
         </th>
         <td>
            <?php echo $_POST["sales"]; ?>
         </td>
         <td></td>
         <td></td>
      </tr>
   </table>

   <?php
   ob_start();
   print_r($_POST);
   $projDetails = ob_get_contents();
   ob_end_clean();
   
   $results_output = str_replace("&commat;", "@", $results_output);
   echo $results_output;
   
   ?>   
   </body>
</html>
