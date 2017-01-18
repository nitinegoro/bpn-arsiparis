        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit - <small>Warkah Tanah</small></h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom tab-warning">
                        <ul class="nav nav-tabs">
                          <li class="<?php echo ($this->input->get('t')=='storage') ? 'active' : ''; ?>"><a href="<?php echo site_url("warkah/document/{$data->id_warkah}?t=storage"); ?>">Data Penyimpanan</a></li>
                          <li class="<?php echo ($this->input->get('t')=='file') ? 'active' : ''; ?>"><a href="<?php echo site_url("warkah/document/{$data->id_warkah}?t=file"); ?>">File Dokumen</a></li>
                          <a href="<?php echo site_url("warkah/search?no={$data->no208}&thn={$data->tahun}") ?>" class="btn btn-default btn-sm pull-right"><i class="fa fa-reply"></i> Kembali ke pencarian</a>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane <?php echo ($this->input->get('t')=='storage') ? 'active' : ''; ?>" id="tab_2">
                            <hr>
                            <form action="<?php echo site_url("apps/app_warkah/update_penyimpanan/{$data->id_warkah}") ?>" method="post">
                            <div class="row">
                              <div class="col-md-12">
                              <?php if(count($storage)>0) :   ?>
                                <table class="col-md-4 col-xs-12" style="margin-left:  15px;">
                                  <thead>
                                    <tr>
                                      <td><strong>Lemari</strong></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $this->mbpn->lemari($storage->no_lemari); ?></td>
                                      <td width="100"></td>
                                      <td><strong>Rak</strong></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $this->bpn->rak($storage->no_rak); ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Album</strong></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $this->bpn->album($storage->no_album); ?></td>
                                      <td width="100"></td>
                                      <td><strong>Halaman</strong></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $storage->no_halaman; ?></td>
                                    </tr>
                                  </thead>
                                </table>
                              <?php endif; ?>
                                <div class="col-xs-12"><hr></div>
                              </div>
                              <div class="form-group col-md-12" id="form_desa">
                                <label class="col-xs-2 control-label">Catatan Warkah:</label>
                                <div class="col-xs-6">
                                  <textarea name="catatan" id="" cols="30" rows="3" class="form-control"><?php echo $data->catatan_warkah; ?></textarea>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group col-md-4">
                                  <label class="control-label">Lemari :</label>
                                  <select name="lemari" id="lemari_warkah" class="form-control">
                                    <option value="">- PILIH -</option>
                                    <?php foreach($lemari as $row): ?>
                                    <option value="<?php echo $row->no_lemari; ?>"> <?php echo $row->nama_lemari; ?></option>
                                  <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="form-group col-md-4">
                                  <label class="control-label">Rak :</label>
                                  <select name="rak" id="rak_warkah" class="form-control">
                                    <option value="">- PILIH -</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-4">
                                  <label class="control-label">Album :</label>
                                  <select name="album" id="album_warkah" class="form-control">
                                    <option value="">- PILIH -</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="col-md-12">
                                  <p>Pilih Lembar Yang tersedia : </p>
                                </div>
                                <div class="form-group">
                                  <ul id="laman" style="list-style: none; margin-left: -30px;"></ul>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Simpan</button>
                              </div>
                            </div>
                            </form>
                          </div><!-- /.tab-pane -->
                          <div class="tab-pane <?php echo ($this->input->get('t')=='file') ? 'active' : ''; ?>" id="tab_3">
                            <div class="row">
                            <form action="<?php echo site_url("apps/file_warkah/bulk_action/{$data->id_warkah}") ?>" method="post">
                              <div class="col-md-12">
                                <hr>
                                <div class="col-md-2 padding-top">
                                  <select class="form-control input-sm" name="action">
                                    <option value="null">- TINDAKAN MASSAL -</option>
                                    <option value="delete">DELETE</option>
                                  </select>
                                </div>
                                <div class="col-md-2 padding-top">
                                  <button type="submit" class="btn btn-sm btn-default">Terapkan</button>
                                </div>
                                <div class="col-md-2 padding-top pull-right">
                                  <button type="button" data-toggle="modal" data-target="#modal_add_file" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Tambahkan File</button>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <hr>
                                <table class="table table-bordered table-responsive">
                                  <thead>
                                    <tr>
                                      <th width="50"><input type="checkbox" id="checkAll" name="checkAll"></th>
                                      <th>No.</th>
                                      <th>Nama File</th>
                                      <th>File Type</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php $no=1; foreach($file as $row) : ?>
                                    <tr>
                                      <td><input type="checkbox" name="file[]" value="<?php echo $row->id; ?>"></td>
                                      <td width="50"><?php echo $no++; ?>.</td>
                                      <td><a class="fancybox fancybox.iframe" href="<?php echo base_url("assets/files/{$row->nama_file}"); ?>"><?php echo $row->nama_file; ?></td>
                                      <td><?php echo $row->mime_type; ?></td>
                                      <td width="50" class="text-center">
                                        <a href="#" onclick="delete_file_warkah('<?php echo $row->id; ?>','<?php echo $data->id_warkah; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                                </table>
                              </div>
                            </form>
                            </div>
                          </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                      </div><!-- nav-tabs-custom -->
                    </div><!-- /.col -->
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

<div class="modal" id="modal-data_tersedia">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-bell-o"></i> Slot <span id="slot"></span> Terisi!</h4>
      </div>
      <div class="modal-body">
        <table width="100%">
          <tbody id="data_terisi"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_delete_file_warkah">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-red">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus File ini?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <div class="btn-group" id="button_delete_file_warkah"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_add_file" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
  <form id="add_file_warkah" method="POST" class="form-horizontal" action="<?php echo site_url("apps/file_warkah/add_multiple/{$data->id_warkah}") ?>" enctype="multipart/form-data"  accept-charset="utf-8">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-plus"></i> Tambahkan File Dokumen Buku Tanah</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="col-lg-2 col-xs-12 control-label">File Dokumen :</label>
          <div class="col-lg-7 col-xs-7">
            <input class="form-control" type="file" name="file[0]" data-index="0" />
          </div>
          <div class="col-lg-3 col-xs-3">
            <button type="button" class="btn btn-default btn-sm addButton" data-template="file"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="form-group hide" id="fileTemplate">
          <div class="col-lg-offset-2 col-lg-7 col-xs-7">
            <input class="form-control" type="file" />
          </div>
          <div class="col-lg-3 col-xs-3">
            <button type="button" class="btn btn-default btn-sm removeButton"><i class="fa fa-times"></i></button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default out" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Tambahkan</button>
      </div>
    </div>
  </form>
  </div>
</div>