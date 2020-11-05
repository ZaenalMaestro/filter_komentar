<div class="container-sm mt-4">
   <!-- tombol pengujian -->
   <div class="row">
      <div class="col">
         <a href="#" class="btn btn-block btn-primary btn-pengujian mb-3">Mulai Pengujian</a>
      </div>
   </div>
   <!-- end tombol pengujian -->

   <!-- animasi loading-->
   <img src="<?= Url::BASEURL ?>/img/loader.gif" id="loader">
   <!-- end animasi -->

   <div class="row margin-top">
      <div class="col-md-7">
         <!-- Table data testing -->
         <h5 class="text-center">Tabel Data Testing</h5>
         <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
               <thead class="thead-light">
                  <tr>
                     <th scope="col">No</th>
                     <th scope="col" class="text-center">Komentar</th>
                     <th scope="col">Kelas</th>
                  </tr>
               </thead>
               <tbody id="data-testing">
                  <?php $no = 1; ?>
                  <?php foreach ($data['sample_testing'] as $testing) : ?>
                     <tr>
                        <td scope="row" class="text-center"><?= $no; ?></td>
                        <td scope="row"><?= $testing['komentar'] ?></td>
                        <td scope="row"><?= $testing['kelas'] ?></td>
                     </tr>
                     <?php $no++; ?>
                  <?php endforeach; ?>

               </tbody>
               <tfoot>
                  <tr>
                     <th scope="col">No</th>
                     <th scope="col" class="text-center">Komentar</th>
                     <th scope="col">Kelas</th>
                  </tr>
               </tfoot>
            </table>
         </div>

      </div>
      <!-- end table data testing -->

      <!-- table confusion matrix -->
      <div class="col-md-5">
         <h5 class="text-center">Tabel Confusion Matrix</h5>
         <div class="table-responsive">
            <table class="table table-bordered">
               <thead class="thead-light text-center">
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Positif</th>
                     <th scope="col">Negative</th>
                  </tr>
               </thead>
               <tbody class="text-center">
                  <tr>
                     <th scope="row">Positif</th>
                     <td scope="row"><span class="tp">0</span><br><i>(True Positif)<i></td>
                     <td scope="row"><span class="fp">0</span><br><i>(False Positif)<i></td>
                  </tr>
                  <tr>
                     <th scope="row">Negative</th>
                     <td scope="row"><span class="fn">0</span><br><i>(False Negative)<i></td>
                     <td scope="row"><span class="tn">0</span><br><i>(True Negative)<i></td>
                  </tr>
               </tbody>
            </table>
            <table padding="15">
               <!-- akurasi -->
               <tr>
                  <td colspan="3">
                     <h5>Hasil Pengujian</h5>
                  </td>
               </tr>
               <tr>
                  <td class="font-weight-bolder">Akurasi</td>
                  <td>:</td>
                  <td>(TP+TN) / (TP+TN+FP+FN)</td>
               </tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td>
                     (<span class="tp">0</span> + <span class="tn">0</span>) /
                     (<span class="tp">0</span>+<span class="tn">0</span>+<span class="fp">0</span>+<span class="fn">0</span>)
                  </td>
               </tr>
               <tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td><span id="akurasi">0</span> %</td>
               </tr>
               <!-- end akurasi -->

               <!-- presisi -->
               <tr>
                  <td class="font-weight-bolder">Presisi</td>
                  <td>:</td>
                  <td>TP / (TP + FP)</td>
               </tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td>
                     <span class="tp">0</span> /
                     (<span class="tp">0</span>+<span class="fp">0</span>)
                  </td>
               </tr>
               <tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td><span class="presisi">0</span> %</td>
               </tr>
               <!-- end presisi -->

               <!-- recall -->
               <tr>
                  <td class="font-weight-bolder"><i>Recall<i></td>
                  <td>:</td>
                  <td>TP / (TP+FN)</td>
               </tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td>
                     <span class="tp">0</span> /
                     (<span class="tp">0</span>+<span class="fn">0</span>)
                  </td>
               </tr>
               <tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td><span class="recall">0</span> %</td>
               </tr>
               <!-- end recall -->

               <!-- fi score -->
               <tr>
                  <td class="font-weight-bolder">F1-score</td>
                  <td>:</td>
                  <td>2 * ((Presisi * <i>Recall</i>) / (Presisi + <i>Recall</i>))</td>
               </tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td>
                     2* (<span class="presisi">0</span> * <span class="recall">0</span>) /
                     (<span class="presisi">0</span> + <span class="recall">0</span>)
                  </td>
               </tr>
               <tr>
               <tr>
                  <td></td>
                  <td>:</td>
                  <td><span id="f1-score">0</span> %</td>
               </tr>
               <!-- end f1-score -->

            </table>
         </div>
      </div>
      <!-- end table confusion matrix -->
   </div>
</div>
</div>
<script src="<?= Url::BASEURL ?>/js/request-data.js"></script>
<!-- Page level plugins -->
<!-- <script src="<?= Url::BASEURL ?>/vendor/datatables/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" charset="utf8" src="<?= Url::BASEURL ?>/vendor/datatables/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="<?= Url::BASEURL ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?= Url::BASEURL ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
   $(document).ready(function() {
      $('#example').DataTable();
   });
</script>