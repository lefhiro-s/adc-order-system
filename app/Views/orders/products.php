<table id="datatable-checkbox" class="table table-striped table-bordered dt-responsive nowrap table-product-select" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Código</th>
            <th>Depósito</th>
            <th>Descripción</th>
            <th>Cantidad comprada</th>
            <th>Precio</th> 
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $key_product => $row_product) { ?>
        <tr>
            <td><?=$row_product["product_code"]?></td>
            <td><?=$row_product["warehouse"]?></td>
            <td><?=$row_product["description"]?></td>
            <td><?=$row_product["quantity"]?></td>
            <td><?=number_format($row_product["price"],2, ',', '.')?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
