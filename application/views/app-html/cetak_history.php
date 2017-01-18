<html>
 <head></head>
 <body onload="window.print()"> <!--  onload="window.print()" -->
   <div class="wrapper">
      <div class="header">
         <div class="big-title">Data History</div>
      </div>
   </div>
   <div class="content">
    <table class="gridtable" width="100%">
      <thead>
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
      <tbody>
        <?php $no=1; foreach($data_loop as $row) : ?> 
        <tr>
          <td><?php echo $no++; ?>.</td>
          <td><?php echo $row->nip; ?></td>
          <td><?php echo $row->nama_lengkap; ?></td>
          <td><?php echo $row->time; ?></td>
          <td><?php echo $row->jenis_hak;  ?></td>
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
 </body>
</html> 

<style>
   table { font-size:12px; font-family:'Arial'; }
   .header { width:100%; height:10%; text-align:center; font-weight:500;  }
   .big-title {  font-family:'Arial'; font-size:14px; letter-spacing:normal; font-weight:bold; }
   .small-title {  font-family:'Times New Roman'; font-size:13px; letter-spacing:normal; }
   .content { font-size:12px; font-family:'Arial'; margin-top:-20px;}
   .upper { text-transform: uppercase;  }
   .underline { text-decoration: underline; }
   .bold { font-weight:bold; }
   table.gridtable {
      border-width: 1px;
      border-color: black;
      border-collapse: collapse; 
      font-size:0.8em;
   }
   table.gridtable th {
      border-width: 1px;
      padding: 5px;
      border-style: solid;
      border-color: black;
   }
   table.gridtable td {
      border-width: 0.1px;
      border-top: 0px;
      padding: 0px 0px 0px 3px;
      border-style: solid;
      border-color: black;
   }
</style>
