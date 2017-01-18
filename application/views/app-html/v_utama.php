        <section class="content-header">
          <h1>
            <small>Halaman Utama</small>
          </h1>
          <ol class="breadcrumb">
            <li>
              <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Halaman Utama</a>
            </li>
            <li class="active">Halaman Utama</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">

            <div class="col-md-3 col-xs-6">
              <div class="small-box pad" style="background-color: #316395; color: white;">
                <div class="inner">
                  <h3><?php echo $this->m_presentation->getDok_aktif(); ?></h3>
                  <p>Buku Tanah Aktif</p>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text"></i>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-xs-6">
              <div class="small-box pad" style="background-color: #951E1E; color: white;">
                <div class="inner">
                  <h3><?php echo $this->m_presentation->getDok_mati(); ?></h3>
                  <p>Buku Tanah Mati</p>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text-o"></i>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-xs-6">
              <div class="small-box pad" style="background-color: #D0A711; color: white;">
                <div class="inner">
                  <h3><?php echo $this->m_presentation->getDokBuku_keluar(); ?></h3>
                  <p>Buku Tanah Keluar</p>
                </div>
                <div class="icon">
                  <i class="fa fa-sign-out"></i>
                </div>
              </div>
            </div> 
            <div class="col-md-3 col-xs-6">
              <div class="small-box pad" style="background-color: #D0A711; color: white;">
                <div class="inner">
                  <h3><?php echo $this->m_presentation->getDokWarkah_keluar(); ?></h3>
                  <p>Warkah Keluar</p>
                </div>
                <div class="icon">
                  <i class="fa fa-sign-out"></i>
                </div>
              </div>
            </div> 
           
              <div class="col-md-5 col-xs-12 col-sm-12">
                <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Indeks Buku Tanah </h3> <small>-</small>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="chart">
                      <canvas id="canvas" height="210" width="500"></canvas>
                    </div>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->  
              </div> 

              <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Jumlah <sup>/</sup>Jenis Hak</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="chart-responsive">
                          <canvas id="jenishak" height="205"></canvas>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <ul class="chart-legend clearfix">
                        <?php foreach ($this->mbpn->jenis_hak() as $row) { if($row->id_hak == 5) : continue; endif; ?>
                          <li><i class="fa fa-circle" style="color: <?php echo colorChart($row->id_hak); ?>;"></i> <?php echo $row->jenis_hak; ?></li>
                        <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-5 col-xs-12 col-sm-12">
                <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Hak Tanggungan </h3> <small></small>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body chart-responsive">
                    <div class="chart" id="line-chart" style="height: 210px;"></div>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->  
              </div> 

              <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Jumlah Buku Tanah <sup>/</sup>Kecamatan</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="chart-responsive">
                          <canvas id="pieChart" height="205"></canvas>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <ul class="chart-legend clearfix">
                        <?php foreach ($this->m_apps->kecamatan() as $row) { if($row->id_kecamatan==7) : continue; endif; ?>
                          <li><i class="fa fa-circle" style="color: <?php echo colorChart($row->id_kecamatan); ?>;"></i> <?php echo $row->nama_kecamatan; ?></li>
                        <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Aktifitas Terakhir</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <table class="table table-bordered">
                      <thead class="mini-font">
                        <tr>
                          <th width="10">No.</th>
                          <th>Waktu</th>
                          <th>Jenis Hak</th>
                          <th>Nomor Hak</th>
                          <th>Nomor 208</th>
                          <th>Tahun</th>
                          <th>Kelurahan</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody class="mini-font">
                        <?php $no=1; foreach($history as $row) : ?>
                        <tr>
                          <td><?php echo $no++; ?>.</td>
                          <td><?php echo $row->time; ?> <small><i><time class="timeago" datetime="<?php echo $row->time; ?>"><?php echo $row->time; ?></time></i></small></td>
                          <td><?php echo $row->jenis_hak; ?></td>
                          <td><?php echo $row->no_hakbuku; ?></td>
                          <td><?php echo $row->no208; ?></td>
                          <td><?php echo $row->tahun; ?></td>
                          <td><?php echo (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa); ?></td>
                          <td><?php echo $row->deskripsi; ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


          </div>
        </section>
<style>.mini-font { font-size:11px; }</style>