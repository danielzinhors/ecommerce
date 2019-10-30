<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Estado
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Editar Estado</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="/admin/estado/create" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="nome_estado">Nome do estado</label>
                <input type="text" class="form-control" id="nome_estado" name="nome_estado" placeholder="Digite o nome do estado" value="<?php echo htmlspecialchars( $estado["nome_estado"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">              
              </div>
              <div class="form-group">
                <label for="id_pais">Pais</label><br>
                <select style="width: 25%;" name="id_pais">
                    <option ></option> 
                    <?php $counter1=-1;  if( isset($paises) && ( is_array($paises) || $paises instanceof Traversable ) && sizeof($paises) ) foreach( $paises as $key1 => $value1 ){ $counter1++; ?>

                    <option <?php if( $estado["id_pais"]=$value1["id_pais"] ){ ?>selected<?php } ?>  value="<?php echo htmlspecialchars( $value1["id_pais"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome_pais"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option> 
                    <?php } ?>

                </select>
              </div>
            </div>          
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->