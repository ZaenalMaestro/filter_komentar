<?php
class FilterKomentarModel
{
   private $db;
   public function __construct()
   {
      $this->db = new Database();
   }

   function getDaftarKomentar($limit = 'LIMIT 5')
   {
      $this->db->query("SELECT * FROM komentar_user WHERE jenis_komentar = 'non_cyberbullying' ORDER BY id DESC $limit");
      return $this->db->resultSet();
   }

   function tambahKomentarBaru($komentar, $kelas)
   {
      $this->db->query("INSERT INTO komentar_user (komentar, jenis_komentar) VALUE(:komentar, :jenis_komentar)");
      $this->db->bind('komentar', $komentar);
      $this->db->bind('jenis_komentar', $kelas);
      $this->db->execute();

      return $this->db->rowCount();
   }

   /**
    * menampilkan komentar user dengan kelas cyberbullying
    */
   public function getKomentarCyberbullying()
   {
      $this->db->query("SELECT * FROM komentar_user WHERE jenis_komentar = 'cyberbullying'");
      return $this->db->resultSet();
   }
}
