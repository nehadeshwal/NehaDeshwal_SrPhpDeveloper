<div class="container">
    <?php
        echo anchor('product/addProduct', 'Add New', 'class="btn btn-info ml-3"') 
    ?>
    <br><br>
    <table class="table table-bordered table-striped" id="product_list">
        <thead>
            <tr>
                <th>Srno</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Descriptionn</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if($products){
            $i = 1;
            foreach($products as $product){
        ?>
            <tr id="product_id_<?php echo $product->slug;?>">
                <td><?php echo $i++;?></td>
                <td>
                    <?php
                    if($product->image != ''){
                    ?>
                        <img src="<?php echo base_url();?>assets/images/<?php echo $product->image ?>" width="100" height="100">
                    <?php
                    }
                    ?>
                </td>
                <td><?php echo $product->name;?></td>
                <td><?php echo $product->slug;?></td>
                <td><?php echo $product->description;?></td>
                <td>
                    <?php 
                        echo anchor('product/editProduct/'.$product->slug, 'Edit', 'class="btn btn-info"') ;
                        echo anchor('product/delete/'.$product->slug, 'Delete', 'class="btn btn-danger" onclick="return confirm(\'Are you sure?\')"'); 
                    ?>
                </td>
            </tr>
        <?php 
            }
        }
         ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    $("#product_list").DataTable({
        "pageLength": 10,
        "lengthMenu": [[1, 10, 20,50], [1, 10, 20,50]]
    });
}); 
</script>
