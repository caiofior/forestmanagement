<?php

                $menu = array(
		'bosco.php' => 'Bosco' ,
		'descrp.php' => 'Descrizione Particellare' ,
		'daticat.php' => 'Dati Catastali',
		'rildend.php' => 'Rilievi Dendrometrici',
		'tavole.php' => 'Tavole Cubatura',
		'viabilita.php' => 'Descrizioni Viabilità',
		'#1' => 'Descrizioni Particellari',
		'#2' => 'Classi Colturali',
		'dizionari.php' => 'Dizionari',
		'#4' => 'Dati Catastali',
		'#5' => 'Strumenti',
		'#6' => 'Elaborazioni Dati Dendro',
		'#8' => 'Piano interventi',
		'#9' => 'Decodifica Schede',
		'#10' => 'Gestione Stampe',
                );

?>
		<ul id='navigatio_bar'>
                    <?php 
		foreach( $menu as $tag => $text ) :
			$extra_class = (
                            isset($this->controler) &&
                            $this->controler == $tag ) ? "nav_bar_selected" : "nav_bar" ;
                ?>
			<li><a class='<?php echo $extra_class; ?>' href="<?php echo $tag; ?>"><?php echo $text; ?></a></li>
		<?php endforeach; ?>
		</ul>
