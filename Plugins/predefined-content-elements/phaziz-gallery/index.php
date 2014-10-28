<?php require_once '../../../Config/constructr.conf.php'; ?>
<input type="hidden" name="phaziz-gallery" value="phaziz-gallery">
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
    	<strong><small>Alle Bilder im Verzeichnis Uploads:</small></strong>
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
		<strong><small>Galerie-Code für das Inhaltselement:</small></strong>
		<textarea class="form-control" rows="10" cols="100" name="content" id="content"></textarea>
    </div>
</div>

<div class="form-group">
    <label for="cleaner" class="col-sm-2 control-label">&#160;</label>
    <div class="col-sm-10">
        <button id="cleaner" name="cleaner" class="btn btn-info btn-sm">Neuen vordefinierten Inhalt speichern</button>
    </div>
</div>

<script type="text/javascript">

	$('#cleaner').click(function(){
		var CONTENT = $('#content').html();
		if(CONTENT != '')
		{
			$('#content').html('<ul>' + CONTENT + '</ul>');
			return true	
		}
		else
		{
			return false;
		}
	});

	$("head link[rel='stylesheet']").last().after("<style>.img:hover,.img-del:hover{cursor:pointer;}</style>");

	String.prototype.str_replace = function(search, replace)
	{
	    return this.split(search).join(replace);
	}

	$('.img').bind('click', function()
		{
			var E = $(this).html().replace('<br>','');
			$('#content').html($('#content').html() + '<li><img src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Uploads/' + E + '" alt="gal-img"></li>');
		}
	);

</script>