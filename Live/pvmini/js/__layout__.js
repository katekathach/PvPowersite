var movingTimer;
var animationSpeed = 25;

function moveModulesHoriz(val)
{
   if(val <= 0)
   {
      // Make sure we don't go off the left
      $('#arrayContainer').animate({left:"0"},1);
      val = 0;
   }
   else if(val > maxXOffset)
   {
      // Make sure we don't go off the right
      $('#arrayContainer').animate({left:maxXOffset},1);
      val = maxXOffset;
   }
   else
   {
      $('#arrayContainer').animate({left:val},1);
   }
   
   yVal = arrayContainer.position();
   updateArrows(val, yVal.top);
   updateXOffset(val);
}

function moveModulesVert(val)
{
   if(val <= 0)
   {
      // Make sure we don't go off the top
      $('#arrayContainer').animate({top:"0"},1);
      val = 0;
   }
   else if(val > maxYOffset)
   {
      // Make sure we don't go off the bottom
      $('#arrayContainer').animate({top:maxYOffset},1);
      val = maxYOffset;
   }
   else
   {
      $('#arrayContainer').animate({top:val},1);
   }
   
   xVal = arrayContainer.position();
   updateArrows(xVal.left, val);   
   updateYOffset(val);
}

function updateXOffset(xPos)
{
   if(xPos < 0)
      xPos = 0;
   $("#xOffset").val(px2units(xPos));
   
   rEdge = xPos + arrayContainer.width();
   
   xPos2 = panelContainer.width() - rEdge;
   if(xPos2 < 0)
      xPos2 = 0;
   
   $("#x2Offset").val(px2units(xPos2));
}

function updateYOffset(yPos)
{
   if(yPos < 0)
      yPos = 0;
   $("#yOffset").val(px2units(yPos));
   
   bEdge = yPos + arrayContainer.height();
   
   yPos2 = panelContainer.height() - bEdge;
   if(yPos2 < 0)
      yPos2 = 0;
   
   $("#y2Offset").val(px2units(yPos2));
}

// Used to shift the panels horizontally
//  more than a single interval.
function shiftArrayHoriz(val)
{
   // Figure out how many pixels to shift
   <?php if(COUNTRY_CANADA == COUNTRY || COUNTRY_UK == COUNTRY) { ?>
   leftVal = inch*val*<?php echo INCHES_PER_METER; ?>;
   <?php } else { ?>
   leftVal = inch*ft2in(val);
   <?php } ?>
   moveModulesHoriz(leftVal);
}

// Used to shift the panels vertically
//  more than a single interval.
function shiftArrayVert(val)
{
   // Figure out how many pixels to shift
   <?php if(COUNTRY_CANADA == COUNTRY || COUNTRY_UK == COUNTRY) { ?>
   topVal = inch*val*<?php echo INCHES_PER_METER; ?>;
   <?php } else { ?>
   topVal = inch*ft2in(val);
   <?php } ?>
   moveModulesVert(topVal);
}

function shiftArrayRight(val)
{
   val = parseFloat(val);
   val += 1.1;
   // Get the right offset + array width and
   // subtract them from the width of the roof.
   leftVal = roofWidthFT - val - arrayWidthFT;
   $("#xOffset").val(leftVal);
   shiftArrayHoriz(leftVal);
}

function shiftArrayBottom(val)
{
   val = parseFloat(val);
   val += 0.019422573;
   val -= 0.000000000821635;

   // Get the right offset + array width and
   // subtract them from the width of the roof.
   topVal = roofHeightFT - val - arrayHeightFT;
   $("#yOffset").val(topVal);
   shiftArrayVert(topVal);   
}

function ft2in(f)
{
   return f*12;
}

function px2units(p)
{
   <?php if(COUNTRY_CANADA == COUNTRY || COUNTRY_UK == COUNTRY) { ?>
   return p/inch/39.3701; // Meters
   <?php } else { ?>
   return p/inch/12;
   <?php } ?>
}

function convertMousePosition(x, y)
{
   x = px2units(x);
   y = px2units(y);
   
   x *= 10;
   y *= 10;
   
   x = Math.round(x);
   y = Math.round(y)

   x /= 10;
   y /= 10;
   
   <?php if(COUNTRY_CANADA == COUNTRY || COUNTRY_UK == COUNTRY) { ?>
   return { x: x, y: y, units: 'm'};
   <?php } else { ?>
   return { x: x, y: y, units: 'ft'};
   <?php } ?>
}

function updateLayout(panel)
{
   if(panel.hasClass('transparent'))
      val = 0;
   else
      val = 1;

   id=panel.attr('id');
   row = id.substr(id.indexOf("_")+1);
   col = parseInt(row.substr(row.indexOf("_")+1));
   row = parseInt(row.substr(0,row.indexOf("_")));
   index = (total_cols*row)+col;
   layout[index] = val;
   $('#layout').val( layout.join(',') );
}

function updateArrows(x, y)
{
   paddingLeft = x;
   if(paddingLeft < 0)
      paddingLeft=0;
   else if(paddingLeft > maxXOffset)
      paddingLeft = maxXOffset;
   
   paddingLeft += 10;
   
   offsetX  = paddingLeft;
   offsetX2 = roofWidth - (offsetX + arrayWidth);
   
   if(paddingLeft > 20)
      paddingLeft = paddingLeft - 20;
   
   paddingRight = offsetX2;
   if(paddingRight > 20)
      paddingRight = paddingRight - 20;

   paddingTop = y;
   if(paddingTop < 0)
      paddingTop=0;
   else if(paddingTop > maxYOffset)
      paddingTop = maxYOffset;
   
   offsetY  = paddingTop;
   offsetY2 = roofHeight - (offsetY + arrayHeight);
   
   if(paddingTop > 20)
      paddingTop = paddingTop - 20;
   
   paddingBottom = offsetY2;
   if(paddingBottom > 20)
      paddingBottom = paddingBottom - 20;

   $("#nw_input").css("top","-"+offsetY+"px");
   $("#nw_input").css("paddingTop",paddingTop+"px");
   
   $("#wn_input").css("left","-"+offsetX+"px");
   $("#wn_input").css("paddingLeft",paddingLeft+"px");
   
   $("#se_input").css("bottom","-"+offsetY2+"px");
   $("#se_input").css("paddingBottom",paddingBottom+"px");

   $("#es_input").css("right","-"+offsetX2+"px");
   $("#es_input").css("paddingRight",paddingRight+"px");
}

function checkZones()
{
   pos = $('#arrayContainer').position();
   pos.right = pos.left + $('#arrayContainer').width()+1;
   pos.bottom = pos.top + $('#arrayContainer').height();
   nwCorner = $('.zone.nw');
   neCorner = $('.zone.ne');
   wExterior = $('.zone.w');
   seCorner = $('.zone.se');
   sePos = seCorner.position();
   
   // For gable roofs, x1=x2 and x3=x4
   // For mono roofs, the values are all different.
   x1 = nwCorner.width();
   x2 = wExterior.width();
   x3 = neCorner.position().left;
   x4 = sePos.left;

   y1 = nwCorner.height();
   y2 = sePos.top;
   
   
   if(pos.top == y1 || pos.top+1 == y1 || pos.top-1 == y1)
   {
      console.info('Snapping to the top');
      $("#nw_input").val(topZoneY);
      shiftArrayVert(topZoneY);
   }
   else if(pos.bottom == y2 || pos.bottom+1 == y2 || pos.bottom-1 == y2)
   {
      console.info('Snapping to the bottom');
      $("#nw_input").val(bottomZoneY);
      shiftArrayVert(bottomZoneY);
   }


   if(pos.left == x1 || pos.left+1 == x1 || pos.left-1 == x1)
   {
      $("#wn_input").val(leftZoneX1);
      shiftArrayHoriz(leftZoneX1);
   }
   else if(pos.left == x2 || pos.left+1 == x2 || pos.left-1 == x2)
   {
      $("#wn_input").val(leftZoneX2);
      shiftArrayHoriz(leftZoneX2);
   }
   else if(pos.right == x3 || pos.right+1 == x3 || pos.right-1 == x3)
   {
      $("#wn_input").val(rightZoneX1);
      shiftArrayHoriz(rightZoneX1);
   }
   else if(pos.right == x4 || pos.right+1 == x4 || pos.right-1 == x4)
   {
      $("#wn_input").val(rightZoneX2);
      shiftArrayHoriz(rightZoneX2);
   }
}