<?php
if (!isset($a))
    $a = $this->a;
if (!isset($x))
    $x = $this->x;
$forest = $a->getForest();
?>
<!-- main -->
			<div id="main">	
                            <div id="breadcrumb">
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco Boschi</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $forest->getData('objectid');?>">Elenco Particelle</a>
                            </div>
				<div class="post">
                                <script type="text/javascript" >
                                document.getElementById("tabrelatedcss").href="css/rilievidendrometrici.css";
                                </script>
                                        <div id="tabContent">
                                    <form id="formX" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formx&amp;forma_id=<?php echo $a->getData('objectid');?>&amp;id=<?php echo $x->getData('objectid');?>">
                                        <div class="form_messages formx_errors" style="display: none;"></div>
                                        <fieldset id="selector">
                                        <div id="bosco_container">
                                            <label for="bosco">Bosco</label>
                                            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
                                        </div>
                                        <div id="cod_part_container">
                                            <label for="cod_part">Particella / sottoparticella</label>
                                            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
                                        </div>
                                        <div id="tipo_ril_container">
                                            <label for="tipo_ril">Tipo di rilevo</label>
                                            <select id="tipo_ril" name="tipo_ril">
                                                <option value="">Scegli un tipo di rilievo</option>
                                                <?php
                                                $relivetypecoll = new \forest\attribute\ReliveTypeColl();
                                                $relivetypecoll->loadAll();
                                                foreach($relivetypecoll->getItems() as $relivetype) : ?>
                                                <option value="<?php echo $relivetype->getData('codice'); ?>"><?php echo $relivetype->getData('descrizion'); ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div id="data_container">
                                            <label for="data">Data</label>
                                            <input id="data" name="data" value="<?php echo $x->getData('data');?>">
                                        </div>
                                        </fieldset>
                                        <fieldset id="content_rilievidendrometrici_edit">
                                        <?php require __DIR__.DIRECTORY_SEPARATOR.'edit_ird.php';?>
                                        </fieldset>
                                    </form>
                                        <script type="text/javascript" src="js/rilievidendrometrici.js" defer="defer"></script>
                                </div>
                                <!-- /post -->	
				</div>	
                        <!-- /main -->	
			</div>