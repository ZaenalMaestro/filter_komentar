<?php

class KlasifikasiNaiveBayes extends Controller
{
   // nC = jumlah data keseluruhan setiap kelas => cyberbullying | non cyberbullying
   public function nC($kelas)
   {
      $nc = $this->model('KlasifikasiModel')->jumlahDataKelasC($kelas);
      return intval($nc['jumlahData']);
   }

   // fi = nilai Frekwensi kemunculan setiap kata
   function fI($kata, $kelas)
   {
      $fi = $this->model('KlasifikasiModel')->frekKemunculanKata($kata, $kelas);
      return intval($fi['FrekKata']);
   }

   // nDoc = jumlah data keseluruhan kelas didalam data training 
   function nDoc()
   {
      $nDoc = $this->model('KlasifikasiModel')->jumlahDataKelas();
      return intval($nDoc['jumlahDataKelas']);
   }

   // Pc = Nc / nDoc
   function hitungPc($kelas)
   {
      $probability = $this->nC($kelas) / $this->nDoc();
      return $probability;
   }

   // P(F1, .... ,Fn)
   function hitungPfi($words, $kelas)
   {
      $pfi = [];
      for ($i = 0; $i < count($words); $i++) {
         $nKelas = $this->nDoc();
         $fi = $this->fI($words[$i], $kelas);
         $pfi[] = ($fi + 1) / ($nKelas + 2);
      }

      return $pfi;
   }

   function nilaiHC($pC, $pfi)
   {
      $hasil = 1;
      for ($i = 0; $i < count($pfi); $i++) {
         $hasil = $hasil * $pfi[$i];
      }
      $hasilHC = $hasil * $pC;

      return $hasilHC;
   }

   function NaiveBayes($word)
   {
      if (count($word) == 0) {
         return 'word empty';
      } else {
         $kelas = ['cyberbullying', 'non_cyberbullying'];
         for ($i = 0; $i < count($kelas); $i++) {
            $pc = $this->hitungPc($kelas[$i]);
            $pfi = $this->hitungPfi($word, $kelas[$i]);
            $nilai["$kelas[$i]"] =  $this->nilaiHC($pc, $pfi);
         }
         if ($nilai['cyberbullying'] > $nilai["non_cyberbullying"]) {
            return 'cyberbullying';
         } else {
            return 'non_cyberbullying';
         }
      }
   }
}
