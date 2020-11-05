<?php

class Testing extends Controller
{
   private $preprocessing;
   private $klasifikasi;
   public function __construct()
   {
      $this->preprocessing = new Preprocessing();
      $this->klasifikasi   = new KlasifikasiNaiveBayes();
   }

   // menampilkna form testing
   public function index()
   {
      $data['url'] = 'pengujian';
      $data['sample_testing'] = $this->model('TestingModel')->getSampelTesting();
      $this->view('template/_header', $data);
      $this->view('pengujian',$data);
   }

   function tampilkanDataTesting()
   {
      $data = $this->model('TestingModel')->getSampelTesting();
      $this->view('pengujian', $data);
   }

   public function confusionMatrix()
   {
      $truePositif = 0;
      $falsePositif = 0;
      $trueNegative = 0;
      $falseNegative = 0;
      $dataTesting = $this->model('TestingModel')->getDataTesting();
      foreach ($dataTesting as $testing) {
         $conditionalProbability = [];
         $hasil = [];
         $daftarKata = explode(" ", $testing['dokumen']);
         foreach ($daftarKata as $kata) {
            if ($this->model('KlasifikasiModel')->getProbabilitasKata($kata) !== false) {
               $conditionalProbability[] = $this->model('KlasifikasiModel')->getProbabilitasKata($kata);            # code...
            }
         }
         $hasil = $this->klasifikasi->penentuanKelas($conditionalProbability);
         // hitung jumlah tp and fp -> cyberbullying
         if ($testing['kelas'] === 'cyberbullying') {
            // mencari nilai TP
            if ($testing['kelas'] == $hasil['klasifikasi']) {
               $truePositif += 1;
            } else {
               $falseNegative += 1;
            }
         } else if ($testing['kelas'] === 'non_cyberbullying') { //hitung TN 
            if ($testing['kelas'] == $hasil['klasifikasi']) {
               $trueNegative += 1;
            } else {
               $falsePositif += 1;
            }
         }
      }
      // var_dump($truePositif, $falseNegative, $trueNegative, $falsePositif, $id);die;
      $akurasi = ($truePositif + $trueNegative) / ($truePositif + $trueNegative + $falseNegative + $falsePositif);
      $presisi = $truePositif / ($truePositif + $falsePositif);
      $recall = $truePositif / ($truePositif + $falseNegative);
      $data['akurasi'] = $akurasi * 100;
      $data['presisi'] = $presisi * 100;
      $data['recall'] = $recall * 100;
      $f1_score = 2 * (($presisi * $recall) / ($presisi + $recall));
      $data['f1-score'] = $f1_score * 100;
      $data['confusion_matrix'] = [
         'TP' => $truePositif,
         'FP' => $falsePositif,
         'TN' => $trueNegative,
         'FN' => $falseNegative
      ];
      echo json_encode($data);
   }

   public function buatDataTesting()
   {
      $komentar = $this->model('TestingModel')->getSampleTesting();
      foreach ($komentar as $data) {
         $dataTesting = $this->preprocessing->data($data['komentar']);
         $dataTesting = implode(" ", $dataTesting);
         $this->model('TestingModel')->masukkanData($dataTesting, $data['kelas']);
      }
      echo 'selesai';
   }
}
