<p>
    Come noto è possibile inserire i dati catastali attraverso due percorsi,<br/>
    il primo direttamente in Scheda A consente di inserire i dati lavorando<br/>
    sulla singola particella forestale, il secondo attraverso la voce di menu<br/>
    "Dati catstali" consente di inserire i dati di tutte le particelle forestali<br/>
    contemporaneamente.<br/>
    Di seguito sono riportate due immagini estratte rispettivamente dalla Scheda A<br/>
    e dalla maschera Dati catastali. La prima immagine si<br/>
    riferisce alla prima versione per la gestione dei dati catastali in<br/>
    <?php echo $GLOBALS['SITE_NAME']; ?>, mentre al momento state utilizzando la seconda versione.
</p>
<img src="images/daticat/forma.png">
<img src="images/daticat/daticat.png">
<p>
    Con particolare riferimento alle parti riquadrate in rosso e poiché questa<br/>
    impostazione non era sufficientemente chiara essa è stata modificata come segue
</p>
<p>
    Elemento di confusione è stata la definizione "Sup. totale afferente alla<br/>
    particella (ha)" con cui si intendeva la misura in ha della porzione di<br/>
    particella catastale afferente alla particella forestale mentre in alcuni<br/>
    casi è stata inserita la superficie totale della particella catstale.<br/>
    Ora la voce "Sup. totale afferente alla particella (ha)"  è stata più<br/>
    chiaramente definita "Sup. afferente alla particella forestale (ha)" ed<br/>
    è stata aggiunta la voce "Sup. totale particella catastale".
</p>
<p>
    La procedura, oltre ad eseguire una serie di controlli sui dati immessi,<br/>
    consente di inserire solo due delle voci  "Sup. totale particella catastale",<br/>
    "Sup. afferente alla particella forestale (ha)" e "% afferente" e calcolare<br/>
    automaticamente la terza.<br/>
    Considerato che, come detto, vi è stato un elemento di confusione che ha portato<br/>
    alcuni utilizzatori di <?php echo $GLOBALS['SITE_NAME']; ?> ad inserire alla voce "Sup. totale afferente<br/>
    alla particella (ha)" la superficie totale della particella catastale, prima di<br/>
    avviare la procedura di calcolo è necessario indicare se tale evento si è verificato oppure no.
</p>
<p>
     Alla voce "Sup. totale afferente alla particella (ha)"  è stata inserita:
</p>
<form method="post" id="vercalcform" action="<?php echo $GLOBALS['BASE_URL']; ?>daticat.php?action=vercalc&id=<?php echo $forest->getData('objectid');?>&confirmed=1">
    <div id="vercalcerror" style="display: none;"></div>
    <select id="method" name="method">
        <option value=""></option>
        <option value="1">Sup afferente alla particella forestale</option>
        <option value="2">Sup totale particella catastale</option>
    </select>
    <input type="submit" name="confirmed" value="Verifica/calcola i dati catastali">
</form>
<p>
    N.B. l'opzione "Sup totale particella catastale" deve essere scelta solo la prima <br/>
    volta che si esegue l'elaborazione dati catastali dopo il passaggio dalla prima versione<br/>
    per la gestione dei dati catastali in <?php echo $GLOBALS['SITE_NAME']; ?>, alla seconda versione, ovvero questa<br/>
    che state utilizzando in questo momento
</p>