        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Laporan Buku Tanah</h3>
                  <div class="box-tools">
                    <a href="<?php echo site_url('laporan/unduh'); ?>" class="btn btn-default"><i class="fa fa-file-excel-o"></i> To Excel</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-responsive table-hover" id="arsipbuku" width="100%">
                  <thead class="mini-font">
                    <tr>
                      <th colspan="1" class="text-center no-border" width="50">Tahun</th>
                      <?php foreach($hakmilik as $r) : ?>
                      <th colspan="3" class="text-center border-left"><?php echo $r->jenis_hak; ?></th>
                      <?php endforeach; ?>
                    </tr>
                    <tr class="bg-warning">
                      <th class="bg-white"></th>
                      <?php foreach($hakmilik as $r) : ?>
                      <th>A</th>
                      <th>M</th>
                      <th><?php echo ($r->id_hak==5) ? 'N' : 'L'; ?></th>
                    <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody class="mini-font">
                  <?php foreach($tahun as $key => $value) : ?>
                    <tr>
                      <td><?php echo $value['tahun'] ?></td>
                      <?php foreach($hakmilik as $r) : ?>
                      <td><?php echo $this->m_laporan->count_status('Y', $r->id_hak, $value['tahun']); ?></td><!--aktif-->
                      <td><?php echo $this->m_laporan->count_status('N', $r->id_hak, $value['tahun']); ?></td><!--mati-->
                      <td><?php echo $this->m_laporan->count_luas($r->id_hak, $value['tahun']); ?></td><!--luas-->
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                  <tfoot class="mini-font">
                    <tr class="bg-info">
                      <th class="bg-white"><strong>Jumlah</strong></th>
                      <?php foreach($hakmilik as $r) : ?>
                      <th><?php echo $this->m_laporan->count_status('Y', $r->id_hak); ?></th>
                      <th><?php echo $this->m_laporan->count_status('N', $r->id_hak); ?></th>
                      <th><?php echo $this->m_laporan->count_luas($r->id_hak); ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </tfoot>
                  </table>
                  <div class="col-md-12">
                     <?php echo $this->pagination->create_links(); ?>
                   </div> 
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="callout callout-default">
                    <h5>Keterangan :</h5>
                    <table>
                      <tr>
                        <td>A</td>
                        <td class="text-center" width="15px;">:</td>
                        <td>Aktif</td>
                      </tr>
                        <td>M</td>
                        <td class="text-center" width="15px;">:</td>
                        <td>Mati</td>
                      </tr>
                      </tr>
                        <td>L</td>
                        <td class="text-center" width="15px;">:</td>
                        <td>Luas</td>
                      </tr>
                      </tr>
                        <td>N</td>
                        <td class="text-center" width="15px;">:</td>
                        <td>Nilai</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- box-footer -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
<style type="text/css">
  .top { margin-top:20px; }
  .mini-font { font-size:11px; }
</style>