<?php
if($_SESSION['id_role'] == 1){
  ?>
<div class="card mt-3">
  <div class="card-header bg-info text-white ">
    Arsip Surat Masuk
  </div>
  <div class="card-body">
    <a href="?halaman=arsip_surat&hal=tambahdata" class="btn btn-success mb-3">Tambah Data</a>
<?php
}
?>
    <br>
    <form class="d-flex">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <br>
    <table class="table table-borderd table-hovered table-striped">      
      <tr>
        <th>No</th>
        <th>No Surat</th>
        <th>Tanggal Surat</th>
        <th>Tanggal Diterima</th>
        <th>Penerima</th>
        <th>Prihal</th>
        <th>Kode Nomor Arsip</th>
        <th>Nama Pengarsip Surat</th>
        <th>File</th>
        <?php
if($_SESSION['id_role'] == 1){
  ?>
        <th>Aksi</th>
      <?php
}
?>
      </tr>
      <?php
        $tab = 5;
        $page = isset($_GET["tab"]) ? (int)$_GET["tab"] : 1;
        $mulai = ($page>1) ? ($page * $tab) - $tab : 0;
        $query = mysqli_query($koneksi, "SELECT * from tbl_arsip");
        $tampil = mysqli_query($koneksi, "SELECT * from tbl_arsip order by id_arsip desc LIMIT $mulai, $tab");
        $total = mysqli_num_rows($query);
        $pages = ceil($total/$tab);
        $tampil = mysqli_query($koneksi, "
                  SELECT
                      tbl_arsip.*, 
                      tbl_departemen.nama_departemen,
                      tbl_pengirim_surat.nama_pengirim, tbl_pengirim_surat.alamat, tbl_pengirim_surat.no_hp,
                      tbl_pengirim_surat.email
                    FROM
                      tbl_arsip, tbl_departemen, tbl_pengirim_surat
                    WHERE
                      tbl_arsip.id_departemen = tbl_departemen.id_departemen
                      and tbl_arsip.id_pengirim = tbl_pengirim_surat.id_pengirim_surat
                      LIMIT $mulai, $tab ");
        //$no = 1;
        $no = $mulai+1;
        while($data = mysqli_fetch_array($tampil)) :

      ?>
      <tr>
        <td><?=$no++?></td>
        <td><?=$data['no_surat']?></td>
        <td><?=$data['tanggal_surat']?></td>
        <td><?=$data['tanggal_diterima']?> / <?=$data['waktu_terima']?> </td>
        <td><?=$data['penerima']?></td>
        <td><?=$data['prihal']?></td>
        <td><?=$data['nama_departemen']?></td>
        <td><?=$data['nama_pengirim']?> / <?=$data['no_hp']?></td>
        <td>
          <?php
            //uji apakah filenya ada atau tidak
            if(empty($data['file'])){
              echo " - ";
            }else{
          ?> 
   
            <a href="file/<?=$data['nama_departemen']?>/<?=$data['file']?>" target="$_blank"> lihat file </a>
            <a href="print.php?dir=<?=$data['nama_departemen']?>/&file=<?=urlencode($data['file'])?>">Download</a>
          <?php   
            }
          ?>
        </td>
<?php
if($_SESSION['id_role'] == 1){
  ?>
        <td>
          <a href="?halaman=arsip_surat&hal=edit&id=<?=$data['id_arsip']?>" class="btn btn-success" >Edit </a>
          <a href="?halaman=arsip_surat&hal=hapus&id=<?=$data['id_arsip']?>" class="btn btn-danger" 
            onclick="return confirm('Apakah yakin ingin menghapus data ini?')" >Hapus </a>
        </td>
        <?php
      }
    ?>
      </tr>
    <?php endwhile; ?>
    </table>
    <div class="">
      <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="?halaman=arsip_surat&tab=<?php echo $page-1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
      <?php for ($i=1; $i<=$pages ; $i++){ ?>
    <li class="page-item"><a class="page-link" href="?halaman=arsip_surat&tab=<?php echo $i; ?>"><?php echo $i; ?></a></li>
     <?php } ?>
    <li class="page-item">
      <a class="page-link" href="?halaman=arsip_surat&tab=<?php echo $page+1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</div>
  </div>
</div>