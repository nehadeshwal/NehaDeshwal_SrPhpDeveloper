<?php 
    echo validation_errors();
    if($error != ''){
        echo $error;
        echo '<br/>';
    }
    if(isset($products->slug)){
        $url = site_url('product/editProduct/'.$products->slug);
    }else{
        $url = site_url('product/addProduct');
    }
    echo form_open_multipart($url,['id' =>'addProduct', 'autofill' =>'off', 'autocomplete'=>'off']);

?>
    <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-12">
        <?php
            echo form_input(['name'=> 'name', 'id' => 'name' , 'class'=>'form-control', 'placeholder'=>'Name','required'=>true,'maxlength'=>200, 'value'=>(isset($products->name))?set_value('name', $products->name):'']);
        ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Description</label>
        <div class="col-sm-12">
        <?php
             echo form_textarea(['name'=> 'description', 'id' => 'description' , 'class'=>'form-control', 'placeholder'=>'Description','required'=>true,'maxlength'=>1000, 'value'=>(isset($products->description))?set_value('description', $products->description):'']);
        ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Image</label>
        <div class="col-sm-12">
        <?php
             echo form_upload(['name'=> 'image', 'class'=>'form-control']);
        ?>
        </div>
    </div>
    <div class="col-sm-offset-2 col-sm-10">
    <?php
        echo form_submit('submit','Submit',['class'=>'btn btn-primary']);
    ?>
    </div>
<?php
    echo form_close();
?>
