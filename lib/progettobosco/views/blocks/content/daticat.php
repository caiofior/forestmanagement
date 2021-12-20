<!-- main -->
<div id="main">	
    <div id="breadcrumb">
        <a href="<?php echo $GLOBALS['BASE_URL']; ?>">Home</a> &gt;
        <a href="<?php echo $GLOBALS['BASE_URL']; ?>bosco.php">Elenco Boschi</a> &gt;
        <a href="<?php echo $GLOBALS['BASE_URL']; ?>bosco.php?action=manage&amp;id=<?php echo $this->forest->getData('codice'); ?>">Elenco Particelle</a>
    </div>
    <div class="post">
        <?php $profile = $this->user->getProfile(); ?>
        <h2>Dati catastali</h2>
        <p>Regione <?php echo $this->forest->getRegion()->getData('descriz');?><br />
        Sistema informativo per l'assestamento forestale</p>
        <p>Procedura per<br/>
        GESTIONE DATI CATASTALI</p>
        <p>Bosco: <?php echo $this->forest->getData('descrizion');?> </p>
        
        <a class="addcadastral" style="display: none;" href="#">
            <img class="actions addnew" src="images/empty.png" title="Aggiungi una particella"/>
        </a>
        <p class="no-border">
        <a class="button vercalc" href="<?php echo $GLOBALS['BASE_URL']; ?>daticat.php?action=vercalc&id=<?php echo $this->forest->getData('codice'); ?>">Calcola/Verifica dati</a>
            </p>
        <p class="no-border">
        <a class="button surfacerecalc" href="<?php echo $GLOBALS['BASE_URL']; ?>daticat.php?action=surfacerecalc&id=<?php echo $this->forest->getData('codice'); ?>">Aggiorna superficie totale</a>
        </p>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="cadastral" data-objectid="<?php echo $this->forest->getData('codice'); ?>">
            <thead>
                <tr>
                    <th colspan="13">Particella catastale</th>
                    <th colspan="10">Particella forestale</th>
                    <th >&nbsp;</th>
                </tr>
                <tr>
                    <th colspan="13">&nbsp;</th>
                    <th colspan="8">Improduttivi inclusi non cartografati</th>
                    <th colspan="2">Produttivi non boscati inclusi non cartografati</th>
                    <th >&nbsp;</th>
                </tr>
                <tr>
                    <th >Id</th>
                    <th >Foglio</th>
                    <th >Particella</th>
                    <th >Superficie totale particella catastale</th>
                    <th >Sup. afferente alla particella forestale (ha)</th>
                    <th >di cui boscata (ha)</th>
                    <th >Non boscata (ha)</th>
                    <th >Somma non boscata (ha)</th>
                    <th >% afferente</th>
                    <th >Note</th>
                    <th >Particella</th>
                    <th> Superficie particella forestale (ha)</th>
                    <th> Somma inclusi improdut. + produt. (ha)</th>
                    <th> Superficie (ha)</th>
                    <th> Superficie (%)</th>
                    <th> Rocce</th>
                    <th> Acque</th>
                    <th> Strade</th>
                    <th> Viali tagliafuoco</th>
                    <th> Altri fattori</th>
                    <th> Specifica</th>
                    <th> Superficie (ha)</th>
                    <th> Superficie (%)</th>
                    <th> Azioni</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="24" class="dataTables_empty">Caricamento dei dati</td>
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
                    <th >Somma non boscata (ha)</th>
                    <th >% afferente</th>
                    <th >Note</th>
                    <th >Particella</th>
                    <th> Superficie particella forestale (ha)</th>
                    <th> Somma inclusi improdut. + produt. (ha)</th>
                    <th> Superficie (ha)</th>
                    <th> Superficie (%)</th>
                    <th> Rocce</th>
                    <th> Acque</th>
                    <th> Strade</th>
                    <th> Viali tagliafuoco</th>
                    <th> Altri fattori</th>
                    <th> Specifica</th>
                    <th> Superficie (ha)</th>
                    <th> Superficie (%)</th>
                    <th> Azioni</th>
                </tr>
                <tr>
                    <th colspan="13">&nbsp;</th>
                    <th colspan="8">Improduttivi inclusi non cartografati</th>
                    <th colspan="2">Produttivi non boscati inclusi non cartografati</th>
                    <th colspan=>&nbsp;</th>
                </tr>
                <tr>
                    <th colspan="13">Particella catastale</th>
                    <th colspan="10">Particella forestale</th>
                    <th >&nbsp;</th>
                </tr>
            </tfoot>
        </table>
        
        <!-- /post -->	
    </div>	

    <!-- /main -->	
</div>

	

