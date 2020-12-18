<table id="datatable-checkbox" class="table table-striped table-bordered dt-responsive nowrap table-product-select" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="text-center"><input type="checkbox" id="check-all" class="flat check-all-product"></th>
            <th>Código</th>
            <th>Código de barras</th>
            <th>Depósito</th>
            <th>Descripción</th>
            <th>Cantidad disponible</th>
            <th>Precio</th> 
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $key_product => $row_product) { ?>
        <tr class="entry-<?=$row_product->code?>">
            <td class="text-center"><input type="checkbox" id="check-product-<?=$row_product->code?>" class="flat check-product"></td>
            <td><?=$row_product->code?></td>
            <td><?=$row_product->barcode?></td>
            <td><?=$row_product->warehouse?></td>
            <td><?=$row_product->description?></td>
            <td><?=$row_product->quantity?></td>
            <td><?=number_format($row_product->price,2, ',', '.')?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
