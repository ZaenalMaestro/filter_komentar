<?php

class KlasifikasiNaiveBayes extends Controller
{

   /**
    *  Total Komentar
    */
   public function totalDokumen()
   {
      $total = $this->model('KlasifikasiModel')->getTotalDokumen();
      return (int) $total['dokumen'];
   }

   /**
    *  Jumlah dokumen berdasarkan kelas 
    */
   public function jumlahDokumen($kelas)
   {
      $jumlah = $this->model('KlasifikasiModel')->getJumlahDokumen($kelas);
      return (int) $jumlah['dokumen_kelas'];
   }

   /**
    * prior probability
    * Hitung probabilitas setiap kelas
    */
   public function probabilitasKelas($kelas)
   {
      $probabilitasKelas = $this->jumlahDokumen($kelas) / $this->totalDokumen();
      return $probabilitasKelas;
   }

   /**
    * count(w | c) = jumlah kemumculan kata yg diuji pada tabel vocabulary untuk setiap kelas 
    */
   public function jumlahKemunculanKata($kata, $kelas)
   {
      $jumlah = $this->model('KlasifikasiModel')->getJumlahKata($kata, $kelas);
      return (int) $jumlah['kata'];
   }

   /**
    * count(c) = jumlah keseluruhan kata berdasarkan kelasnya 
    */

   public function totalKata($kelas)
   {
      $total = $this->model('KlasifikasiModel')->getTotalKata($kelas);
      return (int) $total['kata'];
   }

   /**
    * V  = vocabulary atau jumlah kosa kata unik (tidak ada kata yang duplikat). 
    */
   public function jumlahKataUnik()
   {
      $jumlahKataUnik = $this->model('KlasifikasiModel')->getJumlahKataUnik();
      return count($jumlahKataUnik);
   }

   public function kataUnik()
   {
      $jumlahKataUnik = $this->model('KlasifikasiModel')->getJumlahKataUnik();
      return $jumlahKataUnik;
   }

   /**    
    * Conditional Probabilty
    * Probabilitas(kata | kelas) => P(w | c) = (count(w| c) + 1) /(count(c) + V) 
    */
   public function probabilitasKata($kata, $kelas)
   {
      // laplance corection
      $probabilitasKata = ($this->jumlahKemunculanKata($kata, $kelas) + 1) / ($this->totalKata($kelas) + $this->jumlahKataUnik());
      return $probabilitasKata;
   }

   /**
    * Posterior probability
    * Penentuan kelas
    */

   public function penentuanKelas($conditionalProbability)
   {
      for ($i=0; $i < 2; $i++) { 
         if ($i == 0) {
            // kalikan semua nilai conditional probability kata (kelas cyberbullying);
            $probabilitasKataCybebullying = 1;
            foreach ($conditionalProbability as $cp) {
               $probabilitasKataCybebullying *= $cp['bobot_cyberbullying'];
               $bobot['cyberbullying'] = $probabilitasKataCybebullying;
            }
         }else {
            // kalikan semua nilai conditional probability kata (kelas non cyberbullying);
            $probabilitasKataNonCybebullying = 1;
            foreach ($conditionalProbability as $cp) {
               $probabilitasKataNonCybebullying *= $cp['bobot_non_cyberbullying'];
               $bobot['non_cyberbullying'] = $probabilitasKataNonCybebullying;
            }
         }         
      }
      $nilai['cyberbullying'] = $this->probabilitasKelas('cyberbullying') * $probabilitasKataCybebullying;
      $nilai['non_cyberbullying'] = $this->probabilitasKelas('non_cyberbullying') * $probabilitasKataNonCybebullying;      
      $nilai['klasifikasi'] = ($nilai['cyberbullying'] > $nilai['non_cyberbullying']) ? 'cyberbullying' : 'non_cyberbullying';
      return $nilai;
   }
}
