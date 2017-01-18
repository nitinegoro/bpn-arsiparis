            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title"> Hasil pencarian - <small>Untuk melakukan perekaman Data Warkah</small></h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div>
                <div class="box-body">
                  <div class="col-md-3">
                    <table>
                      <tr>
                        <td class="doc-label">No. 208</td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo $data->no208; ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Tahun </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo $data->tahun; ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Status </td>
                        <td width="20px" class="text-center">:</td>
                        <td><?php echo ($data->status_warkah=='Y') ? 'Aktif' : 'Mati'; ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Keterangan </td>
                        <td width="20px" class="text-center">:</td>
                        <td>
                          <?php if($this->m_warkah->keterangan($data->id_warkah)) : ?>
                            <span class="label label-danger">Keluar</span>
                          <?php else : ?>
                            <span class="label label-success">Ada</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    </table>                  
                  </div>
                  <div class="col-md-3">
                    <table>
                      <tr>
                        <td class="doc-label">Jenis Hak </td>
                        <td width="20px" class="text-center">:</td>
                        <td><?php echo $this->bpn->hak($data->id_hak); ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">No. Hak </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo $data->no_hakbuku; ?></td>
                      </tr>
                      <?php if($data->id_hak != 5) : ?>
                      <tr>
                        <td class="doc-label">Kecamatan</td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo (!$data->id_kecamatan) ? '-' : $this->bpn->kecamatan($data->id_kecamatan); ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Desa/Kel </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo (!$data->id_desa) ? '-' : $this->bpn->desa($data->id_desa); ?></td>
                      </tr>
                      <?php endif; ?>
                      <tr>
                        <td class="doc-label">Luas </td>
                        <td width="20px" class="text-center">:</td>
                        <td><?php echo $data->luas; ?> </td>
                      </tr>
                      <tr>
                        <td class="doc-label">Pemilik Awal </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo (!$data->pemilik_awal) ? '-' : $data->pemilik_awal; ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Catatan </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo (!$data->catatan_warkah) ? '-' : $data->catatan_warkah; ?></td>
                      </tr>
                    </table>                  
                  </div>
                  <?php if(count($storage)>0) : ?>
                  <div class="col-md-3">
                    <table>
                      <tr>
                        <td class="doc-label">No. Lemari </td>
                        <td width="34px" class="text-center">:</td>
                        <td> <?php echo $this->mbpn->lemari($storage->no_lemari); ?> </td>
                      </tr>
                      <tr>
                        <td class="doc-label">Rak</td>
                        <td width="34px" class="text-center">:</td>
                        <td><?php echo $this->bpn->rak($storage->no_rak); ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">No. Album</td>
                        <td width="34px" class="text-center">:</td>
                        <td><?php echo $this->bpn->album($storage->no_album); ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Halaman</td>
                        <td width="34px" class="text-center">:</td>
                        <td><?php echo $storage->no_halaman; ?> </td>
                      </tr>
                    </table>
                  </div>
                  <?php else :  ?>
                  <div class="col-md-4">
                    <div class="alert alert-warning alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-warning"></i>Maaf! </h4>
                      Data Penyimpanan belum dilengkapi, silahkan lengkapi data Warkah ini. (<a href="<?php echo site_url("warkah/document/{$data->id_warkah}?t=storage") ?>">Lengkapi Data</a>)
                    </div>
                  </div>
                <?php endif; $pinjam = $this->m_warkah->get_pinjam($data->id_warkah); if(count($pinjam) > 0) :  ?>
                  <div class="col-md-3">
                    <table>
                      <tr>
                        <td class="doc-label">Pemminjam </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo $pinjam->peminjam; ?> </td>
                      </tr>
                      <tr>
                        <td class="doc-label">Tgl Peminjaman </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <?php echo tgl_indo($pinjam->tgl_peminjaman) ?></td>
                      </tr>
                      <tr>
                        <td class="doc-label">Ket Kegiatan </td>
                        <td width="20px" class="text-center">:</td>
                        <td> <small><?php echo (!$pinjam->kegiatan) ? '-' : $pinjam->kegiatan; ?></small></td>
                      </tr>
                    </table>
                  </div>
                <?php endif; ?>
                      <div class="col-md-12">
                        <hr>
                      <div class='list-group gallery'>
                      <?php foreach($this->m_warkah->file(0, $data->id_warkah) as $row) : ?>
                              <div class='col-sm-2 col-xs-6 col-md-2'>
                              <?php if($row->mime_type=='application/pdf') : ?>
                               <a class="fancybox fancybox.iframe btn btn-xs btn-default" href="<?php echo base_url("assets/files/{$row->nama_file}"); ?>"><i class="fa fa-file-pdf-o"></i> PDF FILE</a>
                            <?php else : ?>
                               <a class="thumbnail fancybox" rel="ligthbox" href="<?php echo base_url("assets/files/{$row->nama_file}"); ?>">
                                  <img class="img-responsive" alt="" src="<?php echo base_url("assets/files/{$row->nama_file}"); ?>" />
                               </a>
                            <?php endif; ?>
                              </div> <!-- col-6 / end -->
                      <?php endforeach; ?>
                          </div> <!-- list-group / end -->
                      </div>
                </div>
                <div class="box-footer">
                  <div class="btn-group pull-right">
                    <a href="<?php echo site_url("warkah/document/{$data->id_warkah}?t=storage") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Ubah Penyimpanan</a>
                    <?php if($this->m_warkah->keterangan($data->id_warkah)) : ?>
                      <a href="" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_kembali_warkah"><i class="fa fa-sign-out"></i> Kembalikan</a>
                  <?php else : ?>
                      <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_pinjam_warkah"><i class="fa fa-sign-out"></i> Pinjamkan</a>
                  <?php endif; ?>
                  </div>
                </div>              
              </div>
            </div>


           <!-- MODAL PINJAMKAN -->
            <div class="modal modal-default" id="modal_pinjam_warkah" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <form action="<?php echo site_url("apps/app_warkah/pinjam_warkah/{$data->id_warkah}") ?>" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Peminjaman Arsip Warkah Tanah.</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Peminjam :</label>
                            <input type="text" name="peminjam" class="form-control" placeholder="*Masukkan nama peminjam" required>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Ket Kegiatan :</label>
                            <textarea name="kegiatan" class="form-control" placeholder="*Jika iya masukkan keterangan" required></textarea>
                          </div>
                        </div>
                      </div>  
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary"> Pinjamkan</button>
                  </div>
                </div><!-- /.modal-content -->
                </form>
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- MODAL KEMBALI -->
            <div class="modal modal-default" id="modal_kembali_warkah" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <form action="<?php echo site_url("apps/app_warkah/kembali_warkah/{$data->id_warkah}") ?>" method="post">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pengembalian Arsip Warkah Tanah</h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> Kembalikan</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
              </form>
            </div><!-- /.modal -->


<?php 
if($this->input->get('print')=='true') :  
$id_print = $this->input->get('data_print');
?>
<script>
newwindow=window.open('<?php echo site_url("/apps/pinjam_warkah/cetak/{$id_print}") ?>','name','height=600,width=800');
if (window.focus) {
    newwindow.focus()
}
</script>
<?php endif; ?>
