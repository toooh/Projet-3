<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
	exit;
}

class Cinemactu extends Module
{
	protected $config_form = false;

	public function __construct()
	{
		$this->name = 'cinemactu';
		$this->tab = 'administration';
		$this->version = '1.0.0';
		$this->author = 'Yoann Colin & Dubois Théophile';
		$this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('cinemactu');
        $this->description = $this->l('Ceci est un module d\'actualité ');

        $this->confirmUninstall = $this->l('Etes-vous sûr ? ');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
    	Configuration::updateValue('CINEMACTU_LIVE_MODE', false);

    	return parent::install() &&
    	$this->registerHook('header') &&
    	$this->registerHook('backOfficeHeader') &&
    	$this->registerHook('actionCategoryAdd');
    }

    public function uninstall()
    {
    	Configuration::deleteByName('CINEMACTU_LIVE_MODE');

    	return parent::uninstall();
    }

    /**
     * Load the configuration form
     */

    Public function SubActu(){
    	$tab = [];
    	$tab['link'] = Tools::getValue('link','');
    	$tab['name'] = Tools::getValue('name','');
    	$tab['datein'] = Tools::getValue('datein','');
    	$tab['dateout'] = Tools::getValue('dateout','');

    	if (Tools::isSubmit('sub')){
    		$this->context->smarty->assign('link', $tab['link']);
    		$this->context->smarty->assign('name', $tab['name']);
    		$this->context->smarty->assign('datein', $tab['datein']);
    		$this->context->smarty->assign('dateout', $tab['dateout']);

    		$sql= $this->addActu($tab['link'], $tab['name'], $tab['datein'], $tab['dateout']);

    	}


    }

    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitCinemactuModule')) == true) {
        	$this->postProcess();
        }
        $nomvar = $this->SubActu();

        $results = $this->ajoutactu();
        $this->context->smarty->assign('actus', $results);



        $this->context->smarty->assign('link', '');
        $this->context->smarty->assign('name', '');
        $this->context->smarty->assign('datein', '');
        $this->context->smarty->assign('dateout', '');

        $this->context->smarty->assign('module_dir', $this->_path);

        $this->context->smarty->assign('test', Configuration::get('CINEMACTU_LINK'));

        $this->context->smarty->assign('test2', Configuration::get('CINEMACTU_ACTUALITY'));

        $this->context->smarty->assign('test3', Configuration::get('CINEMACTU_DATEIN'));

        $this->context->smarty->assign('test4', Configuration::get('CINEMACTU_DATEOUT'));

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
    	$helper = new HelperForm();

    	$helper->show_toolbar = false;
    	$helper->table = $this->table;
    	$helper->module = $this;
    	$helper->default_form_language = $this->context->language->id;
    	$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

    	$helper->identifier = $this->identifier;
    	$helper->submit_action = 'submitCinemactuModule';
    	$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
    	.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
    	$helper->token = Tools::getAdminTokenLite('AdminModules');

    	$helper->tpl_vars = array(
    		'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
    		'languages' => $this->context->controller->getLanguages(),
    		'id_language' => $this->context->language->id,
    		);

    	return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
    	return array(
    		'form' => array(
    			'legend' => array(
    				'title' => $this->l('Settings'),
    				'icon' => 'icon-cogs',
    				),
    			'input' => array(

    				array(
    					'col' => 4,
    					'type' => 'text',
    					'name' => 'CINEMACTU_LINK',
    					'label' => $this->l('URL de l\'actualité'),
    					),
    				array(
    					'col' => 6,
    					'type' => 'text',
    					'name' => 'CINEMACTU_ACTUALITY',
    					'label' => $this->l('actualité'),
    					),
    				array(
    					'col' => 6,
    					'type' => 'date',
    					'name' => 'CINEMACTU_DATEIN',
    					'label' => $this->l('Date de début'),
    					),
    				array(
    					'col' => 6,
    					'type' => 'date',
    					'name' => 'CINEMACTU_DATEOUT',
    					'label' => $this->l('Date de fin'),
    					),
    				),
    			'submit' => array(
    				'title' => $this->l('Save'),
    				'name' => 'CINEMACTU_SUBMIT',
    				),
    			),
    		);
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
    	return array(
    		'CINEMACTU_LINK' => Configuration::get('CINEMACTU_LINK'),
    		'CINEMACTU_ACTUALITY' => Configuration::get('CINEMACTU_ACTUALITY'),
    		'CINEMACTU_DATEIN' => Configuration::get('CINEMACTU_DATEIN'),
    		'CINEMACTU_DATEOUT' => Configuration::get('CINEMACTU_DATEOUT'),
    		);
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
    	$form_values = $this->getConfigFormValues();

    	foreach (array_keys($form_values) as $key) {
    		Configuration::updateValue($key, Tools::getValue($key));
    	}
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
    	if (Tools::getValue('module_name') == $this->name) {
    		$this->context->controller->addJS($this->_path.'views/js/back.js');
    		$this->context->controller->addCSS($this->_path.'views/css/back.css');
    	}
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
    	$this->context->controller->addJS($this->_path.'/views/js/front.js');
    	$this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

public function ajoutactu(){
	$req = 'SELECT * FROM '._DB_PREFIX_.'cinemactu';
    	$results = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($req);
    		return $results;
}

    public function hookdisplayTopColumn()
    {

    	$results = $this-> ajoutactu();

    		$this->smarty->assign('actus', $results);

    			return $this->display(__FILE__, 'front.tpl');
    		}


    		public function addActu($a,$b,$c,$d){
    		
    			$tes='';
    			$tes = Db::getInstance()->execute(
    				"INSERT INTO `ps_cinemactu`(`LinkActu`, `NameActu`, `DateDebut`, `DateFin`) VALUES ('".$a."','".$b."','".$c."','" .$d."')");
    			return $tes;
    		}
    	}

