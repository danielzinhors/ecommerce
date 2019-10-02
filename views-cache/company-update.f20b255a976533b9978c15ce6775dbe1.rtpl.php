<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Empresas
      </h1>
      <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/admin/companys">Empresas</a></li>
        <li class="active"><a href="/admin/company/create">Cadastrar</a></li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    
      <div class="row">
          <div class="col-md-12">
              <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Nova Empresa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/admin/companys/<?php echo htmlspecialchars( $company["idparamsempresa"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="razao_social">Razão Social</label>
                  <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Digite o nome da empresa" value="<?php echo htmlspecialchars( $company["razao_social"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-group">
                  <label for="nome_fantasia">Nome Fantasia</label>
                  <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" placeholder="Digite o nome fantasia" value="<?php echo htmlspecialchars( $company["nome_fantasia"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-group">
                  <label for="cnpj">CNPJ</label>
                  <input type="number" class="form-control" id="cnpj" name="cnpj" placeholder="99900210144" value="<?php echo htmlspecialchars( $company["cnpj"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-group">
                  <label for="inscr_estadual">IE</label>
                  <input type="number" class="form-control" id="inscr_estadual" name="inscr_estadual" placeholder="98565623154" value="<?php echo htmlspecialchars( $company["inscr_estadual"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-group">
                  <label for="inscr_municipal">IM</label>
                  <input type="number" class="form-control" id="inscr_municipal" name="inscr_municipal" placeholder="659863354" value="<?php echo htmlspecialchars( $company["inscr_municipal"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-group">
                  <label for="site">Site</label>
                  <input type="text" class="form-control" id="site" name="site" placeholder="http://www.berinc.com.br" value="<?php echo htmlspecialchars( $company["site"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-group">
                    <label for="file">Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo" value="<?php echo htmlspecialchars( $company["logo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                    <div class="box box-widget">
                      <div class="box-body">
                        <img class="img-responsive" id="image-preview" src="<?php echo htmlspecialchars( $company["logo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Logo">
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Salvar</button>
              </div>
            </form>
          </div>
          </div>
      </div>
    
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    