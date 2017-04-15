{*
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
	*}

	<div class="panel">
		<h3><i class="icon icon-credit-card"></i> {l s='cinemactu' mod='cinemactu'}</h3>
		<p>
			<strong>{l s='Here is my new generic module!' mod='cinemactu'}</strong><br />
			{l s='Thanks to PrestaShop, now I have a great module.' mod='cinemactu'}<br />
			{l s='I can configure it using the following configuration form.' mod='cinemactu'}
		</p>
		<br />
		<p>
			{l s='This module will boost your sales!' mod='cinemactu'}
		</p>
	</div>

	<div class="panel">
		<div class="table-responsive-row clearfix">
			<h3>Documentation</h3>
			<table id="table-product" class="table product">

				<th>ID</th>
				<th>Lien Actu</th>
				<th>Titre Actu</th>
				<th>Date de début</th>
				<th>Date de Fin</th>
				{foreach from=$actus item=actu}
				<tr class=" odd">
					<td>{$actu.id_cinemactu}</td>
					<td>{$actu.LinkActu}</td>
					<td>{$actu.NameActu}</td>
					<td>{$actu.DateDebut}</td>
					<td>{$actu.DateFin}</td>
				</tr>
				{/foreach}
			</table>
		</div>
	</div>

	<div class="panel">
		<h3>Votre Actualité</h3>
		<form action="" method="POST">
			Liens de l'actualité:
			(veillez à mettre le lien complet)
			<input type="text" name="link" value="{$link}"/> 
		</br>
		Titre de votre actualité: 
		<input type="text" name="name" value="{$name}"/>
	</br>
	<table>
		<tr>
			<td>Date de début:&nbsp;  </td>
			<td><input type="date" name="datein" class="datepicker" value="{$datein}"/></td>
		</tr>
		<tr><td>
			&nbsp;
		</td></tr>
		<tr>
			<td>Date de fin:</td>   
			<td><input type="date" name="dateout" class="datepicker" value="{$dateout}"/></td>
		</tr>
		<tr>
			<td><input type="submit" name="sub"></td>
		</tr>
	</table>
</br>
</form>

</div>