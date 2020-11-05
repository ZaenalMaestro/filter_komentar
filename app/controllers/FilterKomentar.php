<?php

class FilterKomentar extends Controller
{
   private $preprocessing;
   private $klasifikasi;
   public function __construct()
   {
      $this->preprocessing = new Preprocessing();
      $this->klasifikasi   = new KlasifikasiNaiveBayes();
   }

   public function tampilKomentar()
   {
      $data['url'] = 'home';
      $this->view('template/_header', $data);
      $this->view('komentar');
      $this->view('template/_footer');
   }

   public function daftarKomentar()
   {
      if (isset($_POST['limit'])) {
         $limit = ((int) $_POST['limit'] == 5) ? 'LIMIT 5' : '';
         $data = $this->model('FilterKomentarModel')->getDaftarKomentar($limit);
      } else {
         $data = $this->model('FilterKomentarModel')->getDaftarKomentar();
      }
      echo json_encode($data);
   }

   /**
    * Fungsi untuk memproses komentar yg diinputkan user
    */
   public function postingKomentar()
   {
      // preprocessing data
      $data = $this->preprocessing->data($_POST['komentar']);
      $hasil['komentar'] = $_POST['komentar'];
      $komentar = $this->preprocessing->caseFolding($_POST['komentar']);
      $hasil['caseFolding'] = $komentar;
      $komentar = $this->preprocessing->tokenizing($komentar);
      $hasil['tokenizing'] = implode(" | ", $komentar);
      $komentar = $this->preprocessing->hapusKataGanda($komentar);
      $hasil['hapusHuruf'] = implode(" | ", $komentar);
      $komentar = $this->preprocessing->normalisasi($komentar);
      $hasil['normalisasi'] = implode(" | ", $komentar);
      $komentar = $this->preprocessing->stopword($komentar);
      $hasil['stopword'] = implode(" | ", $komentar);
      $komentar = $this->preprocessing->stemming($komentar);
      $hasil['stemming'] = implode(" | ", $komentar);
      // klasifikasi jika ada kata hasil preprocessing
      if (count($data) > 0) {
         $conditionalProbability = [];
         foreach ($data as $kata) {
            if ($this->model('KlasifikasiModel')->getProbabilitasKata($kata) !== false) {
               $conditionalProbability[] = $this->model('KlasifikasiModel')->getProbabilitasKata($kata);
            } else {
               $kosong[] = ['kata_unik' => "$kata", 'bobot_cyberbullying' => "0", 'bobot_non_cyberbullying' => "0"];
            }
         }
         // tentukan kelas komentar jika katanya ada dalam tabel conditinal probability
         if (count($conditionalProbability) > 0) {
            $hasil['probabilitasKata'] = $conditionalProbability;
            $hasil['klasifikasi'] = $this->klasifikasi->penentuanKelas($conditionalProbability);
            if ($hasil['klasifikasi']['klasifikasi'] == 'cyberbullying') {
               $this->model('FilterKomentarModel')->tambahKomentarBaru($_POST['komentar'], 'cyberbullying');
            } else {
               $this->model('FilterKomentarModel')->tambahKomentarBaru($_POST['komentar'], 'non_cyberbullying');
            }
            echo json_encode($hasil);
         } else {
            if (count($conditionalProbability) == 0) {
               $kosong = [['kata_unik' => "-", "bobot_cyberbullying" => "-", "bobot_non_cyberbullying" => "-"]];
            }
            $hasil['probabilitasKata'] = $kosong;
            $hasil['klasifikasi'] = ['cyberbullying' => '-', 'non_cyberbullying' => '-', 'klasifikasi' => 'non_cyberbullying'];
            $this->model('FilterKomentarModel')->tambahKomentarBaru($_POST['komentar'], 'non_cyberbullying');
            echo json_encode($hasil);
         }
      } else {
         $hasil['probabilitasKata'] = [
            ['kata_unik' => "-", "bobot_cyberbullying" => "-", "bobot_non_cyberbullying" => "-"]
         ];
         $hasil['klasifikasi'] = ['cyberbullying' => '-', 'non_cyberbullying' => '-', 'klasifikasi' => 'non_cyberbullying'];
         $this->model('FilterKomentarModel')->tambahKomentarBaru($_POST['komentar'], 'non_cyberbullying');
         echo json_encode($hasil);
      }
   }

   public function komentarTersaring()
   {
      $data = $this->model('FilterKomentarModel')->getKomentarCyberbullying();
      echo json_encode($data);
   }


   // public function conditionalProbability()
   // {
   //    $kataUnik = $this->klasifikasi->kataUnik();
   //    foreach ($kataUnik as $kata) {
   //       $data['kata'] = $kata['kata'];
   //       $data['bobot_cyberbullying'] = $this->klasifikasi->probabilitasKata($kata['kata'], 'cyberbullying');
   //       $data['bobot_non_cyberbullying'] = $this->klasifikasi->probabilitasKata($kata['kata'], 'non_cyberbullying');
   //       $this->model('KlasifikasiModel')->buatProbabilitasKata($data);
   //    }
   // }
}
