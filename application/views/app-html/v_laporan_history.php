<?php  
    $where = array(
      'id_hak' => $this->input->get('jenishak'), 
      'desa' => $this->input->get('desa'),
      'bln' => $this->input->get('bln'),
      'no_hakbuku' => $this->input->get('nohak'),
      'no208' => $this->input->get('no208'),
      'thn_warkah' => $this->input->get('thn_warkah'),
      'thn_history' => $this->input->get('thn_history')
    );
?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Laporan History</h3>
                  <div class="box-tools">
                    <a href="<?php echo site_url("laporan_history/cetak?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn_warkah={$where['thn_warkah']}&desa={$where['desa']}&thn_history={$where['thn_history']}&bln={$where['bln']}"); ?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Cetak</a>
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

                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Nomor Hak :</label>
                      <input type="text" name="nohak" class="form-control input-sm" value="<?php echo $where['no_hakbuku'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Tahun <small>(warkah)</small> :</label>
                      <input type="text" name="thn_warkah" class="form-control input-sm" value="<?php echo $where['thn_warkah'] ?>">
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
                      <label>Tahun :</label>
                      <select class="form-control input-sm" name="thn_history">
                        <option value="">~ PILIH ~</option>
                        <?php for($thn=2016; $thn<=date('Y')+1; $thn++) { $podo = ($thn==$where['thn_history']) ? 'selected' : '';  echo '<option value="'.$thn.'" '.$podo.'>'.$thn.'</option>'; } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Bulan :</label>
                      <select class="form-control input-sm" style="width: 100%;" name="bln">
                        <option value="">~ PILIH ~</option>
                        <option value="1" <?php echo ($where['bln']==1) ? 'selected' : ''; ?>>Januari</option>
                        <option value="2" <?php echo ($where['bln']==2) ? 'selected' : ''; ?>>Februari</option>
                        <option value="3" <?php echo ($where['bln']==3) ? 'selected' : ''; ?>>Maret</option>
                        <option value="4" <?php echo ($where['bln']==4) ? 'selected' : ''; ?>>April</option>
                        <option value="5" <?php echo ($where['bln']==5) ? 'selected' : ''; ?>>Mei </option>
                        <option value="6" <?php echo ($where['bln']==6) ? 'selected' : ''; ?>>Juni</option>
                        <option value="7" <?php echo ($where['bln']==7) ? 'selected' : ''; ?>>Juli</option>
                        <option value="8" <?php echo ($where['bln']==8) ? 'selected' : ''; ?>>Agustus</option>
                        <option value="9" <?php echo ($where['bln']==9) ? 'selected' : ''; ?>>September</option>
                        <option value="10" <?php echo ($where['bln']==10) ? 'selected' : ''; ?>>Oktober</option>
                        <option value="11" <?php echo ($where['bln']==11) ? 'selected' : ''; ?>>November</option>
                        <option value="12" <?php echo ($where['bln']==12) ? 'selected' : ''; ?>>Desember</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-default top"><i class="fa fa-search"></i> Filter</button>
                    <a href="<?php echo site_url('laporan_history') ?>" class="btn btn-default top" style="margin-left: 10px;"><i class="fa fa-times"></i> Reset</a>
                  </div>
                </form>
                </div>
                <div class="box-body">
                  <table class="table table-bordered">
                    <thead class="mini-font">
                      <tr>
                        <th>No.</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
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
                    <?php $no = ($this->input->get('page')) ? $this->input->get('page') : 0; foreach($data_history as $row) : ?>
                      <tr>
                        <td><?php echo ++$no; ?>.</td>
                        <td><?php echo $row->nip; ?></td>
                        <td><?php echo $row->nama_lengkap; ?></td>
                        <td><?php echo $row->time; ?></td>
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