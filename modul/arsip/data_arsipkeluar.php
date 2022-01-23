<?php
if($_SESSION['id_role'] == 1){
  ?>
<div class="card mt-3">
  <div class="card-header bg-info text-white ">
    Arsip Surat Keluar
  </div>
  <div class="card-body">
    <a href="?halaman=arsip_suratkeluar&hal=tambahdata" class="btn btn-success mb-3">Tambah Data</a>
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
        <th>No Surat Keluar</th>
        <th>Tanggal Surat Keluar</th>
        <th>Prihal</th>
        <th>Penerima</th>
        <th>Kode Arsip</th>
        <th>Pengirim</th>
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
        $query = mysqli_query($koneksi, "SELECT * from tbl_arsipkeluar");
        $tampil = mysqli_query($koneksi, "SELECT * from tbl_arsipkeluar order by id desc LIMIT $mulai, $tab");
        $total = mysqli_num_rows($query);
        $pages = ceil($total/$tab);
        $tampil = mysqli_query($koneksi, "
                  SELECT
                      tbl_arsipkeluar.*, 
                      tbl_departemen.nama_departemen,
                      tbl_pengirim_surat.nama_pengirim, tbl_pengirim_surat.alamat, tbl_pengirim_surat.no_hp,
                      tbl_pengirim_surat.email
                    FROM
                      tbl_arsipkeluar JOIN tbl_departemen ON tbl_arsipkeluar.id_departemen=tbl_departemen.id_departemen JOIN tbl_pengirim_surat ON tbl_pengirim_surat.id_pengirim_surat=tbl_arsipkeluar.id_pengirim
                    WHERE
                      tbl_arsipkeluar.id_departemen = tbl_departemen.id_departemen
                      and tbl_arsipkeluar.id_pengirim = tbl_pengirim_surat.id_pengirim_surat
                      LIMIT $mulai, $tab ");
        //$no = 1;
        $no = $mulai+1;
        while($data_arsipkeluar = mysqli_fetch_array($tampil)) :

      ?>
      <tr>
        <td><?=$no++?></td>
        <td><?=$data_arsipkeluar['no_suratkeluar']?></td>
        <td><?=$data_arsipkeluar['tanggal_suratkeluar']?></td>
        <td><?=$data_arsipkeluar['prihal']?></td>
        <td><?=$data_arsipkeluar['penerima']?></td>
        <td><?=$data_arsipkeluar['nama_departemen']?></td>
        <td><?=$data_arsipkeluar['nama_pengirim']?> / <?=$data_arsipkeluar['no_hp']?></td>
        <td>
          <?php
            //uji apakah filenya ada atau tidak
            if(empty($data_arsipkeluar['file'])){
              echo " - ";
            }else{
          ?> 
   
            <a href="file/<?=$data_arsipkeluar['nama_departemen']?>/<?=$data_arsipkeluar['file']?>" target="$_blank"> lihat file </a>
            <a href="print.php?dir=<?=$data_arsipkeluar['nama_departemen']?>/&file=<?=urlencode($data_arsipkeluar['file'])?>">Download</a>
          <?php   
            }
          ?>
        </td>
<?php
if($_SESSION['id_role'] == 1){
  ?>
        <td>
          <a href="?halaman=arsip_suratkeluar&hal=edit&id=<?=$data_arsipkeluar['id']?>" class="btn btn-success" >Edit </a>
          <a href="?halaman=arsip_suratkeluar&hal=hapus&id=<?=$data_arsipkeluar['id']?>" class="btn btn-danger" 
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
      <a class="page-link" href="?halaman=arsip_suratkeluar&tab=<?php echo $page-1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
      <?php for ($i=1; $i<=$pages ; $i++){ ?>
    <li class="page-item"><a class="page-link" href="?halaman=arsip_suratkeluar&tab=<?php echo $i; ?>"><?php echo $i; ?></a></li>
     <?php } ?>
    <li class="page-item">
      <a class="page-link" href="?halaman=arsip_suratkeluar&tab=<?php echo $page+1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</div>
  </div>
</div>