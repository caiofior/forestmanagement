<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/forma.css";
</script>
    <div id="tabContent">
    <form id="formA" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forma&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages forma_errors" style="display: none;"></div>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $a->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="codiope_container">
            <label for="codiope">Rilevatore</label>
            <input type="hidden" id="codiope" name="codiope" value="<?php echo $a->getData('codiope');?>"/>
            <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $a->getCollector()->getData('descriz');?>"/>
        </div>
        <div id="datasch_container">
            <label for="datasch">Data del rilievo</label>
            <input id="datasch" name="datasch" value="<?php echo $a->getData('datasch');?>">
        </div>
        <div id="note_1">
            <h3 >Fattori ambientali e di gestione</h3>
        </div>
        <div id="sup_tot_container">
            <label for="sup_tot">Superficie totale (ha)</label>
            <input id="sup_tot" name="sup_tot" value="<?php echo $a->getData('sup_tot');?>"><br/>
        </div>
        <div id="boscata_calcolo_container">
            <label for="boscata_calcolo">Superficie boscata (ha)</label>
            <input id="boscata_calcolo" name="boscata_calcolo" value="<?php echo $a->getRawData('boscata_calcolo');?>"><br/>
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella / sottoparticella</label>
            <input id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        <div id="comune_container">
            <label for="comune" class="double">Comune</label>
            <input type="hidden" id="comune" name="comune" value="<?php echo $a->getData('comune');?>">
            <input data-old-descriz="<?php echo $a->getMunicipality()->getData('descriz');?> (<?php echo $a->getMunicipality()->getRawData('province_code');?>)" id="comune_descriz" name="comune_descriz" value="<?php echo $a->getMunicipality()->getData('descriz');?> (<?php echo $a->getMunicipality()->getRawData('province_code');?>)">
        </div>
        <div id="ap_container">
            <label for="ap">Altitudine prevalente (m)</label>
            <input id="ap" name="ap" value="<?php echo $a->getData('ap');?>">
        </div>
        <div id="improduttivi_calcolo_container">
            <label for="improduttivi_calcolo">Improduttivi (ha)</label>
            <input readonly="readonly" id="improduttivi_calcolo" name="improduttivi_calcolo" value="<?php echo $a->getRawData('improduttivi_calcolo');?>">
        </div>
        <div id="prod_non_bosc_calcolo_container">
            <label for="prod_non_bosc_calcolo">Produttivi non boscati (ha)</label>
            <input readonly="readonly" id="prod_non_bosc_calcolo" name="prod_non_bosc_calcolo" value="<?php echo $a->getRawData('prod_non_bosc_calcolo');?>">
        </div>
        <div id="toponimo_container">
            <label for="toponimo" class="double">Nome del luogo</label>
            <input id="toponimo" name="toponimo" value="<?php echo $a->getData('toponimo');?>">
        </div>
        <div id="pp_container">
            <label for="pp">Pendenza prevalente (%)</label>
            <input id="pp" name="pp" value="<?php echo $a->getData('pp');?>">
        </div>
        </fieldset>
        <fieldset id="sub_forest_parcel">
                
        <legend>Sottoparticella</legend>
        <input type="radio" disabled="disabled" name="delimitata" <?php echo ($a->getData('delimitata') == true ? 'checked="checked"' : '')?> value="1">Delimitata<br/>
        <input type="radio" disabled="disabled" name="delimitata" <?php echo ($a->getData('delimitata') != true ? 'checked="checked"' : '')?>value="0">Non delimitata

        <div id ="sup_container">
        <label for="sup">Estesa su (%)</label>
        <input id="sup" name="sup" value="<?php echo $a->getData('sup');?>">
        </div>
        
        </fieldset>
        <fieldset id="pf1container" >
        <legend>Posizione fisiografica prevalente</legend>
        <?php
        foreach($a->getControl('pf1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $a->getData('pf1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="pf1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="pf1_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="acontainer" >
        <legend>Dissesto</legend>
        <div>
        <div >
                <span >&nbsp;</span>
                <span>Assenti</span>
                <span>Pericolo peggioramento</span>
                <span>&lt; 5%</span>
                <span>&lt; 1/3</span>
                <span>&gt; 1/3</span>
                
        </div>
        <div >
                <span ><label for="a2">Erosione superficiale o incanalata</label></span>
                <?php
        foreach($a->getControl('a2')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('a2'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="a2" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
        </div>
        <div >
                <span ><label for="a3">Erosione profonda o calanchiva</label></span>
                <?php
        foreach($a->getControl('a3')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('a2'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="a3" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
        </div>
        <div >
                <span ><label for="a4">Frane superficiali</label></span>
                        <?php
        foreach($a->getControl('a4')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('a4'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="a4" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            <div >
                <span ><label for="a6">Rotolamento massi</label></span>
                <?php
                foreach($a->getControl('a6')->getItems() as $item) :
                $checked = '';
                if ($item->getData('codice') == $a->getData('a6'))
                    $checked = 'checked="checked"';
                ?>
                <span><input type="radio" name="a6" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
                <?php endforeach;?>
            </div>
            <div >
                <span ><label for="a7">Altri fattori di dissesto</label></span>
                <?php
                foreach($a->getControl('a7')->getItems() as $item) :
                $checked = '';
                if ($item->getData('codice') == $a->getData('a7'))
                    $checked = 'checked="checked"';
                ?>
                <span><input type="radio" name="a7" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
                <?php endforeach;?>
            </div>
        </div>
        <div id ="a8_container">
        <label for="a8">Specifica altri fattori</label>
        <input id="a8" name="a8" value="<?php echo $a->getData('a8');?>">
        </div>
        </fieldset>
        <fieldset id="e1container" >
        <legend>Esposizione prevalente</legend>
        <?php
        foreach($a->getControl('e1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $a->getData('e1'))
            $checked = 'checked="checked"';
        ?>
        <div class="e1 <?php echo strtolower($item->getData('descriz')); ?>"><input type="radio" name="e1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>" ><?php echo $item->getData('descriz'); ?></div>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="rcontainer">
            <legend>Limiti allo sviluppo delle radici</legend>
            <div>
                <div >
                    <span >&nbsp;</span>
                    <span>Assenti o limitati</span>
                    <span>&lt; 1/3</span>
                    <span>&lt; 2/3</span>
                    <span>&gt; 2/3</span>
                </div>
                <div>
                    <span><label for="r2">Superficialità terreno</label></span>
                           <?php
        foreach($a->getControl('r2')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r2'))
            $checked = 'checked="checked"';
        ?>
            <span><input type="radio" name="r2" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
                </div>
                <div >
                    <span ><label for="r3">Rocciosità affiorante</label></span>
                            <?php
        foreach($a->getControl('r3')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r3'))
            $checked = 'checked="checked"';
        ?>
            <span><input type="radio" name="r3" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
                </div>
                <div >
                    <span ><label for="r4">Pietrosità</label></span>
                            <?php
        foreach($a->getControl('r4')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r4'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="r4" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
                </div>
                <div >
                    <span ><label for="r5">Ristagno idrico</label></span>
                            <?php
        foreach($a->getControl('r5')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r5'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="r5" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
                </div>
                <div >
                    <span ><label for="r6">Altri fattori limitanti</label></span>
                    <?php
        foreach($a->getControl('r6')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r6'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="r6" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
                </div>
            </div>
         <div id="r7_container">
         <label for="r7">Specificare altre cause</label>
        <input id="r7" name="r7" value="<?php echo $a->getData('r7');?>">
        </div>
        </fieldset>
        <fieldset id="fcontainer">
        <legend>Fattori di alterazione fitosanitaria</legend>
            <div>
            <div >
                <span>&nbsp;</span>
                <span>Assenti</span>
                <span>Pericolo peggioramento</span>
                <span>&lt; 5%</span>
                <span>&lt; 1/3</span>
                <span>&gt; 1/3</span>
            </div>
            <div >
                <span ><label for="f2">Bestiame</label></span>
                <?php
        foreach($a->getControl('f2')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f2'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f2" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            <div >
                <span ><label for="f3">Selvatici</label></span>
                <?php
        foreach($a->getControl('f3')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f3'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f3" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            <div >
            <span ><label for="f4">Patogeni o parassiti</label></span>
            <?php
        foreach($a->getControl('f4')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f4'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f4" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
             <div >
            <span ><label for="f5">Agenti metereologici</label></span>
            <?php
        foreach($a->getControl('f5')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f5'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f5" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
             <div >
            <span ><label for="f6">Movimenti di neve</label></span>
            <?php
        foreach($a->getControl('f6')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f6'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f6" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
             <div >
            <span ><label for="f7">Incendio</label></span>
            <?php
        foreach($a->getControl('f7')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f7'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f7" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            <div >
            <span ><label for="f8">Utilizzazioni o esbosco</label></span>
            <?php
        foreach($a->getControl('f8')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f8'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f8" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            <div >
            <span ><label for="f10">Attività turistico ricreative</label></span>
            <?php
        foreach($a->getControl('f10')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f10'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f10" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            <div >
            <span ><label for="f11">Altre cause</label></span>
            <?php
        foreach($a->getControl('f11')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f11'))
            $checked = 'checked="checked"';
        ?>
        <span><input type="radio" name="f11" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></span>
        <?php endforeach;?>
            </div>
            </div>
         <div id="f12_container">
         <label for="f12">Specificare altre cause</label>
        <input id="f12" name="f12" value="<?php echo $a->getData('f12');?>">
        </div>
        </fieldset>
        <fieldset id="vcontainer">
            <legend>Accessibilità</legend>    
        <div id="v1_container">
            <label for="v1">Insufficiente sul %</label>
            <input readonly="readonly" id="v1" name="v1" value="<?php echo $forest->getData('v1');?>">
        </div>
        <div id="v3_container">
            <label for="v3">Buona sul %</label>
            <input readonly="readonly" id="v3" name="v3" value="<?php echo $forest->getData('v3');?>">
        </div>

        </fieldset>
        <fieldset id="ocontainer" >
        <legend>Ostacoli agli interventi</legend>
        <?php
        foreach($a->getControl('o')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $a->getData('o'))
            $checked = 'checked="checked"';
        ?>
        <span class="o_descr"><?php echo $item->getData('descriz'); ?></span><input type="radio" name="o" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>">
        <?php endforeach;?>
        </fieldset>
        <fieldset id="ccontainer">
            <legend>Condizionamenti eliminabili</legend>
            <div >
                <input type="checkbox" id="c1" name="c1" value="1" <?php echo ($a->getData('c1') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="c1">Nessuno</label>
            </div>
            <div >
                <input type="checkbox" id="c2" name="c2" value="1" <?php echo ($a->getData('c2') == true ? 'checked="checked"' : '') ;?>>
                <label for="c2">Eccesso di pascolo</label>
            </div>            
            <div >
                <input type="checkbox" id="c3" name="c3" value="1" <?php echo ($a->getData('c3') == true ? 'checked="checked"' : '') ;?>>
                <label for="c3">Eccesso di selvatici</label>
            </div>
            <div >
                <input type="checkbox" id="c4" name="c4" value="1" <?php echo ($a->getData('c4') == true ? 'checked="checked"' : '') ;?>>
                <label for="c4">Contestazioni di proprietà</label>
            </div>
            <div >
                <input type="checkbox" id="c5" name="c5" value="1" <?php echo ($a->getData('c5') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="c5">Altre cause</label>
            </div>
            <div >
                <input id="c6" name="c6" value="<?php echo $a->getData('c6');?>">
                <label for="c6">Specifica</label>
            </div>
        </fieldset>
        <fieldset id="pcontainer">
            <legend>Condizionamenti eliminabili</legend>
            <div >
                <input type="checkbox" id="p1" name="p1" value="1" <?php echo ($a->getData('p1') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="p1">Nessuno</label>
            </div>
            <div >
                <input type="checkbox" id="p2" name="p2" value="1" <?php echo ($a->getData('p2') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="p2">Pascolo in bosco</label>
            </div>      
            <div id="p7_container">
            <div id="p7_innercontainer">
            <label for="p7">Specie pascolate</label><br/>
            <?php
            foreach($a->getControl('p7')->getItems() as $item) :
            $checked = '';
            if ($item->getRawData('codice') == $a->getData('p7'))
                $checked = 'checked="checked"';
            ?>
            <span class="p7_descr"><?php echo $item->getData('descriz'); ?></span><input type="radio" name="p7" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><br/>
            <?php endforeach;?>
            </div>
            <div >
                <input id="p9" name="p9" value="<?php echo $a->getData('p9') ;?>">
                <label for="p9">Specifica</label>
            </div>
            </div>  
            <div >
                <input type="checkbox" id="p3" name="p3" value="1" <?php echo ($a->getData('p3') == true ? 'checked="checked"' : '') ;?>>
                <label for="p3">Emergenze storico naturalistiche</label>
            </div>
            <div >
                <input type="checkbox" id="p4" name="p4" value="1" <?php echo ($a->getData('p4') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="p4">Sorgenti fonti</label>
            </div>
            <div >
                <input type="checkbox" id="p5" name="p5" value="1" <?php echo ($a->getData('p5') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="p5">Usi civici</label>
            </div>
            <div >
                <input type="checkbox" id="p6" name="p6" value="1" <?php echo ($a->getData('p6') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="p6">Altri fattori</label>
            </div>
            <div >
                <input id="p8" name="p8" value="<?php echo $a->getData('p8') ;?>">
                <label for="p8">Specifica</label>
            </div>
  
        </fieldset>
        <fieldset id="icontainer">
            <legend>Improduttivi inclusi non cartografati</legend>
            <div >
                <input id="i1" name="i1" value="<?php echo $a->getData('i1') ;?>">
                <label for="i1">Superficie (ha)</label>
            </div>
            <div >
                <input id="i2" name="i2" value="<?php echo $a->getData('i2') ;?>">
                <label class="double" for="i2">Superficie %</label>
            </div>
            <div >
                <input type="checkbox" id="i3" name="i3" value="1" <?php echo ($a->getData('i3') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="i3">Rocce</label>
            </div>
            <div >
                <input type="checkbox" id="i4" name="i4" value="1" <?php echo ($a->getData('i4') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="i4">Acque</label>
            </div>
            <div >
                <input type="checkbox" id="i5" name="i5" value="1" <?php echo ($a->getData('i5') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="i5">Strade</label>
            </div>
            <div >
                <input type="checkbox" id="i6" name="i6" value="1" <?php echo ($a->getData('i6') == true ? 'checked="checked"' : '') ;?>>
                <label  for="i6">Viali tagliafuoco</label>
            </div>
            <div >
                <input type="checkbox" id="i7" name="i7" value="1" <?php echo ($a->getData('i7') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="i7">Altri fattori</label>
            </div>
            <div >
                <input id="i8" name="i8" value="<?php echo $a->getData('i8') ;?>">
                <label class="double" for="i8">Specifica</label>
            </div>
        </fieldset>
        <fieldset id="ibiscontainer">
            <legend>Produttivi non boscati inclusi non cartografati</legend>
            <div >
                <label class="double" for="i21">Superficie (ha)</label>
                <input id="i21" name="i21" value="<?php echo $a->getData('i21') ;?>">
            </div>
            <div >
                <label class="double" for="i2">Superficie (%)</label>
                <input id="i22" name="i22" value="<?php echo $a->getData('i22') ;?>">
            </div>
        </fieldset>
        <fieldset id="mcontainer1">
            <legend>Opere e manufatti</legend>
            <div >
                <input type="checkbox" id="m1" name="m1" value="1" <?php echo ($a->getData('m1') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="m1">Assenti</label>
            </div>
             <div >
                <input type="checkbox" id="m2" name="m2" value="1" <?php echo ($a->getData('m2') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple"  for="m2">Strade camionabili</label>
            </div>
            <div >
                <input type="checkbox" id="m21" name="m21" value="1" <?php echo ($a->getData('m21') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple"  for="m21">Piste camionabili</label>
            </div>
            <div >
                <input type="checkbox" id="m3" name="m3" value="1" <?php echo ($a->getData('m3') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple"  for="m3">Strade trattorabili</label>
            </div>
            <div >
                <input type="checkbox" id="m4" name="m4" value="1" <?php echo ($a->getData('m4') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple"  for="m4">Piste trattorabili</label>
            </div>
            <div >
                <input type="checkbox" id="m22" name="m22" value="1" <?php echo ($a->getData('m22') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m22">Tracciati per mezzi agricoli minori</label>
            </div>
            <div >
                <input type="checkbox" id="m20" name="m20" value="1" <?php echo ($a->getData('m20') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m20">Piazzali o buche di carico</label>
            </div>
            <div >
                <input type="checkbox" id="m5" name="m5" value="1" <?php echo ($a->getData('m5') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple"  for="m5">Edifici</label>
            </div>
            <div >
                <input type="checkbox" id="m6" name="m6" value="1" <?php echo ($a->getData('m6') == true ? 'checked="checked"' : '') ;?>>
                <label class="triple" for="m6">Sistemazioni</label>
            </div>
            </fieldset>
            <fieldset id="mcontainer2">
            <div >
                <input type="checkbox" id="m7" name="m7" value="1" <?php echo ($a->getData('m7') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m7">Gradonamenti</label>
            </div>
            <div >
                <input type="checkbox" id="m8" name="m8" value="1" <?php echo ($a->getData('m8') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="m8">Muri recinti</label>
            </div>
            <div >
                <input type="checkbox" id="m9" name="m9" value="1" <?php echo ($a->getData('m9') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m9">Paravalanghe</label>
            </div>
            <div >
                <input type="checkbox" id="m10" name="m10" value="1" <?php echo ($a->getData('m10') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="m10">Elettrodotti</label>
            </div>
            <div >
                <input type="checkbox" id="m12" name="m12" value="1" <?php echo ($a->getData('m12') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m12">Tracciati teleferiche</label>
            </div>
            <div >
                <input type="checkbox" id="m13" name="m13" value="1" <?php echo ($a->getData('m13') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m13">Condotte idriche</label>
            </div>
            <div >
                <input type="checkbox" id="m15" name="m15" value="1" <?php echo ($a->getData('m15') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="m15">Cave</label>
            </div>
            <div >
                <input type="checkbox" id="m23" name="m23" value="1" <?php echo ($a->getData('m23') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="m23">Aree sosta</label>
            </div>
            <div >
                <input type="checkbox" id="m14" name="m14" value="1" <?php echo ($a->getData('m14') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="m14">Parcheggi</label>
            </div>
            <div >
                <input type="checkbox" id="m16" name="m16" value="1" <?php echo ($a->getData('m16') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m16">Sentieri guidati</label>
            </div>
            <div >
                <input type="checkbox" id="m17" name="m17" value="1" <?php echo ($a->getData('m17') == true ? 'checked="checked"' : '') ;?>>
                <label  for="m17">Impianti sciistici</label>
            </div>
            <div >
                <input type="checkbox" id="m18" name="m18" value="1" <?php echo ($a->getData('m18') == true ? 'checked="checked"' : '') ;?>>
                <label class="double" for="m18">Altre cose</label>
            </div>
            <div >
                <input id="m19" name="m19" value="<?php echo $a->getData('m19') ;?>">
                <label for="m19">Specifica</label>
            </div>
        </fieldset>
        <fieldset id="notescontainer">
        <legend>Note alle singole voci</legend>
        <div id="newnote">
                <div>
                    <span>
                        <div>Parametro</div>
                    </span>
                    <span>
                        <div>Nota</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
                <span>
                    <input type="hidden" id="cod_nota" name="cod_nota" value=""/>
                    <input id="cod_nota_descr" name="cod_nota_descr" value=""/>
                </span>

                <span>
                    <textarea id="text_nota" name="text_nota" rows="2" cols="30"></textarea>
                </span>
                <span>
                    <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forma&action=editnote&id=<?php echo $a->getData('objectid');?>" data-update="content_schedaa_note">
                        <img class="actions addnew" src="images/empty.png" title="Aggiungi una nota"/>
                    </a>
                </span>
            </div>
        </div>
        <?php
        require __DIR__.DIRECTORY_SEPARATOR.'schedaa'.DIRECTORY_SEPARATOR.'note.php';
        ?>
        </fieldset>
        <fieldset class="datatable" id="cadastraldata">
            <legend>Dati catastali</legend>    
                <!--<a class="addcadastral" style="display: none;" href="#">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una particella"/>
                </a>
                <a class="surfacerecalc" style="display: none;" href="#">
                    Aggiorna superficie totale
                </a>-->
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="cadastral">
                    <thead>
                            <tr>
                                    <th >Id</th>
                                    <th >Foglio</th>
                                    <th >Particella</th>
                                    <th >Superficie totale particella catastale</th>
                                    <th >Sup. afferente alla particella forestale (ha)</th>
                                    <th >di cui boscata (ha)</th>
                                    <th >Non boscata (ha)</th>
                                    <th >% afferente</th>
                                    <th >Note</th>
                                    <th >Azioni</th>
                            </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td colspan="10" class="dataTables_empty">Caricamento dei dati</td>
                            </tr>
                    </tbody>
                    <tfoot>
                            <tr>
                                    <th >Id</th>
                                    <th >Foglio</th>
                                    <th >Particella</th>
                                    <th >Superficie totale particella catastale</th>
                                    <th >Sup. afferente alla particella forestale (ha)</th>
                                    <th >di cui boscata (ha)</th>
                                    <th >Non boscata (ha)</th>
                                    <th >% afferente</th>
                                    <th >Note</th>
                                    <th >Azioni</th>
                            </tr>
                            <tr>
                                <th colspan="3" >Totale</th>
                                <th  ><div id="sum_sup_tot_cat"></div></th>
                                <th  ><div id="sum_sup_tot"></div></th>
                                <th  ><div id="sum_sup_bosc"></div></th>
                                <th colspan="4"></th>
                            </tr>
                    </tfoot>
            </table>
         </fieldset>
        <fieldset id="forestnotecontainer">
            <label for="note">Note</label>
            <textarea id="note" name="note" rows="16" cols="30"><?php echo $a->getData('note');?></textarea>
        </fieldset>
        <fieldset id="surfacesummary">
        <div id="sup_tot1_container">
            <label for="sup_tot1">Superficie totale (ha)</label>
            <input readonly="readonly" id="sup_tot1" name="sup_tot1" value="<?php echo $a->getData('sup_tot');?>"><br/>
        </div>
        <div id="boscata_calcolo1_container">
            <label for="boscata_calcolo1">Superficie boscata (ha)</label>
            <input readonly="readonly" id="boscata_calcolo1" name="boscata_calcolo1" value="<?php echo $a->getRawData('boscata_calcolo');?>"><br/>
        </div>
        <div id="improduttivi_calcolo1_container">
            <label for="improduttivi_calcolo1">Improduttivi (ha)</label>
            <input readonly="readonly" id="improduttivi_calcolo1" name="improduttivi_calcolo1" value="<?php echo $a->getRawData('improduttivi_calcolo');?>">
        </div>
        <div id="prod_non_bosc_calcolo1_container">
            <label for="prod_non_bosc_calcolo1">Produttivi non boscati (ha)</label>
            <input readonly="readonly" id="prod_non_bosc_calcolo1" name="prod_non_bosc_calcolo1" value="<?php echo $a->getRawData('prod_non_bosc_calcolo');?>">
        </div>
        <div id="surfacenote">
            <label>N.B. per comodità di lettura sono riportati i dati riepilogativi
            delle superfici particellari</label>
        </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/forma.js" defer="defer"></script>
</div>