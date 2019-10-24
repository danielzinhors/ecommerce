<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="product-big-title-area">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="product-bit-title text-center">
                <h2>
                  Bem vindo ao painel administrativo de <?php echo getFieldCompany("nome_fantasia"); ?>

                </h2>
              </div>
            </div> 
          </div>
        </div> 
      </div>
      <div class="form-group">
        <div class="box box-widget">
          <div class="box-body">
            <img class="img-responsive" width="100%" id="image-preview" alt="Foto" src=<?php echo getFieldCompany("logo"); ?>>
          </div>
      </div>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->