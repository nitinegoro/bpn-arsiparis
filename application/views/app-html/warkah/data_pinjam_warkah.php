<?php 
// get data session
$session = $this->session->userdata('login'); 
// data filter
$where = array(
  'from' => (!$this->input->get_post('from')) ? '0000-00-00' : $this->input->get('from'), 
  'to' => (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to'), 
  'no208' => $this->input->get('no208'),
  'thn' => $this->input->get('thn'),
  'petugas' => $this->input->get('petugas'),
  'no' => ($this->input->get('page')) ? $this->input->get('page') : 0
);
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Dokumen Keluar  - <small> Warkah </small></h3>
          <div class="box-tools">
            <div class="btn-group">
              <?php if($session['level_akses']=='admin' OR $session['level_akses']=='super_admin') { ?>
              <a href="#" data-toggle="modal" data-target="#modal_unduh_pinjam" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Unduh Excel</a>
              <?php } ?>
            </div>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body no-print">
          <div class="col-md-12">
          <form>
           <div class="col-md-10">
             <div class="col-md-4 mini-font">
              <div class="form-group">
                <label>Nomor 208 :</label>
                <input type="text" name="no208" value="<?php echo $where['no208'] ?>" class="form-control input-sm">
              </div><!-- /.form group -->
             </div>
             <div class="col-md-4 mini-font">
              <div class="form-group">
                <label>Tahun :</label>
                <input type="text" name="thn" class="form-control input-sm" value="<?php echo $where['thn']; ?>">
              </div><!-- /.form group -->
             </div>

           </div>
           <div class="col-md-10">
             <div class="col-md-4 mini-font">
              <div class="form-group">
                <label>Dari Tanggal : <strong class="text-red">*</strong></label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control input-sm pull-right" name="from" id="date" value="<?php echo (!$this->input->get('from')) ? date('Y-m-01') : $this->input->get('from') ?>">
                </div><!-- /.input group -->
              </div><!-- /.form group -->
             </div>
             <div class="col-md-4 mini-font">
              <div class="form-group">
                <label>Sampai Tanggal : <strong class="text-red">*</strong></label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control input-sm pull-right" name="to" id="date2" value="<?php echo (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to') ?>">
                </div><!-- /.input group -->
              </div><!-- /.form group -->
             </div>
             <div class="col-md-4 mini-font">
              <div class="form-group">
                <label>Petugas :</label>
                <select class="form-control input-sm" name="petugas">
                  <option value="">~ PILIH ~</option>
                  <?php foreach($this->mbpn->user() as $row) : $sama = ($row->nip==$where['petugas']) ? 'selected' : '';
                  echo "<option value='{$row->nip}' {$sama}>{$row->nama_lengkap}</option>"; endforeach; ?>
                </select>
              </div><!-- /.form group -->
             </div>             
           </div>
           <div class="col-md-1">
              <button type="submit" class="btn btn-app" style="margin-top: -50px;"><i class="fa fa-search"></i> Filter</button>
              <a href="<?php echo site_url('warkah/keluar') ?>" class="btn btn-default" style="margin-left: 12px;"><i class="fa fa-times"></i> Reset</a>
           </div>
          </form>
          </div>
        </div><!-- /.box-body -->
        <div class="box-body">
          <table class="table table-bordered">
            <thead class="mini-font">
              <tr>
                <th rowspan="2" width="50">No</th>
                <th rowspan="2">Jenis Hak</th>
                <th rowspan="2">No. 208</th>
                <th rowspan="2">Tahun</th>
                <th colspan="2" class="text-center">Tanggal</th>
                <th rowspan="2">Petugas</th>
                <th rowspan="2">Peminjam</th>
                <th rowspan="2">Status</th>
                <th rowspan="2" width="100"></th>
              </tr>
              <tr>
                <th>Pinjam / Keluar</th>
                <th>Kembali / Masuk</th>
              </tr>
            </thead>
            <tbody class="mini-font">
            <?php foreach($data_pinjaman as $row) : ?>
              <tr>
                <td><?php echo ++$where['no']; ?>.</td>
                <td><?php echo $row->jenis_hak; ?></td>
                <td><?php echo $row->no208; ?></td>
                <td><?php echo $row->tahun; ?></td>
                <td><?php echo tgl_indo($row->tgl_peminjaman); ?></td>
                <td><?php echo ($row->tgl_kembali=='0000-00-00') ? '-' : tgl_indo($row->tgl_kembali); ?></td>
                <td><?php echo $row->nama_lengkap; ?></td>
                <td><?php echo $row->peminjam; ?></td>
                <td>
                  <?php if($row->status_pinjam == 'N') : echo '<span class="label label-warning">Keluar</span>'; else : echo '<span class="label label-success">kembali</span>'; endif; ?>
                </td>
                <td>
                  <a href="<?php echo site_url("apps/pinjam_warkah/cetak/{$row->id_pinjam_warkah}") ?>" target="_blank" class="btn btn-xs btn-default" title="Print"><i class="fa fa-print"></i></a>
                  <?php if($session['level_akses']=='admin' OR $session['level_akses']=='super_admin') : ?>
                  <a href="#" onclick="edit_pinjam_warkah('<?php echo $row->id_pinjam_warkah; ?>');" class="btn btn-xs btn-primary" title="Update"><i class="fa fa-edit"></i></a>
                  <a href="#" onclick="delete_pinjam_warkah('<?php echo $row->id_pinjam_warkah; ?>');" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-trash-o"></i></a>
                <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <?php echo $this->pagination->create_links(); ?>
        </div>
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
<style type="text/css">
  .top { margin-top:20px; }
  .mini-font { font-size:12px; }
</style>

<!-- MODAL UPDATE -->
            <!-- MODAL PINJAMKAN -->
            <div class="modal modal-default" id="modal_edit_pinjam_warkah" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <form action="" id="form_edit_pinjam_warkah" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Data Peminjaman Buku Tanah.</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Peminjaman :</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="pinjam" type="text" class="form-control tgl_peminjaman" id="date3" placeholder="*<?php echo date('Y-m-31') ?>" required>
                            </div><!-- /.input group -->   
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Peminjam :</label>
                            <input type="text" name="peminjam" id="peminjam" class="form-control" placeholder="*Masukkan nama peminjam" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Kembali :</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="kembali" type="text" class="form-control tgl_kembali" id="date4" placeholder="*<?php echo date('Y-m-31') ?>" required>
                            </div><!-- /.input group -->   
                          </div>
                        </div>
                        <input type="hidden" name="jenishak" value="<?php echo $this->input->get('jenishak') ?>">
                        <input type="hidden" name="from" value="<?php echo $this->input->get('from') ?>">
                        <input type="hidden" name="to" value="<?php echo $this->input->get('to') ?>">
                        <input type="hidden" name="petugas" value="<?php echo $this->input->get('petugas') ?>">
                        <input type="hidden" name="page" value="<?php echo $this->input->get('page'); ?>">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Status :</label>
                            <div class="radio">
                              <label>
                                <input type="radio" name="status" value="N" id="status_keluar"> Keluar
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="status" value="Y" id="status_kembali"> Kembali
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Ket Kegiatan :</label>
                            <textarea name="kegiatan" class="form-control" id="keterangan" placeholder="*Jika iya masukkan keterangan" required></textarea>
                          </div>
                        </div>
                      </div>  
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary"> Update</button>
                  </div>
                </div><!-- /.modal-content -->
                </form>
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- MODAL DELETE -->
            <div class="modal" id="modal_delete_pinjam_warkah">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus Data ini?</h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    <div class="btn-group" id="button_delete_pinjam_warkah"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- MODAL UNDUH -->
            <div class="modal" id="modal_unduh_pinjam" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title"><i class="fa fa-unduh"></i> Unduh - Daftar Dokumen Keluar Warkah Tanah</h5>
                  </div>
                  <form id="form-unduh_drd" action="<?php echo site_url("apps/pinjam_warkah/unduh") ?>" method="post" class="form-horizontal">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Bulan :</label>
                      <div class="col-sm-10">
                        <select name="bln" class="form-control">
                          <option value="">~ PILIH ~</option>
                          <?php for($bln=1; $bln<=12; $bln++) : ?>
                          <option value="<?php echo $bln; ?>"><?php echo bulan($bln); ?></option>
                        <?php endfor; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Tahun :</label>
                      <div class="col-sm-10">
                        <select name="thn" class="form-control">
                          <option value="">~ PILIH ~</option>
                          <?php for($thn=2016; $thn<=date('Y') + 1; $thn++) : ?>
                          <option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                        <?php endfor; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary" id="">Unduh</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>