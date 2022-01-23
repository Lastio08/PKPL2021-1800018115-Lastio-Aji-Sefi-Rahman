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
                      tbl_arsip.*,
                      tbl_departemen.nama_departemen,
                      tbl_pengirim_surat.nama_pengirim, tbl_pengirim_surat.alamat, tbl_pengirim_surat.no_hp,
                      tbl_pengirim_surat.email
                    FROM
                      tbl_arsip, tbl_departemen, tbl_pengirim_surat
                    WHERE
                      tbl_arsip.id_departemen = tbl_departemen.id_departemen
                      and tbl_arsip.id_pengirim = tbl_pengirim_surat.id_pengirim_surat 
                      and tbl_arsip.id_arsip='$_GET[id]'");
      $data = mysqli_fetch_array($tampil);
      if($data)
      {
        //jika data ditemukan, maka data ditampung ke dalam variabel
        $vno_surat = $data['no_surat'];
        $vtanggal_surat = $data['tanggal_surat'];
        $vtanggal_diterima = $data['tanggal_diterima'];
        $vwaktu_terima = $data['waktu_terima'];
        $vpenerima = $data['penerima'];
        $vprihal = $data['prihal'];
        $vid_departemen = $data['id_departemen'];
        $vnama_departemen = $data['nama_departemen'];
        $vid_pengirim = $data['id_pengirim'];
        $vnama_pengirim = $data['nama_pengirim'];
        $vfile = $data['file'];

      }

    }
    elseif($_GET['hal'] == 'hapus')
    {
      $hapus = mysqli_query($koneksi, "DELETE FROM tbl_arsip WHERE id_arsip='$_GET[id]'");
      if($hapus){
        echo "<script>
            alert('Hapus Data Sukses');
            document.location='?halaman=arsip_surat';
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

      $ubah = mysqli_query($koneksi, "UPDATE tbl_arsip SET
                                        no_surat          = '$_POST[no_surat]',
                                        tanggal_surat     = '$_POST[tanggal_surat]',
                                        tanggal_diterima  = '$_POST[tanggal_diterima]',
                                        waktu_terima      = '$_POST[waktu_terima]',
                                        penerima          = '$_POST[penerima]',
                                        prihal            = '$_POST[prihal]',
                                        id_departemen     = '$_POST[id_departemen]',
                                        id_pengirim       = '$_POST[id_pengirim]',
                                        file              = '$file'
                                      where id_arsip = '$_GET[id]' ");

      if($ubah)
      {
        echo "<script>
            alert('Ubah Data Sukses');
            document.location='?halaman=arsip_surat';
            </script>";
      }
      else{
        echo "<script>
            alert('Ubah Data Gagal');
            document.location='?halaman=arsip_surat';
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
      
      $simpan = mysqli_query($koneksi, "INSERT INTO tbl_arsip 
                                        VALUES ('',
                                                '$_POST[no_surat]', 
                                                '$_POST[tanggal_surat]',
                                                '$_POST[tanggal_diterima]',
                                                '$_POST[waktu_terima]',
                                                '$_POST[penerima]',
                                                '$_POST[prihal]',
                                                '$_POST[id_departemen]',
                                                '$_POST[id_pengirim]',
                                                '$file'
                                               ) ");
      if($simpan)
      {
        echo "<script>
            alert('Simpan Data Sukses');
            document.location='?halaman=arsip_surat';
            </script>";
      }else
      {
        echo "<script>
            alert('Simpan Data Gagal');
            document.location='?halaman=arsip_surat';
            </script>";
      }
    }


    
  }
}
}


?>


<div class="card mt-3">
  <div class="card-header bg-info text-white ">
    Form Data Arsip Surat
  </div>
  <div class="card-body">
    <form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
      <label for="no_surat">Nomor Surat</label>
      <input type="text" class="form-control" id="no_surat" name="no_surat"required value="<?=@$vno_surat?>">
    </div>
    <div class="form-group">
      <label for="tanggal_surat">Tanggal Surat</label>
      <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat"required value="<?=@$vtanggal_surat?>">
    </div>
    <div class="form-group">
      <label for="tanggal_diterima">Tanggal Diterima</label>
      <input type="date" class="form-control" id="tanggal_diterima" name="tanggal_diterima"required value="<?=@$vtanggal_diterima?>">
    </div>
    <div class="form-group">
      <label for="waktu_terima">Waktu Terima</label>
      <input type="time" class="form-control" id="waktu_terima" name="waktu_terima"required value="<?=@$vwaktu_terima?>">
    </div>
    <div class="form-group">
      <label for="penerima">Penerima</label>
      <input type="text" class="form-control" id="penerima" name="penerima"required value="<?=@$vpenerima?>">
    </div>
    <div class="form-group">
      <label for="prihal">Prihal</label>
      <input type="text" class="form-control" id="prihal" name="prihal"required value="<?=@$vprihal?>">
    </div>
    <div class="form-group">
      <label for="id_departemen">Kode Nomor Arsip</label>
      <select class="form-control" name="id_departemen">
        <option value="<?=@$vid_departemen?>/<?=@$vnama_departemen?>"><?=@$vnama_departemen?></option>
        <?php
          $tampil = mysqli_query($koneksi, "SELECT * from tbl_departemen order by nama_departemen asc");
          while($data = mysqli_fetch_array($tampil)){
            ?>
             <option value="<?=$data['id_departemen']?>/<?=$data['nama_departemen']?>"><?=$data['nama_departemen']?></option>
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
          while($data = mysqli_fetch_array($tampil)){
            echo "<option value = '$data[id_pengirim_surat]'> $data[nama_pengirim] </option> ";
          }

        ?>
      </select>
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