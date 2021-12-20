<form method="post" id="newcodepart" action="bosco.php?action=createforestcompartment&forest_codice=<?php echo $_REQUEST['forest_codice'];?>">
<div class="form_messages new_forma_error" style="display: none;"></div>
<label>Il codice della nuova particella:</label>
<input id="cod_part" name="cod_part" >
<input disabled="disabled" class="button" id="new_forma" name="new_forma" type="submit" value="Crea" />         		
</form>
<script type="text/javascript" src="js/newforma.js" ></script>

