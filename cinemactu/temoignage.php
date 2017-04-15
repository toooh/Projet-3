<?php
if(!defined( '_PS_VERSION_'))
   exit; 

class Temoignage extends Module{
    public function __construct(){
        $this--->name = 'temoignage';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Moi';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('Témoignages');
        $this->description = $this->l('Affiche un bloc avec des témoignages clients');
        $this->confirmUninstall = $this->l('Êtes-vous certain de vouloir supprimer les informations de ce module ?');
    }
public function install(){
    if( !parent::install()
        || !$this->registerHook('header')
        || !$this->registerHook('leftColumn')
    )
        return false;

    if( !Configuration::updateValue('TEMOIGNAGE_1', '')
        || !Configuration::updateValue('TEMOIGNAGE_2', '')
        || !Configuration::updateValue('TEMOIGNAGE_3', '')
    )
        return false;

    return true;
}

public function uninstall(){
    if (!parent::uninstall()
        || !Configuration::deleteByName('TEMOIGNAGE_1')
        || !Configuration::deleteByName('TEMOIGNAGE_2')
        || !Configuration::deleteByName('TEMOIGNAGE_3')
    )
        return false;
    return true;
}
public function getContent(){
       $this->_html.=
‘.$THIS->DISPLAYNAME.’
 

‘.$this->l(‘Paramètres’).’
 

‘.$THIS->L(‘TÉMOIGNAGE 1′).’


‘;<br /><br />
                           if(Configuration::get(‘TEMOIGNAGE_1’) !=  »)<br /><br />
                               $this->_html .= Configuration::get(‘TEMOIGNAGE_1’);<br /><br />
                           else $this->_html .=  »;<br /><br />
                       $this->_html .= ‘<br /><br />
                       
 

‘.$THIS->L(‘TÉMOIGNAGE 2′).’


‘;<br /><br />
                           if(Configuration::get(‘TEMOIGNAGE_2’) !=  »)<br /><br />
                               $this->_html .= Configuration::get(‘TEMOIGNAGE_2’);<br /><br />
                           else $this->_html .=  »;<br /><br />
                       $this->_html .= ‘<br /><br />
                       
 

‘.$THIS->L(‘TÉMOIGNAGE 3′).’
‘;<br /><br />
                           if(Configuration::get(‘TEMOIGNAGE_3’) !=  »)<br /><br />
                               $this->_html .= Configuration::get(‘TEMOIGNAGE_3’);<br /><br />
                           else $this->_html .=  »;<br /><br />
                       $this->_html .= ‘<br /><br />

‘; return $this->_html; }

private function _preProcess(){        
       if(Tools::isSubmit('save')){                
           if(isset($_POST['temoignage_1']))
               Configuration::updateValue('TEMOIGNAGE_1', addslashes($_POST['temoignage_1']));
           if(isset($_POST['temoignage_2']))
               Configuration::updateValue('TEMOIGNAGE_2', addslashes($_POST['temoignage_2']));
           if(isset($_POST['temoignage_3']))
               Configuration::updateValue('TEMOIGNAGE_3', addslashes($_POST['temoignage_3']));
           $this->_html .=.$this->l('Confirmation').; $this->_html .= $this->l(‘Témoignages enregistrés’); $this->_html .= ‘‘; } }

           public function hookHeader($params){
    Tools::addCSS(($this->_path).'css/temoignage.css', 'all');
    Tools::addJS(($this->_path).'js/temoignage.js', 'all');
}

public function hookLeftColumn($params){
    global $smarty;
    $smarty->assign('temoignages', array(stripslashes(Configuration::get('TEMOIGNAGE_1')), stripslashes(Configuration::get('TEMOIGNAGE_2')), stripslashes(Configuration::get('TEMOIGNAGE_3'))));
    return $this->display(__FILE__,'temoignage.tpl');
}
}