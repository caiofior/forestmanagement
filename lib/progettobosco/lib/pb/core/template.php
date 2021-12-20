<?php
/**
 * Manages templates
 * 
 * Manages templates
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages templates
 * 
 * Manages templates
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Template extends Zend_View {
    /**
     * Render a template block
     * @param string $block_name
     */
    public function renderBlock($block_name) {
        $script_path = $this->getScriptPaths();
        $script_path = array_shift($script_path);
        if(
            key_exists($block_name, $this->blocks) && 
            is_string($this->blocks[$block_name])  && 
            is_file($script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks[$block_name])
        ) 
            require $script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks[$block_name]; 
        else if (
                   key_exists($block_name, $this->blocks) && 
                   is_string($this->blocks[$block_name]) 
                )
                    trigger_error ('Unable to find block '.$script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks[$block_name]);
        else if (
            key_exists($block_name, $this->blocks) && 
            is_array($this->blocks[$block_name])
        )   {
            foreach($this->blocks[$block_name] as $content) {
                if (is_file($script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content))
                    require $script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content; 
                else 
                    trigger_error ('Unable to find block '.$script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content);
                        }
            }
    }
    /**
     * Renders the template
     * @param string $template
     * @return string
     */
    public function render ($template) {
        try{
            $controler = \Controler::getInstance();
            $xhr_files =  $controler::getXhrFiles();
            if (sizeof($xhr_files) > 0) {
                    $response = array();
                    $script_path = $this->getScriptPaths();
                    $script_path = array_shift($script_path).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR;
                    foreach ($xhr_files as  $xhr_files) {
                        $file_path = $script_path.str_replace('_', DIRECTORY_SEPARATOR, $xhr_file).'.php';
                        if (is_file($file_path)) {
                            ob_start();
                            require $file_path;
                            $response[ $value]=  ob_get_clean();
                            }
                    }
                    header('Content-type: application/json');
                    echo Zend_Json::encode($response);
                    exit;
            }
        }
        catch (\Exception $e) {}
        return parent::render($template);
    }

}