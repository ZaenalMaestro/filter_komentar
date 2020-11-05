<div class="row mt-5 ml-2 mr-2 mb-1" id="konten">
   <div class="col-md-3">
      <h5 class="text-center">Form Input Komentar</h5>
      <!-- ================== Input komentar ==================== -->
      <div class="row">
         <div class="col mb-2">
            <div>
               <textarea maxlength="150" id="komentar" class="form-control mb-1" rows="4" placeholder="Masukkan Komentar"></textarea>
               <button class="btn btn-secondary btn-block disabled" type="submit" name="submit" id="button-addon2">Posting Komentar</button>
            </div>
         </div>
      </div>
      <!-- <h6>Daftar komentar :</h6> -->
      <hr>
      <a href="#" class="badge mb-2 komentar" id="tampil-komentar">Tampilkan semua komentar</a>
      <!-- ================== End Input komentar ==================== -->
      <!-- ============== List Komentar ===================== -->
      <div id="list-komentar">
         <!-- List komentar -->
      </div>
      <hr>
      <!-- ==================== End List Komentar ================== -->

   </div>
   <div class="col-md mb-5">
      <h5 class="text-center">Tabel Pre-processing</h5>
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead class="thead-light">
               <tr>
                  <th scope="col">prerpocessing</th>
                  <th scope="col">Hasil Preprocessing</th>
               </tr>
            </thead>
            <tbody>
               <!-- data analisis -->
               <tr>
                  <th>Case Folding</th>
                  <td id="caseFolding"></td>
               </tr>
               <tr>
                  <th>Tokenizing</th>
                  <td id="tokenizing"></td>
               </tr>
               <tr>
                  <th>Hapus Huruf Ganda</th>
                  <td id="hapusHuruf"></td>
               </tr>
               <tr>
                  <th>Normalisasi</th>
                  <td id="normalisasi"></td>
               </tr>
               <tr>
                  <th>Stopword</th>
                  <td id="stopword"></td>
               </tr>
               <tr>
                  <th>Stemming</th>
                  <td id="stemming"></td>
               </tr>
            </tbody>

         </table>
      </div>

      <!-- Hasil prerpocessing------------ -->
      <h5 class="text-center">Tabel Analisis</h5>
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead class="thead-light">
               <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Kata</th>
                  <th scope="col">Conditional Probability<br>(Cyberbullying)</th>
                  <th scope="col">Conditional Probability<br>(Non Cyberbullying)</th>
               </tr>
            </thead>
            <tbody id="tb-analisis">
               <!-- data analisis -->
               <tr>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
               </tr>
            </tbody>
            <tfoot>
               <tr>
                  <th colspan="2">Prior Probability</th>
                  <td id="hc">-</td>
                  <td id="hnc">-</td>
               </tr>
               <tr>
                  <th colspan="2">Hasil Klasifikasi</th>
                  <td colspan="2" id="kelas" class="text-center">-</td>
               </tr>
            </tfoot>
         </table>
      </div>
      <!-- end hasil prerocessing--------- -->
   </div>
   <div class="col-md mb-5">
      <h5 class="text-center">Tabel Komentar tersaring</h5>
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead class="thead-light">
               <tr>
                  <th scope="col">No</th>
                  <th scope="col">Komentar</th>
                  <th scope="col">Jenis Komentar</th>
               </tr>
            </thead>
            <tbody id="table-filter">
               <tr>
                  <th scope="row">1</th>
                  <td></td>
                  <td></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
<script src="<?= Url::BASEURL ?>/js/script11.js"></script>