                                        <fieldset id="s<?php echo $_REQUEST['sequence']; ?>">
                                        <a class="remove_filter" href="#">Rimuovi</a><br/>
                                        <?php
                                        if (!isset($forest))
                                            $forest=$this->forest;
                                        ?>
                                        <br/>
                                        <label for="parameter<?php echo $_REQUEST['sequence']; ?>">Parametro</label>
                                        <select class="large parameter" id="parameter<?php echo $_REQUEST['sequence']; ?>" name="parameter[]"  >
                                            <option value="">Seleziona una parametro</option>
                                            <?php 
                                                $archivecoll = $forest->getACollFiltering();
                                                foreach($archivecoll as $archive) : ?>
                                            <option  value="<?php echo $archive['id'];?>"><?php echo $archive['archivio'];?> - <?php echo $archive['intesta'];?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        <br />
                                        <label for="operator<?php echo $_REQUEST['sequence']; ?>">Operatore</label>
                                        <select class="large operator" id="operator<?php echo $_REQUEST['sequence']; ?>" name="operator[]"   >
                                            <option value="">Seleziona una'operatore</option>
                                            <?php 
                                                $operatorcoll = new \forest\template\ControlColl('operator');
                                                $operatorcoll->loadAll();
                                                foreach($operatorcoll->getItems() as $operator) : ?>
                                            <option  value="<?php echo $operator->getData('codice');?>"><?php echo $operator->getData('descriz');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        <br />
                                        <label for="value<?php echo $_REQUEST['sequence']; ?>">Valore</label>
                                        <input class="large value" id="value<?php echo $_REQUEST['sequence']; ?>" name="value[]"   >
                                        </fieldset>