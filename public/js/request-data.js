const btnPengujian = document.querySelector('.btn-pengujian');
const loader = document.querySelector('#loader');
btnPengujian.addEventListener('click', getHasilTesting);

function getHasilTesting() {
   document.querySelector('.margin-top').style.marginTop = '55px';   
   loader.style.display = 'block';
   btnPengujian.style.display = 'none';

   let xhr = new XMLHttpRequest;
   xhr.open('GET', 'http://localhost/filter_komentar/public/Testing/confusionMatrix');
   xhr.onload = function () {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
         let data = JSON.parse(this.responseText);
         // tp
         const tp = document.getElementsByClassName('tp');
         for (let i in tp) {
            tp[i].innerHTML = data['confusion_matrix']['TP'];
         }
         // tn
         const tn = document.getElementsByClassName('tn');
         for (let i in tn) {
            tn[i].innerHTML = data['confusion_matrix']['TN'];
         }
         const fp = document.getElementsByClassName('fp');
         for (let i in fp) {
            fp[i].innerHTML = data['confusion_matrix']['FP'];
         }
         const fn = document.getElementsByClassName('fn');
         for (let i in fn) {
            fn[i].innerHTML = data['confusion_matrix']['FN'];
         }
         document.getElementById('akurasi').innerHTML = data['akurasi'];
         const presisi = document.getElementsByClassName('presisi');
         for (let i in presisi) {
            presisi[i].innerHTML = data['presisi']
         }
         const recall = document.getElementsByClassName('recall');
         for (let i in recall) {
            recall[i].innerHTML = data['recall'];
         }
         document.getElementById('f1-score').innerHTML = data['f1-score'];

         document.querySelector('.margin-top').style.marginTop = '0';   
         btnPengujian.style.display = 'block';
         loader.style.display = 'none';
      }
   }
   xhr.send();
}

// function getDataTesting() {
//    let xhr = new XMLHttpRequest;
//    xhr.open('GET', 'http://localhost/filter_komentar/public/Testing/tampilkanDataTesting');
//    xhr.onload = function () {
//       if (this.readyState == 4 && this.status == 200) {
//          console.log(this.responseText);
//          let data = JSON.parse(this.responseText);
//          // tp
//          let table = '';
//          let nomor = 1;
//          for (let i in data['data_testing']) {
//             table += '<tr>' +
//                '<th scope="row">' + nomor + '</th>' +
//                '<td scope="row">' + data['data_testing'][i]['komentar'] + '</td>' +
//                '<td scope="row">' + data['data_testing'][i]['kelas'] + '</td>' +
//                '</tr >';
//             nomor++;
//          }
//          document.getElementById('data-testing').innerHTML = table;
//       }
//    }
//    xhr.send();

// }

