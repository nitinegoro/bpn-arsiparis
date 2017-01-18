 <?php  

    $where = array(
      'id_hak' => $this->input->get('jenishak'), 
      'desa' => $this->input->get('desa'),
      'no_hakbuku' => $this->input->get('nohak'),
      'no208' => $this->input->get('no208'),
      'thn' => $this->input->get('thn'),
      'storage' => $this->input->get('storage'),
      'pemilik' => $this->input->get('pemilik'),
      'status' => $this->input->get('status')
    );
 ?>
  <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi Buku Tanah</h3>
                  <div class="box-tools">
                    <a href="<?php echo site_url("informasi/cetak?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn={$where['thn']}&desa={$where['desa']}&storage={$where['storage']}&pemilik={$where['pemilik']}&status={$where['status']}") ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Cetak</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form action="" method="get">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Jenis Hak :</label>
                        <select class="form-control input-sm" name="jenishak">
                          <option value="">~ PILIH ~</option>
                          <?php foreach($this->mbpn->jenis_hak() as $row) : $sama = ($where['id_hak']==$row->id_hak) ? 'selected' : '';
                            echo "<option value='{$row->id_hak}' {$sama}>{$row->jenis_hak}</option>"; endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label>No. 208 :</label>
                      <input type="text" name="no208" class="form-control input-sm" value="<?php echo $where['no208'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Pemilik Awal :</label>
                      <input type="text" name="pemilik" class="form-control input-sm" value="<?php echo $where['pemilik'] ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Nomor Hak :</label>
                      <input type="text" name="nohak" class="form-control input-sm" value="<?php echo $where['no_hakbuku'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Tahun <small>(warkah)</small> :</label>
                      <input type="text" name="thn" class="form-control input-sm" value="<?php echo $where['thn'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Status Dokumen :</label>
                      <select name="status" id="" class="form-control input-sm">
                        <option value="">~ PILIH ~</option>
                        <option value="Y" <?php echo ($where['status']=='Y') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="N" <?php echo ($where['status']=='N') ? 'selected' : ''; ?>>Tidak Aktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Kelurahan / Desa : </label>
                      <select id="list_desa" name="desa" class="form-control input-sm select">
                      <option value=""> ~ PILIH ~</option>
                      <?php foreach($this->mbpn->desa() as $row) : $sama = ($where['desa']==$row->id_desa) ? 'selected' : ''; ?>
                      <option value="<?php echo $row->id_desa; ?>" <?php echo $sama; ?>><?php echo $row->nama_desa; ?></option>
                    <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Ket Penyimpanan :</label>
                      <select name="storage" id="" class="form-control input-sm">
                        <option value="">~ PILIH ~</option>
                        <option value="sudah" <?php echo ($where['storage']=='sudah') ? 'selected' : ''; ?>>Tersimpan</option>
                        <option value="belum" <?php echo ($where['storage']=='belum') ? 'selected' : ''; ?>>Belum Tersimpan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-app top"><i class="fa fa-search"></i> Filter</button>
                    <a href="<?php echo site_url('informasi') ?>" class="btn btn-app top" style="margin-left: 10px;"><i class="fa fa-times"></i> Reset</a>
                  </div>
                </form>
                </div>
                <div class="box-body">
                  <p><i>Menampilkan <?php echo ($total_page <= $per_page) ? $total_page : $per_page;?> dari <?php echo $total_page; ?> Data</i></p>
                  <table class="table table-bordered">
                    <thead class="mini-font">
                      <tr>
                        <th width="50">No.</th>
                        <th>Jenis Hak</th>
                        <th>Nomor Hak</th>
                        <th>Luas / Nilai</th>
                        <th>Nomor 208</th>
                        <th>Tahun</th>
                        <th>Kelurahan / Desa</th>
                      </tr>
                    </thead>
                    <tbody class="mini-font">
                    <?php $no = ($this->input->get('page')) ? $this->input->get('page') : 0; foreach($data as $row) : ?>
                      <tr>
                        <td><?php echo ++$no; ?>.</td>
                        <td><?php echo $row->jenis_hak; ?></td>
                        <td><?php echo $row->no_hakbuku; ?></td>
                        <td><?php echo $row->luas; ?></td>
                        <td><?php echo $row->no208; ?></td>
                        <td><?php echo $row->tahun; ?></td>
                        <td><?php echo (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa); ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <?php echo $this->pagination->create_links(); ?>
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