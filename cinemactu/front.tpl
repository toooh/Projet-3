<head>
  <link rel="stylesheet" type="text/css" href="front.css">
</head>



<div class="row">

	<div class="col-md-12">

	

		 <h3>Actualité : </h3>
<div class="defileParent">
<span class="defile">

			{foreach from=$actus item=actu}

			{if $smarty.now|date_format:"%Y-%m-%d" < $actu.DateFin}



			<h5><a href="{$actu.LinkActu}">{$actu.NameActu}</a></h5>

			{/if}

			{/foreach}

	</span>	
</div>

	</div>

</div>