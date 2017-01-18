<?php  
$where = array('no' => $this->input->get('no'), 'thn' => $this->input->get('thn') );
?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Pencarian - <small> Data Warkah</small></h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form  action="<?php echo site_url('warkah/search'); ?>" method="GET">
                  <div class="row">
                    <div class="col-md-6 col-sm-5">
                      <div class="form-group">
                        <label>No.208 : </label>
                        <input type="text" class="form-control" placeholder="*Masukkan No.208..." name="no" value="<?php echo $where['no'] ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                      <div class="form-group">
                         <label for="exampleInputEmail1">Tahun :</label>
                         <input type="text" class="form-control" placeholder="Masukkan Tahun.." name="thn" value="<?php echo $where['thn'] ?>" required>
                      </div><!-- /.form-group -->
                    </div><!-- /.col -->
                    <div class="col-md-2 col-sm-2">
                      <div class="form-group">
                        <button class="btn btn-app" type="submit"><i class="fa fa-search"></i> Submit</button>  
                      </div><!-- /.form-group -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col atas-->
            <?php if(!$data) : ?>
            <div class="col-md-12">
              <div class="callout bg-gray">
                <h4 class="text-white"><i class="fa fa-info-circle"></i> Info !</h4>
                <p>- Silahkan Masukkan No. 208 dan tahun untuk melihat Data Warkah tanah.</p>
              </div>
            </div>
            <?php else :  $this->load->view('app-html/warkah/result_warkah', $data, FALSE); endif; ?>
          </div>
        </section>

 