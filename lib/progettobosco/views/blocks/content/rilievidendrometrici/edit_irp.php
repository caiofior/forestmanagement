<?php
$g1coll = $x->getG1Coll();
$g1coll->loadAll();
if($g1coll->count() == 0)
    $g1 = $g1coll->addItem();
else
    $g1 = $g1coll->getFirst();
?>
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/irp.css";
</script>
<fieldset>
<div id="data_container">
    <label for="data">Data</label>
    <input readonly="readonly" id="data" name="data" value="<?php echo $x->getData('data');?>">
</div>
<p >Schede G per il rilievo dendrometrico (IRP) con<br/>applicazione delle TAVOLE DI POPOLAMENTO</p>
<div id="fatt_num_container">
    <label for="fatt_num">Fattore di numerazione</label>
    <input id="fatt_num" name="fatt_num" value="<?php echo $g1->getData('fatt_num');?>">
</div>
<div id="codiope_container">
    <label for="codiope">Rilevatore</label>
    <input type="hidden" id="codiope" name="codiope" value="<?php echo $g1->getData('codiope');?>"/>
    <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $g1->getCollector()->getData('descriz');?>"/>
</div>
<div id="d_ogni_container">
    <label for="d_ogni">È stato misurato un diametro ogni:</label>
    <input id="d_ogni" name="d_ogni" value="<?php echo $g1->getData('d_ogni');?>">
</div>
<fieldset id="irp_table_container" >
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="irp" data-objectid="<?php echo $g1->getData('objectid'); ?>">
            <thead>
                <tr>
                    <th >Id</th>
                    <th >N° AdS</th>
                    <th >N° Alberi Contati</th>
                    <th >H1</th>
                    <th >H2</th>
                    <th >H3</th>
                    <th >H4</th>
                    <th >H5</th>
                    <th >D1</th>
                    <th >D2</th>
                    <th >D3</th>
                    <th> D4</th>
                    <th> D5</th>
                    <th> D6</th>
                    <th> D7</th>
                    <th> Azioni</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="16" class="dataTables_empty">Caricamento dei dati</td>
                </tr>
            </tbody>
            <tfoot>
                                <tr>
                    <th >Id</th>
                    <th >N° AdS</th>
                    <th >N° Alberi Contati</th>
                    <th >H1</th>
                    <th >H2</th>
                    <th >H3</th>
                    <th >H4</th>
                    <th >H5</th>
                    <th >D1</th>
                    <th >D2</th>
                    <th >D3</th>
                    <th> D4</th>
                    <th> D5</th>
                    <th> D6</th>
                    <th> D7</th>
                    <th> Azioni</th>
                </tr>
            </tfoot>
        </table>
</fieldset>
</fieldset>
<script type="text/javascript" src="js/irp.js" defer="defer"></script>