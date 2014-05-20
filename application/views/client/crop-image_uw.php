<section>
	<?php require_once '_box_callback.php'; ?>

	<h1 class="title"><?=$image->description; ?></h1>


<?php

	$width          = $image->preview ->width;
	$ratio_for_crop = $width/$image->preview ->height; //width/height
	$height         = $width/$ratio_for_crop;



	//Определяем коэффициент соотношения сторон изображения
	$ratio = $height/$width;
	$ratio = round($ratio,3);

//	$ratio_for_crop = $width/$height;
	//Ввычисление максимального размера изображения
	$maxHeightCM = 300;

	$dpi = 300;

	$maxHeight = $maxHeightCM*$dpi*0.3937;
	$maxHeight = round($maxHeight,0);
	$maxWidth  = $maxHeight/$ratio;
	$maxWidth  = round($maxWidth,0);

	//Преобразование пикселей в сантиметры
        //if( $gallery->height_cm == 0 || $gallery->width_cm == 0 )
        //{
            $CmHeight = round($maxHeight/(0.3937*$dpi),0);
            $CmWidth  = round($maxWidth/(0.3937*$dpi),0);
        /*}
        else
        {
            $CmHeight = $gallery->height_cm;//round($maxHeight/(0.3937*$dpi),0);
            $CmWidth  = $gallery->width_cm;//round($maxWidth/(0.3937*$dpi),0);
        }*/
?>


<script>
window.onload = function(){
	var w = document.getElementById('input_crop_width');
	var h = document.getElementById('input_crop_height');
	var lastWValue = undefined;
	var lastHValue = undefined;
	updateDisplay();
	setInterval(updateDisplay, 100);
	function updateDisplay(){
		var thisWValue = w.value || "0";
		var thisHValue = h.value || "0";
		if (lastWValue != thisWValue || lastHValue != thisHValue) {
			cropScript_setImageSizeByInput();
			lastWValue=thisWValue;
			lastHValue=thisHValue;
		}
	}
};
</script>

<script type="text/javascript">
	var xpPanel_slideActive      = true;	// Slide down/up active?
	var xpPanel_slideSpeed       = 15;	    // Speed of slide
	var dhtmlgoodies_xpPane;
	var dhtmlgoodies_paneIndex;
	var savedActivePane          = false;
	var savedActiveSub           = false;
	var xpPanel_currentDirection = false;
	var cookieNames              = new Array();
</script>

<script type="text/javascript">
	/* End of variables you could modify */
	var crop_script_server_file = 'crop_image.php';
	var cropToolBorderWidth = 1; // Width of dotted border around crop rectangle
	var smallSquareWidth = 7; // Size of small squares used to resize crop rectangle
	var smallArrowsWidth = 23; // Size of small squares used to resize crop rectangle
	// Size of image shown in crop tool
	var crop_imageWidth = <?php echo $width;?>;
	var crop_imageHeight =<?php echo  $height;?>;

	var crop_MaxImageWidth = <?php echo $CmWidth;?>;
	var crop_MaxImageHeight = <?php echo $CmHeight;?>;
	// Size of original image
	var crop_originalImageWidth = crop_MaxImageWidth;
	var crop_originalImageHeight = crop_MaxImageHeight;
	var crop_minimumPercent = 10; // Minimum percent - resize
	var crop_maximumPercent = 200; // Maximum percent -resize
	var crop_minimumWidth = crop_originalImageWidth*crop_minimumPercent/100;
	var crop_minimumHeight = crop_originalImageHeight*crop_minimumPercent/100;
	var updateFormValuesAsYouDrag = true; // This variable indicates if form values should be updated as we drag. This process could make the script work a little bit slow. That's why this option is set as a variable.
	if(!document.all)updateFormValuesAsYouDrag = false; // Enable this feature only in IE
</script>

<script type="text/javascript" >
var crop_script_alwaysPreserveAspectRatio = false;
var crop_script_fixedRatio = false; // Fixed aspect ratio(example of value: 1.5). Width of cropping area relative to height(1.5 means that the width is 150% of the height)
// Set this variable to false if you don't want a fixed aspect ratio
var crop_script_browserIsOpera = navigator.userAgent.indexOf('Opera')>=0?true:false;
var cropDiv_left = false;
var cropDiv_top = false;
var cropDiv_right = false;
var cropDiv_bottom = false;
var cropDiv_dotted = false;
var crop_currentResizeType = false;
var cropEvent_posX;
var cropEvent_posY;
var cropEvent_eventX;
var cropEvent_eventY;
var crop_resizeCounter = -1;
var crop_moveCounter = -1;
var crop_imageDiv = false;
var cropDiv_currentWidth=false;
var cropDiv_currentHeight=false;
var imageDiv_currentWidth = false;
var imageDiv_currentHeight = false;
var imageDiv_currentLeft = false;
var imageDiv_currentTop = false;
var smallSquare_tl;
var smallSquare_tc;
var smallSquare_tr;
var smallSquare_lc;
var smallSquare_rc;
var smallSquare_bl;
var smallSquare_bc;
var smallSquare_br;
var smallSquare_cross;
var offsetSmallSquares = Math.floor(smallSquareWidth/2);
var offsetSmallArrows = Math.floor(smallArrowsWidth/2);
var cropScriptAjaxObjects = new Array();
var preserveAspectRatio = false;
var cropWidthRatio = false; // width of cropping area relative to height
function crop_createDivElements(){
	crop_imageDiv= document.getElementById('imageContainer');
	cropDiv_left = document.createElement('DIV');
	cropDiv_left.className = 'crop_transparentDiv';
	cropDiv_left.style.visibility = 'visible';
	cropDiv_left.style.left = '0px';
	cropDiv_left.style.top = '0px';
	cropDiv_left.style.height = crop_imageHeight + 'px';
	cropDiv_left.style.width = '0px';
	cropDiv_left.innerHTML = '<span></span>';
	crop_imageDiv.appendChild(cropDiv_left);
	cropDiv_top = document.createElement('DIV');
	cropDiv_top.className = 'crop_transparentDiv';
	cropDiv_top.style.visibility = 'visible';
	cropDiv_top.style.left = '0px';
	cropDiv_top.style.top = '0px';
	cropDiv_top.style.height = '0px';
	cropDiv_top.style.width = crop_imageWidth + 'px';
	cropDiv_top.innerHTML = '<span></span>';
	crop_imageDiv.appendChild(cropDiv_top);
	cropDiv_right = document.createElement('DIV');
	cropDiv_right.className = 'crop_transparentDiv';
	cropDiv_right.style.visibility = 'visible';
	cropDiv_right.style.left = (crop_imageWidth) + 'px';
	cropDiv_right.style.top = '0px';
	cropDiv_right.style.height = crop_imageHeight + 'px';
	cropDiv_right.style.width = '0px';
	cropDiv_right.innerHTML = '<span></span>';
	crop_imageDiv.appendChild(cropDiv_right);
	cropDiv_bottom = document.createElement('DIV');
	cropDiv_bottom.className = 'crop_transparentDiv';
	cropDiv_bottom.style.visibility = 'visible';
	cropDiv_bottom.style.left = '0px';
	cropDiv_bottom.style.top = (crop_imageHeight) + 'px';
	cropDiv_bottom.style.height = '0px';
	cropDiv_bottom.style.width = crop_imageWidth + 'px';
	cropDiv_bottom.innerHTML = '<span></span>';
	crop_imageDiv.appendChild(cropDiv_bottom);
	cropDiv_dotted = document.createElement('DIV');
	cropDiv_dotted.className='crop_dottedDiv';
	cropDiv_dotted.style.left = '0px';
	cropDiv_dotted.style.top = '0px';
	cropDiv_dotted.style.width = (crop_imageWidth-(cropToolBorderWidth*2)) + 'px';
	cropDiv_dotted.style.height = (crop_imageHeight-(cropToolBorderWidth*2)) + 'px';
	cropDiv_dotted.innerHTML = '<div ></div>';
	cropDiv_dotted.style.cursor = 'move';
	cropDiv_currentWidth=(crop_imageWidth-(cropToolBorderWidth*2));
	cropDiv_currentHeight=(crop_imageHeight-(cropToolBorderWidth*2));
	cropDiv_dotted.onmousedown = cropScript_initMove;
	smallSquare_tl = document.createElement('IMG');
	smallSquare_tl.src = '<?=base_url(); ?>/img/crop/small_square.gif';
	smallSquare_tl.style.position = 'absolute';
	smallSquare_tl.style.left = (-offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_tl.style.top = (-offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';

	smallSquare_tl.id = 'nw-resize';

	cropDiv_dotted.appendChild(smallSquare_tl);
	smallSquare_tr = document.createElement('IMG');
	smallSquare_tr.src = '<?=base_url(); ?>/img/crop/small_square.gif';
	smallSquare_tr.style.position = 'absolute';
	smallSquare_tr.style.left = (crop_imageWidth - offsetSmallSquares - (cropToolBorderWidth*2)) + 'px';
	smallSquare_tr.style.top = (-offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	// smallSquare_tr.style.cursor = 'ne-resize';
	smallSquare_tr.id = 'ne-resize';
	// smallSquare_tr.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_tr);
	smallSquare_bl = document.createElement('IMG');
	smallSquare_bl.src = '<?=base_url(); ?>/img/crop/small_square.gif';
	smallSquare_bl.style.position = 'absolute';
	smallSquare_bl.style.left = (-offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_bl.style.top = (crop_imageHeight - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	// smallSquare_bl.style.cursor = 'sw-resize';
	smallSquare_bl.id = 'sw-resize';
	// smallSquare_bl.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_bl);
	smallSquare_br = document.createElement('IMG');
	smallSquare_br.src = '<?=base_url(); ?>/img/crop/small_square.gif';
	smallSquare_br.style.position = 'absolute';
	smallSquare_br.style.left = (crop_imageWidth - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_br.style.top = (crop_imageHeight - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	// smallSquare_br.style.cursor = 'se-resize';
	smallSquare_br.id = 'se-resize';
	// smallSquare_br.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_br);
	smallSquare_tc = document.createElement('IMG');
	smallSquare_tc.src = '<?=base_url(); ?>/img/crop/small_arrows_v.gif';
	smallSquare_tc.style.position = 'absolute';
	smallSquare_tc.style.left = (Math.floor(crop_imageWidth/2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_tc.style.top = (-offsetSmallArrows -(cropToolBorderWidth*2)) + 'px';
	smallSquare_tc.style.cursor = 's-resize';
	smallSquare_tc.id = 'n-resize';
	smallSquare_tc.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_tc);
	smallSquare_bc = document.createElement('IMG');
	smallSquare_bc.src = '<?=base_url(); ?>/img/crop/small_arrows_v.gif';
	smallSquare_bc.style.position = 'absolute';
	smallSquare_bc.style.left = (Math.floor(crop_imageWidth/2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_bc.style.top = (crop_imageHeight -offsetSmallArrows-1 -(cropToolBorderWidth*2)) + 'px';
	smallSquare_bc.style.cursor = 's-resize';
	smallSquare_bc.id = 's-resize';
	smallSquare_bc.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_bc);
	smallSquare_lc = document.createElement('IMG');
	smallSquare_lc.src = '<?=base_url(); ?>/img/crop/small_arrows_h.gif';
	smallSquare_lc.style.position = 'absolute';
	smallSquare_lc.style.left = (-offsetSmallArrows -(cropToolBorderWidth*2)) + 'px';
	smallSquare_lc.style.top = (Math.floor(crop_imageHeight/2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_lc.style.cursor = 'e-resize';
	smallSquare_lc.id = 'w-resize';
	smallSquare_lc.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_lc);
	smallSquare_rc = document.createElement('IMG');
	smallSquare_rc.src = '<?=base_url(); ?>/img/crop/small_arrows_h.gif';
	smallSquare_rc.style.position = 'absolute';
	smallSquare_rc.style.left = (crop_imageWidth - offsetSmallArrows -(cropToolBorderWidth*2)) + 'px';
	smallSquare_rc.style.top = (Math.floor(crop_imageHeight/2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_rc.style.cursor = 'e-resize';
	smallSquare_rc.id = 'e-resize';
	smallSquare_rc.onmousedown = cropScript_initResize;
	cropDiv_dotted.appendChild(smallSquare_rc);
	smallSquare_cross = document.createElement('IMG');
	smallSquare_cross.src = '<?=base_url(); ?>/img/crop/small_arrows_cross.gif';
	smallSquare_cross.style.position = 'absolute';
	smallSquare_cross.style.display = 'none';
	smallSquare_cross.style.left = ( Math.floor(crop_imageWidth)/2 - offsetSmallArrows -(cropToolBorderWidth*2) ) + 'px';
	smallSquare_cross.style.top = (Math.floor(crop_imageHeight/2) - offsetSmallArrows -(cropToolBorderWidth*2)) + 'px';
	cropDiv_dotted.appendChild(smallSquare_cross);
	crop_imageDiv.appendChild(cropDiv_dotted);
}
function cropScript_initMove(e){
	if(document.all)e=event;
	if (e.target) source = e.target;
	else if (e.srcElement) source = e.srcElement;
	if (source.nodeType == 3) // defeat Safari bug
	source = source.parentNode;
	if(source.id && source.id.indexOf('resize')>=0)return;
	imageDiv_currentLeft = cropDiv_dotted.style.left.replace('px','')/1;
	imageDiv_currentTop = cropDiv_dotted.style.top.replace('px','')/1;
	imageDiv_currentWidth = cropDiv_dotted.style.width.replace('px','')/1;
	imageDiv_currentHeight = cropDiv_dotted.style.height.replace('px','')/1;
	cropEvent_eventX = e.clientX;
	cropEvent_eventY = e.clientY;
	crop_moveCounter = 0;
	cropScript_timerMove();
	return false;
}
function cropScript_timerMove(){
	if(crop_moveCounter>=0 && crop_moveCounter<10){
		crop_moveCounter++;
		setTimeout('cropScript_timerMove()',1);
		return;
	}
}
function cropScript_initResize(e){
	if(document.all)e = event;
	cropDiv_dotted.style.cursor = 'default';
	crop_currentResizeType = this.id;
	cropEvent_eventX = e.clientX;
	cropEvent_eventY = e.clientY;
	crop_resizeCounter = 0;
	imageDiv_currentWidth = cropDiv_dotted.style.width.replace('px','')/1;
	imageDiv_currentHeight = cropDiv_dotted.style.height.replace('px','')/1;
	imageDiv_currentLeft = cropDiv_dotted.style.left.replace('px','')/1;
	imageDiv_currentTop = cropDiv_dotted.style.top.replace('px','')/1;
	cropWidthRatio = cropDiv_dotted.offsetWidth / cropDiv_dotted.offsetHeight;
	if(crop_script_fixedRatio)cropWidthRatio = crop_script_fixedRatio;
	if(document.all){
		var div = cropDiv_dotted.getElementsByTagName('DIV')[0];
		div.style.display='none';
	}
	cropScript_timerResize();
	return false;
}
function cropScript_timerResize(){
	if(crop_resizeCounter>=0 && crop_resizeCounter<10){
		crop_resizeCounter = crop_resizeCounter + 1;
		setTimeout('cropScript_timerResize()',1);
		return;
	}
}
function cropScript_executeCrop(buttonObj){
	crop_startProgressBar();
	buttonObj.style.visibility='hidden';
	var ajaxIndex = cropScriptAjaxObjects.length;
	cropScriptAjaxObjects[ajaxIndex] = new sack();
	var url = crop_script_server_file;
	cropScriptAjaxObjects[ajaxIndex].requestFile = url; // Specifying which file to get
	cropScriptAjaxObjects[ajaxIndex].setVar('image_ref',document.getElementById('input_image_ref').value);
	cropScriptAjaxObjects[ajaxIndex].setVar('x',document.getElementById('input_crop_x').value);
	cropScriptAjaxObjects[ajaxIndex].setVar('y',document.getElementById('input_crop_y').value);
	cropScriptAjaxObjects[ajaxIndex].setVar('width',document.getElementById('input_crop_width').value);
	cropScriptAjaxObjects[ajaxIndex].setVar('height',document.getElementById('input_crop_height').value);
	cropScriptAjaxObjects[ajaxIndex].setVar('percentSize',document.getElementById('crop_percent_size').value);
	cropScriptAjaxObjects[ajaxIndex].setVar('convertTo',document.getElementById('input_convert_to').options[document.getElementById('input_convert_to').selectedIndex].value);
	cropScriptAjaxObjects[ajaxIndex].onCompletion = function(){ cropScript_cropCompleted(ajaxIndex,buttonObj); }; // Specify function that will be executed after file has been found
	cropScriptAjaxObjects[ajaxIndex].runAJAX(); // Execute AJAX function
}
function cropScript_cropCompleted(ajaxIndex,buttonObj){
	buttonObj.style.visibility='';
	eval(cropScriptAjaxObjects[ajaxIndex].response)
	cropScriptAjaxObjects[ajaxIndex] = false;
	crop_hideProgressBar();
}
function crop_cancelEvent(e){
	if(document.all)e = event;
	if (e.target) source = e.target;
	else if (e.srcElement) source = e.srcElement;
	if (source.nodeType == 3) // defeat Safari bug
	source = source.parentNode;
	if(source.tagName && source.tagName.toLowerCase()=='input')return true;
	return false;
}
var mouseMoveEventInProgress = false;
function getAdjustedCoordinates(coordinates,currentCoordinates,aspectRatio,currentResize){
	currentResize = currentResize.replace('-resize','');
	var minWidth = aspectRatio?crop_minimumWidth*aspectRatio:crop_minimumWidth;
	var minHeight = aspectRatio?crop_minimumHeight/aspectRatio:crop_minimumHeight;
	if(coordinates.left + coordinates.width + 2 > crop_imageWidth) {
	coordinates.width = crop_imageWidth - coordinates.left - 2;
	}
	if(coordinates.top + coordinates.height + 2 > crop_imageHeight) {
	coordinates.height = crop_imageHeight - coordinates.top - 2;
	}
	if(coordinates.height < minHeight){
	coordinates.height = currentCoordinates.height;
	coordinates.top = currentCoordinates.top;
	}
	if(coordinates.width < minWidth){
	coordinates.width = currentCoordinates.width;
	coordinates.left = currentCoordinates.left;
	}
	if(aspectRatio) {
	var currentRatio = coordinates.width / coordinates.height;
	switch(currentResize) {
	case 'n':
	// Height is being resized - set new left coordinate
	var newWidth = Math.round(coordinates.height * aspectRatio);
	coordinates.left += (coordinates.width - newWidth);
	coordinates.width = newWidth;
	break;
	case 'w':
	case 'nw':
	case 'ne':
	// Width is being resized - Set new top coordinate
	var newHeight = Math.round(coordinates.width / aspectRatio);
	coordinates.top += (coordinates.height - newHeight);
	coordinates.height = newHeight;
	break;
	case 'e':
	case 'se':
	coordinates.height = Math.round(coordinates.width / aspectRatio);
	break;
	case 's':
	coordinates.width = Math.round(coordinates.height * aspectRatio);
	break;
	default:
	}
	if(coordinates.left < 0) {
	coordinates.width += coordinates.left;
	coordinates.height = coordinates.width / aspectRatio;
	coordinates.left = 0;
	}
	if(coordinates.top < 0) {
	var origWidth = coordinates.width;
	coordinates.height += coordinates.top;
	coordinates.width = coordinates.height * aspectRatio;
	coordinates.top = 0;
	if(currentResize=='nw') {
	coordinates.left+=(origWidth-coordinates.width);
	}
	}
	if(coordinates.width < minWidth) {
	coordinates.width = minWidth;
	coordinates.height = coordinates.width / aspectRatio;
	}
	if(coordinates.height < minHeight) {
	coordinates.height = minHeight;
	coordinates.width = coordinates.height * aspectRatio;
	}
	if(coordinates.left + coordinates.width + 2 > crop_imageWidth) {
	coordinates.width = crop_imageWidth - coordinates.left - 2;
	coordinates.height = Math.round(coordinates.width / aspectRatio)
	}
	if(coordinates.top + coordinates.height + 2 > crop_imageHeight) {
	coordinates.height = crop_imageHeight - coordinates.top - 2;
	coordinates.width = Math.round(coordinates.height * aspectRatio)
	}
	}
	if(coordinates.height < minHeight){
	coordinates.height = currentCoordinates.height;
	coordinates.top = currentCoordinates.top;
	}
	if(coordinates.width < minWidth){
	coordinates.width = currentCoordinates.width;
	coordinates.left = currentCoordinates.left;
	}
	return coordinates;
}
function cropScript_mouseMove(e){
	if(crop_moveCounter<10 && crop_resizeCounter<10)return;
	if(mouseMoveEventInProgress)return;
	if(document.all)mouseMoveEventInProgress = true;
	if(document.all)e = event;
	if(crop_resizeCounter==10){
	var cropStyleObj = cropDiv_dotted.style;

	preserveAspectRatio = false;
	var currentCoordinates = {
	left: cropStyleObj.left.replace('px','')/1,
	top: cropStyleObj.top.replace('px','')/1,
	width: cropDiv_currentWidth, //cropDiv_dotted.clientWidth,
	height: cropDiv_currentHeight //cropDiv_dotted.clientHeight
	}

	var newCoordinates = {};
	newCoordinates.left = currentCoordinates.left;
	newCoordinates.top = currentCoordinates.top;
	newCoordinates.width = currentCoordinates.width;
	newCoordinates.height = currentCoordinates.height;
	if(crop_currentResizeType=='e-resize' || crop_currentResizeType=='ne-resize' || crop_currentResizeType == 'se-resize'){
	if(currentCoordinates.height+(cropToolBorderWidth*2)==crop_imageHeight)
	{
	newCoordinates.width = Math.max(crop_minimumWidth,(imageDiv_currentWidth + e.clientX - cropEvent_eventX));
	}
	}
	if(crop_currentResizeType=='s-resize' || crop_currentResizeType=='sw-resize' || crop_currentResizeType == 'se-resize'){

	if(currentCoordinates.width+(cropToolBorderWidth*2)==crop_imageWidth)
	{
	newCoordinates.height = Math.max(crop_minimumHeight,(imageDiv_currentHeight + e.clientY - cropEvent_eventY));
	}
	}
	if(crop_currentResizeType=='n-resize' || crop_currentResizeType=='nw-resize' || crop_currentResizeType=='ne-resize'){
	var newTop = Math.max(0,(imageDiv_currentTop + e.clientY - cropEvent_eventY));

	if(currentCoordinates.width+(cropToolBorderWidth*2)==crop_imageWidth)
	{
	newCoordinates.height+=(currentCoordinates.top-newTop);
	newCoordinates.top = newTop;
	}
	}
	if(crop_currentResizeType=='w-resize' || crop_currentResizeType=='sw-resize' || crop_currentResizeType=='nw-resize'){
	var newLeft = Math.max(0,(imageDiv_currentLeft + e.clientX - cropEvent_eventX));

	if(currentCoordinates.height+(cropToolBorderWidth*2)==crop_imageHeight)
	{
	newCoordinates.width+=(currentCoordinates.left-newLeft);
	newCoordinates.left = newLeft;
	}
	}
	if(newCoordinates && (newCoordinates.left || newCoordinates.top || newCoordinates.width || newCoordinates.height)) {
	newCoordinates = getAdjustedCoordinates(newCoordinates,currentCoordinates,preserveAspectRatio?cropWidthRatio:false,crop_currentResizeType);
	}
	if(newCoordinates) {
	cropStyleObj.left = newCoordinates.left + 'px';
	cropStyleObj.top = newCoordinates.top + 'px';
	cropStyleObj.width = newCoordinates.width + 'px';
	cropStyleObj.height = newCoordinates.height + 'px';
	cropDiv_currentWidth=newCoordinates.width;
	cropDiv_currentHeight=newCoordinates.height;
	}
	if(!crop_script_fixedRatio && !e.ctrlKey)cropWidthRatio = cropDiv_dotted.offsetWidth / cropDiv_dotted.offsetHeight;
	}
	if(crop_moveCounter==10){
	var tmpLeft = imageDiv_currentLeft + e.clientX - cropEvent_eventX;
	if(tmpLeft<0)tmpLeft=0;
	if ((tmpLeft + imageDiv_currentWidth + (cropToolBorderWidth*2))>crop_imageWidth)tmpLeft = crop_imageWidth - imageDiv_currentWidth - (cropToolBorderWidth*2);
	cropDiv_dotted.style.left = tmpLeft + 'px';
	var tmpTop = imageDiv_currentTop + e.clientY - cropEvent_eventY;
	if(tmpTop<0)tmpTop=0;
	if((tmpTop + imageDiv_currentHeight + (cropToolBorderWidth*2))>crop_imageHeight)tmpTop = crop_imageHeight - imageDiv_currentHeight - (cropToolBorderWidth*2);
	cropDiv_dotted.style.top = tmpTop + 'px';
	}
	repositionSmallSquares();
	resizeTransparentSquares();
	if(updateFormValuesAsYouDrag)cropScript_updateFormValues();
	mouseMoveEventInProgress = false;
}
function repositionSmallSquares(){
	smallSquare_tc.style.left = (Math.floor((cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2)) /2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_bc.style.left = (Math.floor((cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2)) /2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_tr.style.left = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_br.style.left = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_br.style.top = (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_bl.style.top = (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_lc.style.top = (Math.floor((cropDiv_dotted.style.height.replace('px','')/1 + cropToolBorderWidth)/2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';
	smallSquare_rc.style.top = (Math.floor((cropDiv_dotted.style.height.replace('px','')/1 + cropToolBorderWidth)/2) - offsetSmallSquares -(cropToolBorderWidth*2)) + 'px';

	smallSquare_bc.style.top = (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2) - offsetSmallArrows -1 -(cropToolBorderWidth*2)) + 'px';
	smallSquare_rc.style.left = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2) - offsetSmallArrows -1 -(cropToolBorderWidth*2)) + 'px';
	smallSquare_cross.style.left = ( Math.floor((cropDiv_dotted.style.width.replace('px','')/1 + cropToolBorderWidth)/2) - offsetSmallArrows -(cropToolBorderWidth*2) ) + 'px';
	smallSquare_cross.style.top = (Math.floor((cropDiv_dotted.style.height.replace('px','')/1 + cropToolBorderWidth)/2) - offsetSmallArrows -(cropToolBorderWidth*2)) + 'px';
}
function small_visibility(){
	if (cropDiv_currentWidth+(cropToolBorderWidth*2)<crop_imageWidth)
	{
	smallSquare_tc.style.display='none';
	smallSquare_bc.style.display='none';
	}
	else
	{
	smallSquare_tc.style.display='block';
	smallSquare_bc.style.display='block';
	}
	if (cropDiv_currentHeight+(cropToolBorderWidth*2)<crop_imageHeight)
	{
	smallSquare_lc.style.display='none';
	smallSquare_rc.style.display='none';
	}
	else
	{
	smallSquare_lc.style.display='block';
	smallSquare_rc.style.display='block';
	}
	if (cropDiv_currentHeight+(cropToolBorderWidth*2)<crop_imageHeight || cropDiv_currentWidth+(cropToolBorderWidth*2)<crop_imageWidth)
	{
	smallSquare_cross.style.display = 'block';
	}
	else
	{
	smallSquare_cross.style.display = 'none';
	}
}
function resizeTransparentSquares(){
	cropDiv_left.style.width = cropDiv_dotted.style.left;
	cropDiv_right.style.width = Math.max(0,crop_imageWidth - (cropToolBorderWidth*2) - (cropDiv_dotted.style.width.replace('px','')/1 + cropDiv_dotted.style.left.replace('px','')/1)) + 'px';
	cropDiv_right.style.left = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2) + cropDiv_dotted.style.left.replace('px','')/1) + 'px';
	cropDiv_bottom.style.height = Math.max(0,crop_imageHeight - (cropToolBorderWidth*2) - (cropDiv_dotted.style.height.replace('px','')/1 + cropDiv_dotted.style.top.replace('px','')/1)) + 'px';
	cropDiv_bottom.style.top = (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2) + cropDiv_dotted.style.top.replace('px','')/1) + 'px';
	cropDiv_top.style.height = cropDiv_dotted.style.top;
	cropDiv_bottom.style.left = cropDiv_dotted.style.left;
	cropDiv_bottom.style.width = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2)) + 'px' ;
	cropDiv_top.style.left = cropDiv_dotted.style.left;
	cropDiv_top.style.width = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2)) + 'px' ;
	if(cropDiv_left.style.width=='0px')cropDiv_left.style.visibility='hidden';else cropDiv_left.style.visibility='visible';
	if(cropDiv_right.style.width=='0px')cropDiv_right.style.visibility='hidden';else cropDiv_right.style.visibility='visible';
	if(cropDiv_bottom.style.width=='0px')cropDiv_bottom.style.visibility='hidden';else cropDiv_bottom.style.visibility='visible';
	document.getElementById('crop_width').value = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2));
	document.getElementById('crop_height').value = (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2));
}
function cropScript_updateFormValues(){
	document.getElementById('input_crop_x').value = Math.round(cropDiv_dotted.style.left.replace('px','')/1 * (crop_originalImageWidth/crop_imageWidth));
	document.getElementById('input_crop_y').value = Math.round(cropDiv_dotted.style.top.replace('px','')/1 * (crop_originalImageHeight/crop_imageHeight));
	/* add changes */
	//document.getElementById('input_crop_x1').value = Math.round(cropDiv_dotted.style.left.replace('px','')/1 * (crop_originalImageWidth/crop_imageWidth));
	//document.getElementById('input_crop_y1').value = Math.round(cropDiv_dotted.style.top.replace('px','')/1 * (crop_originalImageHeight/crop_imageHeight));
	/* *********** */
	if (Math.round((cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2)) * (crop_originalImageWidth/crop_imageWidth)) != document.getElementById('input_crop_width').value ){
		document.getElementById('input_crop_width').value = Math.round((cropDiv_currentWidth + (cropToolBorderWidth*2)) * (crop_originalImageWidth/crop_imageWidth));

	}
	if (Math.round( (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2)) * (crop_originalImageHeight/crop_imageHeight)) != document.getElementById('input_crop_height').value ){
		document.getElementById('input_crop_height').value = Math.round( ( cropDiv_currentHeight + (cropToolBorderWidth*2)) * (crop_originalImageHeight/crop_imageHeight));
	}
	document.getElementById('crop_width').value = (cropDiv_dotted.style.width.replace('px','')/1 + (cropToolBorderWidth*2));
	document.getElementById('crop_height').value = (cropDiv_dotted.style.height.replace('px','')/1 + (cropToolBorderWidth*2));
}
function cropScript_stopResizeMove(){
	crop_resizeCounter = -1;
	crop_moveCounter = -1;
	cropDiv_dotted.style.cursor = 'move';
	cropScript_updateFormValues();
	if(document.all){
		var div = cropDiv_dotted.getElementsByTagName('DIV')[0];
		div.style.display='block';
	}
	small_visibility();
}
function cropScript_setImageSizeByInput(){
	var obj_x = document.getElementById('input_crop_x');
	var obj_y = document.getElementById('input_crop_y');
	var obj_width = document.getElementById('input_crop_width');
	var obj_height = document.getElementById('input_crop_height');
	obj_width.value = obj_width.value.replace(/[^0-9]/gi,'');
	obj_height.value = obj_height.value.replace(/[^0-9]/gi,'');

	//if(obj_width.value.length==0) return

	//if(obj_height.value.length==0) return

	//if(obj_width.value< crop_minimumWidth || obj_width.value==0 ) return;

	//if(obj_height.value< crop_minimumHeight || obj_height.value==0) return;

	//if(obj_width.value/1 > crop_MaxImageWidth) return;

	//if(obj_height.value/1 > crop_MaxImageHeight)return;
	var k_h=(crop_originalImageHeight/(obj_height.value));
	var k_w=(crop_originalImageWidth/ (obj_width.value));

	if ( k_w < k_h )
	{
	crop_originalImageWidth=obj_width.value;
	crop_originalImageHeight=Math.round ( crop_originalImageHeight/k_w );
	}
	else
	{
	crop_originalImageHeight=obj_height.value;
	crop_originalImageWidth=Math.round( crop_originalImageWidth / k_h );
	}
	cropDiv_currentHeight=( obj_height.value * (crop_imageHeight / crop_originalImageHeight) -cropToolBorderWidth*2 );
	cropDiv_currentWidth= ( obj_width.value * (crop_imageWidth / crop_originalImageWidth) -cropToolBorderWidth*2 ) ;
	cropDiv_dotted.style.width = cropDiv_currentWidth+ 'px';
	cropDiv_dotted.style.height = cropDiv_currentHeight+ 'px';
	if(cropDiv_dotted.style.left.replace('px','')/1 + cropDiv_currentWidth + 2 > crop_imageWidth) {
	cropDiv_dotted.style.left = (crop_imageWidth-cropDiv_currentWidth -2)+'px';
	}
	if(cropDiv_dotted.style.top.replace('px','')/1 + cropDiv_currentHeight + 2 > crop_imageHeight) {
	cropDiv_dotted.style.top = (crop_imageHeight-cropDiv_currentHeight-2 )+'px';
	}
	repositionSmallSquares();
	resizeTransparentSquares();

	small_visibility();
}
function cropScript_setCropSizeByInput(){
	var obj_x = document.getElementById('input_crop_x');
	var obj_y = document.getElementById('input_crop_y');
	obj_x.value = obj_x.value.replace(/[^0-9]/gi,'');
	obj_y.value = obj_y.value.replace(/[^0-9]/gi,'');
	if(obj_x.value.length==0)obj_x.value=0;
	if(obj_y.value.length==0)obj_y.value=0;
	if(obj_x.value>(crop_originalImageWidth-crop_minimumWidth))obj_x.value = crop_originalImageWidth-crop_minimumWidth;
	if(obj_y.value>(crop_originalImageHeight-crop_minimumHeight))obj_y.value = crop_originalImageHeight-crop_minimumHeight;

	if(obj_x.value/1 + obj_width.value/1 > crop_originalImageWidth) obj_width.value = crop_originalImageWidth - obj_x.value;
	if(obj_y.value/1 + obj_height.value/1 > crop_originalImageHeight) obj_height.value = crop_originalImageHeight - obj_y.value;
	cropDiv_dotted.style.left = Math.round(obj_x.value/1 * (crop_imageWidth / crop_originalImageWidth)) + 'px';
	cropDiv_dotted.style.top = Math.round(obj_y.value/1 * (crop_imageHeight / crop_originalImageHeight)) + 'px';
}
function cropScript_setBasicEvents(){
	document.documentElement.ondragstart = crop_cancelEvent;
	document.documentElement.onselectstart = crop_cancelEvent;
	document.documentElement.onmousemove = cropScript_mouseMove;
	document.documentElement.onmouseup = cropScript_stopResizeMove;
	document.getElementById("input_crop_x").onblur = cropScript_setCropSizeByInput;
	document.getElementById("input_crop_y").onblur = cropScript_setCropSizeByInput;
	document.getElementById("input_crop_height").onblur = cropScript_setImageSizeByInput;
	document.getElementById("input_crop_width").onblur = cropScript_setImageSizeByInput;
}
function cropScript_validatePercent(){
	this.value=this.value.replace(/[^0-9]/gi,'');
	if(this.value.length==0)this.value='1';
	if(this.value/1>crop_maximumPercent)this.value='100';
	if(this.value/1<crop_minimumPercent)this.value=crop_minimumPercent
}
function crop_initFixedRatio(){
	if(crop_script_fixedRatio>1){
		document.getElementById('input_crop_height').value = Math.round(document.getElementById('input_crop_width').value) / crop_script_fixedRatio;
	}else{
		document.getElementById('input_crop_width').value = Math.round(document.getElementById('input_crop_height').value) / crop_script_fixedRatio;
	}
	cropScript_setCropSizeByInput();
}
function init_imageCrop(){
	cropScript_setBasicEvents();
	crop_createDivElements();
	cropScript_updateFormValues();
	if(crop_script_fixedRatio && crop_script_alwaysPreserveAspectRatio){
		crop_initFixedRatio();
	}
}
</script>
<!--=========================================================================================================================================================================WE-->
<script type="text/javascript">
//вычисление площади обрезаного изображения
function ChangeSq(event)	
{
	var per = (((document.getElementById('input_crop_width').value*document.getElementById('input_crop_height').value)/10000)%1).toFixed(3);
	var len = per.length;
	var l,tttt=0;
	var str = new Array();
	for(var i=0;i<len;i++){
		str[i] = per[i];
		if(i == len-1){
			var sq = ((1*( ((document.getElementById('input_crop_width').value * document.getElementById('input_crop_height').value)/10000).toFixed(3)))).toFixed(2);
			document.getElementById('square').innerHTML = sq;
			Textura.summa()
		}
	}
}
function CheckBoundarySizeWidth(inputSize){
	//max
    if(inputSize > crop_MaxImageWidth) {
        alert('Введенная ширина не должна превышать '+ Math.ceil( crop_MaxImageWidth ) );
        return;
    }
    
	//min
    if(inputSize < crop_minimumWidth) {
		alert('Введенная ширина не должна быть меньше '+ Math.ceil( crop_minimumWidth ) );
		return;
    }
}

function CheckBoundarySizeHeight(inputSize){
    //max
    if(inputSize > crop_MaxImageHeight) {
		alert('Введенная высота не должна превышать '+ Math.ceil( crop_MaxImageHeight ) );
		return;
    }
    
    //min
    if(inputSize < crop_minimumHeight) {
		alert('Введенная высота не должна быть меньше '+ Math.ceil( crop_minimumHeight ) );
		return;
    }
}
//изменяет данные в полях параметров заказа (макс. размер изображения, координаты верхнего левого угла, координаты нижнего правого, размер обрезаного изображения)
function changeDateOrder() 
{
	var mas;
	var y1,h1; //координаты 'y' и 'высоты' размещения нижнего правого угла от начиная сверху
	var x1,w1; //координаты 'x' и 'ширины' размещения нижнего правого угла от начиная слева

	y1=(document.getElementById('input_crop_y').value)*1;
	h1=(document.getElementById('input_crop_height').value)*1;

	x1=(document.getElementById('input_crop_x').value)*1;
	w1=(document.getElementById('input_crop_width').value)*1;
	var yBR=0; //координата нижней правой точки
	var xBR

	yBR = y1+h1;
	xBR = x1+w1;

	mas = [document.getElementById('input_crop_x').value, document.getElementById('input_crop_y').value, xBR,yBR,document.getElementById('input_crop_width').value,document.getElementById('input_crop_height').value];
	document.getElementById('coordinats').value = mas.join(',');
}
</script>

<!--=================================================================================================================================================NEW-->

<div  class="crop_content" style="padding:10px 0 20px 15px;overflow:hidden;font-family:sans-serif,arial;" onMouseMove="changeDateOrder()">

	<div style="overflow:hidden;">
		
		<div class="form-instruction">
			<a class="butt_" style="padding:0 10px" onclick="$('.text-instruction').toggleClass('active');"><?=$lang == '/ua' ? 'Інструкція' : 'instruction' ;?></a>
		</div>
		
		<div class="text-instruction" style="width:460px; padding:35px 0 10px;"> 
			<strong><?=$lang == '/ua' ? 'Інструкція з використання:' : 'Operation manual:' ;?></strong>
			<ul style="list-style:decimal outside;margin:5px 0 5px 40px;">
				<li>
					<?=$lang == '/ua' ? 'Введіть розмір або пересуньте стрілочку по горизонталі або по вертикалі.' : 'Enter the size or move the arrow' ;?>
				</li>
				<li>
					<?=$lang == '/ua' ? 'Пересуньте видимий блок в потрібну частину зображення.' : 'Move the unit visible in the right part of the image' ;?>
				</li>
<li>
					<?=$lang == '/ua' ? 'Вибрати тип друку.' : 'Select the type of printing' ;?>
				</li>
				<li>
					<?=$lang == '/ua' ? 'Вибрати текстуру.' : 'Select texture' ;?>
				</li>
				
				<li>
					<?=$lang == '/ua' ? 'Введіть всі необхідні поля з контактими даними.' : 'Order form' ;?>
				</li>
				<li>
					<?=$lang == '/ua' ? 'Зробіть замовлення, натиснувши на відповідну кнопку.' : 'Make your order by clicking the button' ;?>
				</li>
			</ul>
		</div>

	</div>
    <style>
      /*  .floating{
            width: 755px;
        }
        .floating-2{
            width: 526px;
        }
        .floating-3{
            width: 530px;
        }
        .fixed{
            position: fixed;
            top: 0;
            z-index: 9999; 
        }
        .fixed-2{
            position: fixed;
            top: 43px;
            z-index: 9999; 
        }
        .fixed-3{
            position: fixed;
            top: 77px;
            z-index: 9999; 
        }
        */
    </style>
    <script>
       /* $(document).ready(function(){
            
            $(window).scroll(function(){
                var top = $(document).scrollTop();
                if( top > 287 && top < 790) {
                    $('.floating').addClass('fixed');
                    $('.floating-2').addClass('fixed-2');
                    $('.floating-3').addClass('fixed-3');
                } 
                else {
                    $('.floating').removeClass('fixed');
                    $('.floating-2').removeClass('fixed-2');
                    $('.floating-3').removeClass('fixed-3');
                }
                console.log(top);
            });
        });*/
    </script>
        <?php if( isset($_SESSION['dataNonValid']) ):?>
            <div id="dataNonValid" style="color:#FF6000; font-size:20px"><?=$_SESSION['dataNonValid']?></div>
        <?php endif; ?>
	<div class="floating" style="background:#E2E3C2;overflow:hidden;-moz-user-select: none;-khtml-user-select: none;user-select: none; margin-top: 10px;">
		<!--<div style="background:#D5D6A5;float:left;width:530px;padding:5px 0;text-align:center;">
			<a class="filter"    id="flip"    data-filter="flip"><?=$lang == '/ua' ? 'отзеркаліть' : 'отзеркалить' ;?></a>
			<a class="filter cl" id="black"   data-filter="black"><?=$lang == '/ua' ? 'чорно-біле' : 'черно-белое' ;?></a>
			<a class="filter cl" id="sepia"   data-filter="sepia"><?=$lang == '/ua' ? 'сепія' : 'сепия' ;?></a>
			<a class="filter cl" id="negativ" data-filter="negativ"><?=$lang == '/ua' ? 'негатив' : 'негатив' ;?></a>
		</div>
-->
		<div style="margin:0 0 0 530px;padding:5px;text-align:center;">
			<span class="filter"><b>texture</b></span>
		</div>

	</div>
        <div class="floating-2" style="margin-top: 10px; color: #8B816E; font-size: 20px; padding-left: 229px; ">
            <span>№ <?= $image->id ?></span>
        </div>
	<div class="floating-3" style="float:left;width:530px;">

		<div id="imageContainer" onMouseMove="ChangeSq();" style="display:inline-block;margin:10px 0 10px <?=$width < 530 ? ((530 - $width)/2).'px' : 0 ?>;">
			
            
  
            
          
            
            <img id="_img_" alt="<?= $image->title?>" title="<?=$image->title?>" src="<?= $image->preview->url?>" width="<?=$image->preview->width?>" >
            
            
		</div>

		<?php
			$new_ratio = $CmWidth/$CmHeight;
			$square = round((($CmWidth*$CmHeight)/10000),2);

			// перевод массива в строку
			$sp_mas = array();
			$sp_mas[] = $CmWidth;
			$sp_mas[].= $CmHeight;
			$str = implode(", ",$sp_mas); // максимальные размеры изображения в см, записанные в строке для ввывод в поле full_size
		?>
		<div style="background:#E2E3C2;padding:5px 3px;">
			<table width="100%">
				<tr>
					<td style="width:150px;">
                        <span style="margin-right: 7px;">width: </span>
						<input class="input-your-size"  type="text" id="input_crop_width" size="5" value="<?php echo $CmWidth;?>" onchange="ChangeSq();"/> Cm</br></br><!-- CheckBoundarySizeWidth( Math.ceil( document.getElementById('input_crop_width').value  ))-->
                                                <span><?=$lang == '/ua' ? 'висота' : 'height' ;?>: </span>
						<input class="input-your-size"  type="text" id="input_crop_height" size="5" value="<?php echo $CmHeight;?>" onchange="ChangeSq(); "/> Cm<!--CheckBoundarySizeHeight( Math.ceil( document.getElementById('input_crop_height').value  ))-->
                                        
                                        </td>
					<td style=" text-align: right;">
						<span class="square">
                                                <?=$lang == '/ua' ? 'кількість смуг' : 'number of lanes' ;?>:
                                                <span id="pieces-wallpaper">0</span>
                                                </span>
					</td>
					<td style="text-align:right;">
						<span class="square">
							<?=$lang == '/ua' ? 'площа' : 'square' ;?>: 
							<span id="square"><?php echo $square?></span> m.
						</span>
					</td>
				</tr>
			</table>
		</div>

		<form method="post" action="/order" enctype="multipart/form-data" id="order_img">
			<div class="your-select" style="padding:5px;background:#EDEDD7;">
				<h4 style="text-align:center;padding:0 0 2px;border-bottom:1px solid #DFDFBC;"><?=$lang == '/ua' ? 'Замовити розрахунок вартості фотошпалер:' : 'Calculating the cost:' ;?></h4>
				<style>
				.result{margin:5px 0 10px;border:1px solid #EDEDD7;border-collapse:collapse;font-size:11px;background:#DFDFBC;}
				.result td{padding:5px 10px;border:1px solid #EDEDD7;}
				</style>
				
				<table class="result" style="float:right;margin:0;">
					<tr>
						<td>
							<b>lacquering: </b>
						</td>
						<td>
							<label>
								<?=$lang == '/ua' ? 'так' : 'yes' ;?>
								<input style="margin:0 10px 0 2px;vertical-align:middle" type="radio" name="lak" value="1">
							</label>
							<label>
								<?=$lang == '/ua' ? 'ні' : 'no' ;?>
								<input style="margin:0 10px 0 2px;vertical-align:middle" type="radio" name="lak" value="0" checked>
							</label>
						</td>
					</tr>
				</table>

				<table class="result">
					<tr>
						<td style="text-align:right;">
							<b>texture:</b>
						</td>
						<td>
							<span id="your-textura" ></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">
							<b><?=$lang == '/ua' ? 'вид друку' : 'print type' ;?>:</b>
						</td>
						<td>
							<table style="text-align:center;">
								<tr>
									<td style="width:33%;border:0;">
										<label>
											<input type="radio" value="lat" name="print" checked>
											<br>
											Latex
										</label>
									</td>
									<td style="width:33%;border:0;">
										<label>
											<input type="radio" value="uf" name="print">
											<br>
											UV
										</label>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--<tr>
						<td style="text-align:right;">
							<b><?=$lang == '/ua' ? 'дзеркало' : 'зеркало' ;?>:</b>
						</td>
						<td>
							<span id="your-flip"><?=$lang == '/ua' ? 'ні' : 'no' ;?></span>
						</td>
					</tr>-->
					<tr style="color:#fff;background:#666;">
						<td style="text-align:right;font-size:20px;">
							<?=$lang == '/ua' ? 'Вартість' : 'Cost' ;?>: 
						</td>
						<td style="font-size:18px;">
							<span id="_summary">0 <small></small></span>
						</td>
					</tr>
				</table>

			</div>
                        
			<div class="fields" style="background:#ededd7;padding:5px;border-radius:3px;">
				<h4 style="text-align:center;padding:0 0 2px;border-bottom:1px solid #DFDFBC;"><?=$lang == '/ua' ? 'форма замовлення' : 'Form order' ;?>:</h4>
				<input type="hidden" name="num_img" value="<?=$image->id?>"/>
				<input type="hidden" name="full_size" value="<?php echo $str;?>"/>
				<input type="hidden" name="coordinats" id="coordinats" value=""/>
				<input type="hidden" name="lak_"  id="lak__" value="">
                <input type="hidden" name="print1"  id="print__" value="">
				<input type="hidden" name="flip"    id="flip__" value=""/>
				<input type="hidden" name="filter"  id="filter__" value=""/>
				<input type="hidden" name="textura" id="textura__" value=""/>
				<input type="hidden" name="amount" id="amount__" value=""/>
				<style>
				.box_order td{padding:0 0 7px;}
				.form-at-crop{border:1px solid #E1E1B6;border-radius:2px;padding:0 3px;line-height:20px;width:350px;height:20px;}
				.form-at-crop:focus{border-color:#9F9F78;box-shadow:0 0 5px #9F9F78;}
                                #i-am-robot{display: none;}
				</style>
				<?php 
                    require_once '_form.php';
                ?>
			</div>
		</form>

		<div id="dhtmlgoodies_xpPane" style="clear:both;">
			<div class="dhtmlgoodies_panel">
				<form>
					<input type="hidden" id="input_image_ref" value="<?= $image->preview->url; ?>">
					<input type="hidden" class="textInput" name="crop_x" id="input_crop_x">
					<input type="hidden" class="textInput" name="crop_y" id="input_crop_y">
					<input type="hidden" class="textInput" name="crop_width" id="crop_width" >
					<input type="hidden" class="textInput" name="crop_height" id="crop_height">
					<input type="hidden" class="textInput" name="crop_percent_size" id="crop_percent_size" value="100">
					<div id="crop_progressBar"></div>
				</form>
			</div>

			<div class="dhtmlgoodies_panel1" style="visibility:hidden;">
				<div>Dimension: <span id="label_dimension"></span></div>
			</div>

		</div>

	</div>

	<div  style="float:right;width:205px;margin:10px 0 0 0;padding:0 0 0 7px;border-left:1px solid #dfdfbc;overflow:hidden;position:relative;">
            <div id="parent_box_textura" style="width:430px;overflow:hidden;position: relative">
			<style>
			.box_textura{width:205px;float:left;}
			.textura{display:inline-block;position:relative;margin:0 0 5px;color:#808165;font-size:0;}
			.textura img{border:1px solid #888875;}
			.name_textura{display:block;line-height:20px;font-size:12px !important;}
			.print{position:absolute;bottom:5px;left:2px;}
			.print span{font-size:10px;color:#000;dispaly:block;}
			.textura:hover{background:#c9ca99;}
			</style>
			<ul class="box_textura">
			<?php foreach($textura as $k):?>
				<li>
					<a class="textura prev_" onclick="getCountTile(<?=$k->tile_size;?>, this)" name="<?=base_url(); ?>/img/textura/thumb_l_<?=$k->id?>.jpg" data-eco="<?=$k->eco*1?>" data-uf="<?=$k->uf*1?>" data-lat="<?=$k->latex*1?>" data-lak="<?=$k->lak?>" data-kley="<?=$k->kley?>" data-name="<?=$k->name?>" data-id="<?=$k->id?>">
						<span class="name_textura">texture <?=$lang == '/ua' ? $k->name_ua : $k->name ;?></span>
						<img src="<?=base_url(); ?>/img/textura/thumb_m_<?=$k->id?>.jpg"/>
						<!--<span class="_price"></span>
                        <div class="print">
							<?php if($k->eco*1):?>
							<span style="display:block;"><?=$lang == '/ua' ? 'Екосольвентний друк' : 'Экосольвентная печать' ;?>: <?=$k->eco*1?> </span>
							<?php endif;?>
							
							<?php if($k->latex*1):?>
							<span style="display:block;"><?=$lang == '/ua' ? 'Латексний друк' : 'Латексная печать' ;?>: <?=$k->latex*1?> </span>
							<?php endif;?>
							
							<?php if($k->uf*1):?>
							<span style="display:block;"><?=$lang == '/ua' ? 'УФ друк' : 'УФ печать' ;?>: <?=$k->uf*1?> </span>
							<?php endif;?>
						</div>-->
					</a>
				</li>
			<?php endforeach;?>
			</ul>
			<style>
			._price{
				position:absolute;
				bottom:5px;
				left:5px;
				font-size:18px;
				color:#808165;
			}
			</style>
		</div>
	</div>

</div>


<!--=================================================================================================================================================-->

<script type="text/javascript">
init_imageCrop();
</script>

<script type="text/javascript">
$(document).ready(function(){
	Textura.init()
	form.init()
        setTimeout(function(){
            $('#dataNonValid').hide(1000, function(){
                $.ajax({
                    url:'/ajax/unsetNotification',
                    type: 'HEAD'
                });
            });
        }, 5000);
});

var Textura = {
	img:null,
	flag:false,
	all:$('.textura'),
	textura:null,
	data:{article:'',name:'<span style="color:#ff6000;"><b>'+ (window.lang == '/ua' ? 'виберіть текстуру' : 'Select the texture') +'</b></span>',lak:0,kley:0,eco:0,lat:0,uf:0,flip:'',filter:'', id:0},
	filter:$('a[data-filter]'),
	print:0,
	lak:0,
    kley:0,
    id:0,
	name:$('#your-textura'),
	load:'<div id="pre_post" style="position:absolute;zIndex:100000;background:#fff;opacity:0.5;top:0;bottom:0;right:0;left:0;"><table style="width:100%;height:100%;"><tr><td valign="center" align="center"><img src="<?=base_url(); ?>/img/i/loading.gif"></td></tr></table></div>',
	
	valid:function(){
		//название печати
		Textura.print = $(':radio[name=print]:checked').val()
		
		//открываем все текстуры
		this.all.css({display:'inline-block'})
		//прячем те в которых нет печати
		this.all.each(function(i){
			if(!($(this).attr('data-'+Textura.print)*1)){
				if($(this).hasClass('checked')){
					Textura.textura = null; 

					Textura.data.name = '<span style="color:#ff6000;"><b>'+ (window.lang == '/ua' ? 'виберіть текстуру' : 'Select the texture') +'</b></span>'
					Textura.data.lak = 0
					Textura.data.kley = 0
					Textura.data.eco = 0
					Textura.data.lat = 0
					Textura.data.uf = 0
					Textura.data.id = 0
				};
				$(this).css({display:'none'})
				$(this).removeClass('checked')
			}
		})
		
		//пишем название текстуры
		this.name.html(this.data.name) 

		//проверка на лак
		if(!(this.data.lak*1)){
			$(':radio[name=lak]').attr('disabled','disabled')
			$(':radio[name=lak]').eq(1).attr('checked','checked')
		}else{
			$(':radio[name=lak]').attr('disabled','')
		}
		
		//проверка на клей
		if(!(this.data.kley*1)){
			$(':radio[name=kley]').attr('disabled','disabled')
			$(':radio[name=kley]').eq(1).attr('checked','checked')
		}else{
			$(':radio[name=kley]').attr('disabled','')
		}

		this.summa()
	},
	
	summa:function(){
		if(!this.textura){
			$('#_summary').html('0 $.');
			$('#amount__').val(0);
			return
		}
	
		var width = $('#input_crop_width').val()
		var height = $('#input_crop_height').val()
		var sq = ((1*(((width * height)/10000).toFixed(3)))+0.001).toFixed(2);
		
		//площадь
		sq = sq < 1 ? 1: sq*1;
		
		//стоимоть полотна
		var p = this.textura.attr('data-'+Textura.print)*1;
		p = p*sq;
		
		//стоимость лака
		if(($(':radio[name=lak]:checked').val()*1) == 1){
			var l = this.textura.attr('data-lak')*1;
			l = sq*l;
		}else{
			var l = 0;
		}
		
		//стоимость клея
        if(($(':radio[name=kley]:checked').val()*1) == 1){
                        var s = Math.floor(sq/10); //round(sq/10)
			var k = this.textura.attr('data-kley')*1;
                        var price_glue = k;
                        if( s > 0 )
                        {
                            for( var sq_m = 0; sq_m < s; sq_m++ )
                            {
                                k += price_glue;console.log(k);
                            } 
                        }
                        
		}else{
			var k = 0;
		}
		
		//вся сумма
		var sum = (p+l+k).toFixed(2);
		
		$('#_summary').html(sum.replace(".",",") +' $.')
		$('#amount__').val(sum);
	},
	
	/*getImg:function(){
		this.flag = true
		$('#imageContainer').append(this.load)
		
		var fl = this.data.flip == 'flip' ? 1: 0;
		var obj = {
			color   : this.data.filter,
			flip    : fl,
			img     : this.data.article,
			textura : (this.textura ? this.textura.attr('data-id') : 0)
		};
		var req = $.toJSON(obj)
		
		$.post('/ajax/crop_process',{process:req},function(data){
			var i = $('<img>')
			i.load(function(){
				Textura.img.attr('src',data)
				$('#pre_post').remove();
				Textura.flag = false
			})
			i.attr('src',data)
		}, 'json')
	},*/
	
	init:function(){
		/*---------------------------------------определяем артикул*/
		this.img = $('#_img_')
		this.data.article = this.img.attr('title')
		
		/*---------------------------------------вид печати*/
		$(':radio[name=print]').click(function(){
			Textura.valid()
		})
		
		/*---------------------------------------текстура*/
		this.all.click(function(){
			if(Textura.flag) return
			
			Textura.textura = $(this)
			Textura.data.name = $(this).attr('data-name')
			Textura.data.lak  = $(this).attr('data-lak')
			Textura.data.kley = $(this).attr('data-kley')
			Textura.data.eco  = $(this).attr('data-eco')
			Textura.data.lat  = $(this).attr('data-lat')
			Textura.data.uf   = $(this).attr('data-uf')
			Textura.data.id   = $(this).attr('data-id')
			
			if(!$(this).hasClass('checked')){
				//Textura.getImg()
			}
			Textura.all.removeClass('checked')
			Textura.textura.addClass('checked')
			Textura.valid()
		})
		
		/*---------------------------------------лак*/
		$(':radio[name=lak]').click(function(){
			Textura.lak = $(this).val()
			Textura.valid()
		})
        
        /*---------------------------------------glue*/
        $(':radio[name=kley]').click(function(){
			Textura.kley = $(this).val()
			Textura.valid()
		})
		
		/*---------------------------------------фильтры*/
		this.filter.click(function(){
			if(Textura.flag) return
		
			if($(this).hasClass('checked')){
				$(this).removeClass('checked')
				var sl = window.lang == '/ua' ? 'ні' : 'no';
				if($(this).hasClass('cl')){
					Textura.data.filter = ''
					$('#your-filter').html(sl)
				}else{
					Textura.data.flip = ''
					$('#your-flip').html(sl)
				}
			}else{
				var sl = $(this).text();//'/ua' ? 'так' : 'да';
				if($(this).hasClass('cl')){
					$('.cl').removeClass('checked')
					Textura.data.filter = $(this).attr('id')
					$('#your-filter').html(sl)
				}else{
					Textura.data.flip = $(this).attr('id')
					$('#your-flip').html(sl)
				}
				$(this).addClass('checked')
			}
                        
                        //list of filters that are selected
                        var filters = '';
                        var siblings = $('a[data-filter]');
                        siblings.each(function() {
                            if( $(this).hasClass('checked') ) {
                                filters+= $(this).text();
                                filters+= ', ';
                            }
                        });
                        filters = filters.substr(0, filters.length - 2);
                        
                        if( filters != '' ) {
                            $('#your-filter').text(filters);
                        } else {
                            $('#your-filter').text( window.lang == '/ua' ? 'ні' : 'no' );
                        }
                        
                        
			Textura.valid()
			Textura.getImg()
		})
		
		this.valid()
	}
};

var form = {
	inputs:null,
	p:{eco:'экосольвент',lat:'latex',uf:'UV'},
	init:function(){
		this.inputs = $('.form-at-crop')
		
		$('#order_img').submit(function(e){
			var isError=false;
			form.inputs.css({borderColor:'',boxShadow:''});

			// имя
			var name=$('input[name=name]'),
				nParts=$.trim(name.val()).replace(/( ){2,}/ig,' ').split(' ');
			if (nParts.length < 2){
				name.css({borderColor:'red',boxShadow:'0 0 5px #ff8c8c'});
				isError=true;
			}

			// телефон
            var reg = /^\([0-9]{3,4}\)\s*[0-9]{3}-[0-9]{2}-[0-9]{2}$/ig;
			var phone = $('input[name=phone]'),
				phoneVal=phone.val().replace(/[^0-9]/ig,'');
			if (phoneVal.length < 7 || phoneVal.length > 19){
				phone.css({borderColor:'red',boxShadow:'0 0 5px #ff8c8c'});
				isError=true;
			}

			// email
			var rxTxt="^[a-z0-9\._-]+@(([a-z0-9-]+\.)+([a-z]{2,})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$",
	            rx=new RegExp(rxTxt,'gi'),
	            email = $('input[name=email]'),
				emailVal=$.trim(email.val());
        	if (!rx.test($.trim(emailVal))) {
        		email.css({borderColor:'red',boxShadow:'0 0 5px #ff8c8c'});
				isError=true;
        	}

                        
			var f = Textura.data.flip == 'flip' ? 1: 0;
			$('#lak__').val(Textura.data.lak)
			$('#print__').val(form.p[Textura.print])
			$('#flip__').val(f)
			$('#filter__').val($('#your-filter').text());
			//$('#textura__').val(Textura.data.name)
			$('#textura__').val(Textura.data.id)
			
			if(!Textura.textura ){
				var t = window.lang == '/ua' ? 'Ви не обрали текстуру' : 'Вы не выбрали текстуру';
				alert(t)
				isError=true;
			}

			return !isError;
		});
	}
}
</script>

</section>