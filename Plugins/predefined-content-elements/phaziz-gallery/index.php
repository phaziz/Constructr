<div class="form-group">
<label for="" class="col-sm-2 control-label">&#160;</label>
<div class="col-sm-10">
<br><br>
<small><strong>Mit einem Doppelklick auf ein Bild-Element fügen Sie das Bild der neuen Galerie hinzu.</strong></small>
</div>
</div>
<div class="form-group">
    <label for="new_page_order" class="col-sm-2 control-label">Galerie bearbeiten:</label>
    <div class="col-sm-5">
    	<strong><small>Alle Bilder im Verzeichnis Uploads</small></strong>
    	<br>
    	<br>
    	<div class="image-elements">
<?php 

$_USER_UPLOADS = __DIR__ . '/../../../Uploads/';
$_USER_UPLOADS = scandir($_USER_UPLOADS);

$IMAGE_TYPES = array('.gif','.GIF','.jpg','.JPG','.jpeg','.JPEG','.png','.PNG');

foreach($_USER_UPLOADS AS $_USER_UPLOAD)
{
	$FILE_TYPE = strrchr($_USER_UPLOAD,'.');

if(in_array($FILE_TYPE,$IMAGE_TYPES))
	echo '<span class="img">' . $_USER_UPLOAD . "<br></span>";
}

?>
    	</div>
	</div>
	<div class="col-sm-5">
		<strong><small>Alle Bilder im Galerie-Element auf dieser Seite</small></strong>
		<br>
		<br>
    	<div id="gallery-images">

    	</div>
    </div>
</div>
<style>
.img:hover,.imgage-el:hover{
	cursor:pointer;
}
</style>
<script>

	$('span.img').dblclick(function()
		{
			var H = $('#gallery-images').html();
			var E = $(this).html().replace('<br>','');
			NEW_ELEMENT = '<span class="image-el">' + E + " <a href=\"\" id=\"removr\" onclick=\"javascript:return false;\" title=\"Bild entfernen\">X</a><br></span>";
			var NEW_H = H += NEW_ELEMENT;
			$('#gallery-images').html(NEW_H);
		}
	);

	$('span.image-el').bind('dblclick',function()
		{
		}
	);

</script>