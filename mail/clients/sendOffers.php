<center>
    <h1>Productos similares a tu última búsqueda:</h1>
    <br>
    <?php foreach ($offers as $key => $offer) { ?>
		<p>
			Producto: <?= $offer->name ?> <br>
			Precio: <?= $offer->price ?> <br>
		</p>
		<?php if(isset($offer->product_image)): ?>
			<img src="<?= str_replace('../web/', 'https://tienda.feriame.com/', $offer->product_image) ?>" style="width: 300px; "/>
		<?php endif; ?>
		<hr>
    <?php } ?>
    <br>
</center>
