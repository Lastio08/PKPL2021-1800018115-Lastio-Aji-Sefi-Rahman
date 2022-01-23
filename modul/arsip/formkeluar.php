<?php
  //panggil function untuk upload file
  include "config/function.php";
  
    //Uji Jika klik tombol edit / hapus
  if(isset($_GET['hal']))
  {

    if($_GET['hal'] == "edit")
    {

      //tampilkan data yang akan diedit
      $tampil = mysqli_query($koneksi, "SELECT
                      tbl_arsipkeluar.*,
                      tbl_departemen.nama_departemen,
                      tbl_pengirim_surat.nama_pengirim, tbl_pengirim_surat.alamat, tbl_pengirim_surat.no_hp,
                      tbl_pengirim_surat.email
                    FROM
                      tbl_arsipkeluar JOIN tbl_departemen ON tbl_arsipkeluar.id_departemen=tbl_departemen.id_departemen JOIN tbl_pengirim_surat ON tbl_pengirim_surat.id_pengirim_surat=tbl_arsipkeluar.id_pengirim
                    WHERE
                      tbl_arsipkeluar.id_departemen = tbl_departemen.id_departemen
                      and tbl_arsipkeluar.id_pengirim = tbl_pengirim_surat.id_pengirim_surat 
                      and tbl_arsipkeluar.id='$_GET[id]'");
      $data_arsipkeluar = mysqli_fetch_array($tampil);
      if($data_arsipkeluar)
      {
        //jika data ditemukan, maka data ditampung ke dalam variabel
        $vno_suratkeluar = $data_arsipkeluar['no_suratkeluar'];
        $vtanggal_suratkeluar = $data_arsipkeluar['tanggal_suratkeluar'];
        $vpenerima = $data_arsipkeluar['penerima'];
        $vprihal = $data_arsipkeluar['prihal'];
        $vid_departemen = $data_arsipkeluar['id_departemen'];
        $vnama_departemen = $data_arsipkeluar['nama_departemen'];
        $vid_pengirim = $data_arsipkeluar['id_pengirim'];
        $vnama_pengirim = $data_arsipkeluar['nama_pengirim'];
        $vfile = $data_arsipkeluar['file'];

      }

    }
    elseif($_GET['hal'] == 'hapus')
    {
      $hapus = mysqli_query($koneksi, "DELETE FROM tbl_arsipkeluar WHERE id='$_GET[id]'");
      if($hapus){
        echo "<script>
            alert('Hapus Data Sukses');
            document.location='?halaman=arsip_suratkeluar';
            </script>";
      }
    }
  }
  
  //uji jika tombol simpan diklik
  if(isset($_POST['bsimpan']))
  {
    
    //pengujian apakah data akan diedit / simpan baru
    if(@$_GET['hal'] == "edit"){
      //perintah edit data
      //ubah data
    
      $pecah =  explode("/", $_POST[id_departemen]);
      $id_departemen = $pecah[0];
      $nama_departemen = $pecah[1];
      //cek apakah user pilih file /gambar atau tidak
      if($_FILES['file']['error'] == 4){
          $file = $vfile;
      }else{
        $file = upload($nama_departemen);
      }

      $ubah = mysqli_query($koneksi, "UPDATE tbl_arsipkeluar SET
                                        no_suratkeluar      = '$_POST[no_suratkeluar]',
                                        tanggal_suratkeluar = '$_POST[tanggal_suratkeluar]',
                                        prihal              = '$_POST[prihal]',
                                        id_departemen       = '$id_departemen',
                                        id_pengirim         = '$_POST[id_pengirim]',
                                        penerima            = '$_POST[penerima]',
                                        file                = '$file'
                                      where id = '$_GET[id]' ");

      if($ubah)
      {
        echo "<script>
            alert('Ubah Data Sukses');
            document.location='?halaman=arsip_suratkeluar';
            </script>";
      }
      else{
        echo "<script>
            alert('Ubah Data Gagal');
            document.location='?halaman=arsip_suratkeluar';
            </script>";
      }
    }
    else
    {
      //perintah simpan data baru
      //uji jika tombol simpan diklik
  if(isset($_POST['bsimpan']))
  {
    
    //pengujian apakah data akan diedit / simpan baru
    if(@$_GET['hal'] == "tambahdata"){
      //perintah edit data
      //ubah data
    
      $pecah =  explode("/", $_POST[id_departemen]);
      $id_departemen = $pecah[0];
      $nama_departemen = $pecah[1];
      //cek apakah user pilih file /gambar atau tidak
      if($_FILES['file']['error'] == 4){
          $file = $vfile;
      }else{
        $file = upload($nama_departemen);
      }
      
      $simpan = mysqli_query($koneksi, "INSERT INTO tbl_arsipkeluar 
                                        VALUES ('',
                                                '$_POST[no_suratkeluar]', 
                                                '$_POST[tanggal_suratkeluar]',
                                                '$_POST[prihal]',
                                                '$_POST[id_departemen]',
                                                '$_POST[id_pengirim]',
                                                '$_POST[penerima]',
                                                '$file'
                                               ) ");
      if($simpan)
      {
        echo "<script>
            alert('Simpan Data Sukses');
            document.location='?halaman=arsip_suratkeluar';
            </script>";
      }else
      {
        echo "<script>
            alert('Simpan Data Gagal');
            document.location='?halaman=arsip_suratkeluar';
            </script>";
      }
    }


    
  }
}
}


?>


<div class="card mt-3">
  <div class="card-header bg-info text-white ">
    Form Data Arsip Surat Keluar
  </div>
  <div class="card-body">
    <form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
      <label for="no_surat">Nomor Surat</label>
      <input type="text" class="form-control" id="no_surat" name="no_suratkeluar"required value="<?=@$vno_suratkeluar?>">
    </div>
    <div class="form-group">
      <label for="tanggal_surat">Tanggal Surat Keluar</label>
      <input type="date" class="form-control" id="tanggal_surat" name="tanggal_suratkeluar"required value="<?=@$vtanggal_suratkeluar?>">
    </div>
    <div class="form-group">
      <label for="prihal">Prihal</label>
      <input type="text" class="form-control" id="prihal" name="prihal"required value="<?=@$vprihal?>">
    </div>
    <div class="form-group">
      <label for="penerima">Pengirim</label>
      <input type="text" class="form-control" id="penerima" name="penerima"required value="<?=@$vpenerima?>">
    </div>
    <div class="form-group">
      <label for="id_departemen">Kode Nomor Arsip</label>
      <select class="form-control" name="id_departemen">
        <option value="<?=@$vid_departemen?>/<?=@$vnama_departemen?>"><?=@$vnama_departemen?></option>
        <?php
          $tampil = mysqli_query($koneksi, "SELECT * from tbl_departemen order by nama_departemen asc");
          while($data_arsipkeluar = mysqli_fetch_array($tampil)){
            ?>
             <option value="<?=$data_arsipkeluar['id_departemen']?>/<?=$data_arsipkeluar['nama_departemen']?>"><?=$data_arsipkeluar['nama_departemen']?></option>
            <!-- <option value = '$data[id_departemen]."/".nama_departemen'> $data[nama_departemen] </option>  -->
         <?php
          }

        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="id_pengirim">Pengirim Surat</label>
      <select class="form-control" name="id_pengirim">
        <option value="<?=@$vid_pengirim?>"><?=@$vnama_pengirim?></option>
        <?php
          $tampil = mysqli_query($koneksi, "SELECT * from tbl_pengirim_surat order by nama_pengirim asc");
          while($data_arsipkeluar = mysqli_fetch_array($tampil)){
            echo "<option value = '$data_arsipkeluar[id_pengirim_surat]'> $data_arsipkeluar[nama_pengirim] </option> ";
          }

        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="penerima">Penerima</label>
      <input type="text" class="form-control" id="penerima" name="penerima"required value="<?=@$vpenerima?>">
    </div>
    <div class="form-group">
      <label for="file">Pilih File</label>
      <input type="file" class="form-control" id="file" name="file"required value="<?=@$vfile?>">
    </div>

    <button type="submit" name="bsimpan" class="btn btn-primary">Simpan</button>
    <button type="reset" name="bbatal" class="btn btn-danger">Batal</button>
  </form>
  </div>
</div>