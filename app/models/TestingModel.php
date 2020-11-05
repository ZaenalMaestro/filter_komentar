<?php

class TestingModel extends Database
{

   /**
    * mengambil data testing dari table sample komentar
    */
   public function getDataTesting()
   {
      $this->query("SELECT * FROM data_testing");
      return $this->resultSet();
   }

   public function getSampelDataTesting()
   {
      $this->query("SELECT * FROM sampel_komentar ORDER BY id_komentar");
      return $this->resultSet();
   }

   public function getSampelTesting()
   {
      $this->query("SELECT * FROM sampel_komentar where jenis_data = 'data_testing'");
      // $this->query("SELECT * FROM sampel_komentar where jenis_data = 'data_testing' and id_komentar = 307");
      return $this->resultSet();
      // $this->query("SELECT * FROM komentar_user WHERE jenis_komentar = 'cyberbullying'");
      // return $this->resultSet();
   }

   // public function masukkanData($dokumen, $kelas)
   // {
   //    $this->query("INSERT INTO data_testing(dokumen, kelas) VALUES(:dokumen, :kelas)");
   //    $this->bind('dokumen', $dokumen);
   //    $this->bind('kelas', $kelas);
   //    $this->execute();
   // }
}
