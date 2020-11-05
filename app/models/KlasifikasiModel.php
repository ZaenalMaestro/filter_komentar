<?php
class KlasifikasiModel
{
   private $db;
   public function __construct()
   {
      $this->db = new Database();
   }

   /**
    * Request seluruh dokumen dari tabel data_training
    */
   public function getTotalDokumen()
   {
      $this->db->query('SELECT count(dokumen) as dokumen FROM data_training');
      return $this->db->single();
   }

   /**
    * Request seluruh dokumen dari tabel data_training berdasarkan kelas
    */
   public function getJumlahDokumen($kelas)
   {
      $this->db->query('SELECT count(dokumen) as dokumen_kelas FROM data_training WHERE kelas = :kelas');
      $this->db->bind('kelas', $kelas);
      return $this->db->single();
   }

   /**
    * Request seluruh jumlah kata dari tabel vocabulary berdasarkan kelasnya 
    */
   public function getJumlahKata($kata, $kelas)
   {
      $query = "SELECT count(kemunculan_kata.kata) AS kata FROM data_training 
         INNER JOIN kemunculan_kata on data_training.id_datatraining = kemunculan_kata.id_datatraining 
         where kata = :kata and kelas= :kelas";

      $this->db->query($query);
      $this->db->bind('kata', $kata);
      $this->db->bind('kelas', $kelas);

      return $this->db->single();
   }

   /**
    * request jumlah seluruh kata pada tabel vocabulary berdasarkan kelas
    */
   public function getTotalKata($kelas)
   {
      $query = "SELECT count(kemunculan_kata.kata) AS kata FROM data_training 
         INNER JOIN kemunculan_kata on data_training.id_datatraining = kemunculan_kata.id_datatraining 
         where kelas= :kelas";

      $this->db->query($query);
      $this->db->bind('kelas', $kelas);
      return $this->db->single();
   }

   /**
    * Request jumlah vocabulary pada tabel vocabulary
    */
   public function getJumlahKataUnik()
   {
      $query = "SELECT DISTINCT kemunculan_kata.kata
         FROM data_training 
         INNER JOIN kemunculan_kata
         on data_training.id_datatraining = kemunculan_kata.id_datatraining";
      $this->db->query($query);

      return $this->db->resultSet();
   }

   // public function buatProbabilitasKata($data)
   // {
   //    $query = "INSERT INTO conditional_probability(kata_unik, bobot_cyberbullying, bobot_non_cyberbullying)
   //       VALUES(:kata_unik, :bobot_cyberbullying, :bobot_non_cyberbullying)";
   //    $this->db->query($query);
   //    $this->db->bind('kata_unik', $data['kata']);
   //    $this->db->bind('bobot_cyberbullying', $data['bobot_cyberbullying']);
   //    $this->db->bind('bobot_non_cyberbullying', $data['bobot_non_cyberbullying']);

   //    $this->db->execute();
   // }

 
   /**
    * Request probabilitas kata dari table conditional probability
    */
   public function getProbabilitasKata($kata)
   {
      $query = "SELECT kata_unik, bobot_cyberbullying, bobot_non_cyberbullying 
               FROM conditional_probability WHERE kata_unik = :kata";
      $this->db->query($query);
      $this->db->bind('kata', $kata);

      return $this->db->single();
   }
}
