// tombol posting komentar
window.onload = [loadData(), daftarCyberbullying()];
document.getElementById('button-addon2').addEventListener('click', postKomentar);
document.getElementById('komentar').addEventListener('keyup', tombolAktif);
document.getElementById('tampil-komentar').addEventListener('click', tombolTampil);
const link = document.getElementsByClassName('nav-link');


/**
 * untuk menangani jumlah komentar yang ingin ditampilkan
 */
function tombolTampil() {
   const tombolKomentar = document.getElementsByClassName('komentar')[0];
   if (tombolKomentar.classList.toggle('tampil-semua') === true) {
      let xhr = new XMLHttpRequest();
      let params = "limit=0";

      xhr.open('POST', 'http://localhost/filter_komentar/public/FilterKomentar/daftarKomentar');
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
         console.log(this.responseText);
         let daftarKomentar = JSON.parse(this.responseText);
         template = '';
         for (i in daftarKomentar) {
            template += '<div class="row mb-3">' +
               '<div class="col">' +
               '<img class="rounded-circle float-left mr-2 mr-2" src="http://localhost/filter_komentar/public/img/profile.PNG" alt="" width="30" height="30">' +
               '<div class="row">' +
               '<div class="col">' +
               '<p class="font-weight-font-weight-normal mt-1 text-left"><b class="font-weight-bolder">Unknow</b> ' + daftarKomentar[i]['komentar'] + '</p>' +
               '</div> </div> </div> </div>';
         }
         document.getElementById('list-komentar').innerHTML = template;

      }
      xhr.send(params);
      tombolKomentar.innerHTML = 'Tampilkan lebih sedikit';
   } else {
      loadData();
      tombolKomentar.innerHTML = 'Tampilkan semua komentar';
   }

}

/**
 * Untuk menangani event saat tombol post diklik
 */
function tombolAktif() {
   let komentar = document.getElementById('komentar').value;
   const tombol = document.getElementById('button-addon2');
   if (komentar === '') {
      tombol.classList.add('disabled');
      tombol.classList.replace('btn-primary', 'btn-secondary');
   } else {
      tombol.classList.remove('disabled');
      tombol.classList.replace('btn-secondary', 'btn-primary');
   }


}

/**
 * fungsi untuk mengirimkan komentar user keserver
 */
function postKomentar() {
   let komentar = document.getElementById('komentar');
   if (komentar.value != '') {
      let xhr = new XMLHttpRequest();
      let params = "komentar=" + komentar.value;

      xhr.open('POST', 'http://localhost/filter_komentar/public/FilterKomentar/postingKomentar');
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
         console.log(this.responseText);
         let respon = JSON.parse(this.responseText);         
         let tbData = '';
         let nomor = 1;
         for (let i in respon.probabilitasKata) {
            tbData += '<tr><th scope="row">' + nomor + '</th>' +
               '<td id="kata">' + respon.probabilitasKata[i]['kata_unik'] + '</td>' +
               '<td id="fi-cyberbullying">' + respon.probabilitasKata[i]['bobot_cyberbullying'] + '</td>' +
               '<td id="fi-non_cyberbullying">' + respon.probabilitasKata[i]['bobot_non_cyberbullying'] + '</td></tr>';
            nomor++;
         }

         // menampilkan data di tabel analisis sentimen
         document.getElementById('tb-analisis').innerHTML = tbData;
         document.getElementById('hc').innerHTML = respon.klasifikasi['cyberbullying'];
         document.getElementById('hnc').innerHTML = respon.klasifikasi['non_cyberbullying'];
         document.getElementById('kelas').innerHTML = respon.klasifikasi['klasifikasi'];

         // menampilkan data ditable preprocessing
         document.getElementById('caseFolding').innerHTML = respon.caseFolding;
         document.getElementById('tokenizing').innerHTML = respon.tokenizing;
         document.getElementById('hapusHuruf').innerHTML = respon.hapusHuruf;
         document.getElementById('normalisasi').innerHTML = respon.normalisasi;
         document.getElementById('stopword').innerHTML = respon.stopword;
         document.getElementById('stemming').innerHTML = respon.stemming;

         if (respon.klasifikasi['klasifikasi'] === 'cyberbullying') {
            Swal.fire({
               icon: 'error',
               title: 'Oops...',
               text: 'Terdeksi Sebagai Komentar Cyberbullying!',
            });
            daftarCyberbullying();
         } else {
            // komentar.value = ''
            loadData();
            daftarCyberbullying();
         }
      }
      xhr.send(params);
   }
}

/**
 * merequest semua komentar yang telah tersaring (komentar non cyberbullying)
 */
function loadData() {
   let xhr = new XMLHttpRequest();
   xhr.onload = function () {
      if (this.readyState == 4 && this.status == 200) {
         let daftarKomentar = JSON.parse(this.responseText);
         template = '';
         for (i in daftarKomentar) {
            template += '<div class="row mb-3">' +
               '<div class="col">' +
               '<img class="rounded-circle float-left mr-2 mr-2" src="http://localhost/filter_komentar/public/img/profile.PNG" alt="" width="30" height="30">' +
               '<div class="row">' +
               '<div class="col">' +
               '<p class="font-weight-font-weight-normal mt-1 text-left"><b class="font-weight-bolder">Unknow</b> ' + daftarKomentar[i]['komentar'] + '</p>' +
               '</div> </div> </div> </div>';
         }
         document.getElementById('list-komentar').innerHTML = template;
      }
   }
   xhr.open('GET', 'http://localhost/filter_komentar/public/FilterKomentar/daftarKomentar', true);
   xhr.send();
}

/**
 * me-request semua komentar yang cyberbullying
 */
function daftarCyberbullying() {
   let xhr = new XMLHttpRequest();
   xhr.onload = function () {
      if (this.readyState == 4 && this.status == 200) {
         let daftarKomentar = JSON.parse(this.responseText);
         let tabel = '';
         let nomor = 1;
         for (let i in daftarKomentar) {
            tabel += '<tr><th scope = "row" >' + nomor + '</th >' +
               '<td>' + daftarKomentar[i]['komentar'] + '</td>' +
               '<td>' + daftarKomentar[i]['jenis_komentar'] + '</td></tr>';
            nomor++;
         }

         document.getElementById('table-filter').innerHTML = tabel;
      }
   }
   xhr.open('GET', 'http://localhost/filter_komentar/public/FilterKomentar/komentarTersaring', true);
   xhr.send();
}

