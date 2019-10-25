<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/products/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct">Nome da produto</label>
              <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="Digite o nome do produto" value="<?php echo htmlspecialchars( $product["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" required="required">
            </div>
            <div class="form-group">
              <label for="vlprice">Preço</label>
              <input type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  required="required">
            </div>
            <div class="form-group">
              <label for="vlwidth">Largura</label>
              <input type="number" class="form-control" id="vlwidth" name="vlwidth" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["vlwidth"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  required="required">
            </div>
            <div class="form-group">
              <label for="vlheight">Altura</label>
              <input type="number" class="form-control" id="vlheight" name="vlheight" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["vlheight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  required="required">
            </div>
            <div class="form-group">
              <label for="vllength">Comprimento</label>
              <input type="number" class="form-control" id="vllength" name="vllength" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["vllength"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  required="required">
            </div>
            <div class="form-group">
              <label for="vlweight">Peso</label>
              <input type="number" class="form-control" id="vlweight" name="vlweight" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  required="required">
            </div>
            <div class="form-group">
              <label for="desurl">Url</label>
              <input type="text" class="form-control" id="desurl" name="desurl" placeholder="utilize o nome do produto sem espaços" value="<?php echo htmlspecialchars( $product["desurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  required="required">
            </div>
            <div class="form-group">
              <label>
                <input type="checkbox" name="in_slider" value="V" <?php if( $product["in_slider"] == 'V' ){ ?>checked<?php } ?>> Mostrar no slider
              </label>
            </div>
            <div class="form-group">
              <label for="descr_produto">Descrição</label>
              <input type="text" class="form-control" id="descr_produto" name="descr_produto" placeholder="Produto fabricado em..." value="<?php echo htmlspecialchars( $product["descr_produto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"></input>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-4">
                  <label for="file">Foto principal</label>
                  <input type="file" class="form-control" id="file" name="file" value="<?php echo htmlspecialchars( $product["imagem_principal"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                  <div class="box box-widget">
                    <div class="box-body">
                      <img class="img-responsive" style="max-height: 300px; max-width: 300px;" id="image-preview" src="<?php echo htmlspecialchars( $product["imagem_principal"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <label for="foto2">2ª foto </label>
                  <input type="file" class="form-control" id="foto2" name="foto2" value="<?php echo htmlspecialchars( $product["imagem_2"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                  <div class="box box-widget">
                    <div class="box-body">
                      <img class="img-responsive" style="max-height: 300px; max-width: 300px;" id="image-preview-2" src="<?php echo htmlspecialchars( $product["imagem_2"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <label for="foto3">3ª foto</label>
                  <input type="file" class="form-control" id="foto3" name="foto3" value="<?php echo htmlspecialchars( $product["imagem_3"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                  <div class="box box-widget">
                    <div class="box-body">
                      <img class="img-responsive" style="max-height: 300px; max-width: 300px;" id="image-preview-3" src="<?php echo htmlspecialchars( $product["imagem_3"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script> 
document.querySelector('#file').addEventListener('change', function(){

  var file = new FileReader();

  file.onload = function() {

    document.querySelector('#image-preview').src = file.result;

  }

  file.readAsDataURL(this.files[0]);

});
document.querySelector('#foto2').addEventListener('change', function(){

var file = new FileReader();

file.onload = function() {

  document.querySelector('#image-preview-2').src = file.result;

}

file.readAsDataURL(this.files[0]);

});
document.querySelector('#foto3').addEventListener('change', function(){

var file = new FileReader();

file.onload = function() {

  document.querySelector('#image-preview-3').src = file.result;

}

file.readAsDataURL(this.files[0]);

});
</script>
