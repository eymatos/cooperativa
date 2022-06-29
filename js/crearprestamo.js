function crearprestamo(){
let cedula = document.getElementById("cedula").value;
let tipo_prestamo = document.getElementById("tipo_prestamo").value;
let monto = document.getElementById("monto").value;
let interes = document.getElementById("interes").value;
let plazo = document.getElementById("plazo").value;
let numero_prestamo = document.getElementById("numero_prestamo").value;
let fecha_prestamo = document.getElementById("fecha_prestamo").value;
let primera_cuota = document.getElementById("primera_cuota").value;
let desembolso = document.getElementById("desembolso").value;
let prestamo_anterior = document.getElementById("prestamo_anterior").value;
let total_pagar = document.getElementById("total_pagar").value;
let fecha_final = "2022-10-01";
var settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://127.0.0.1:8081/prestamos",
  "method": "POST",
  "headers": {
    "content-type": "application/json",
    "cache-control": "no-cache",
    "postman-token": "0f85aab2-241e-da90-08bc-5f007b9c4d9d"
  },
  "processData": false,
  "data": "{\n\"cedula\": \""+cedula+"\",\n\"monto\": "+monto+",\n\"interes\": "+interes+",\n\"plazo\": "+plazo+",\n\"numero_prestamo\": \""+numero_prestamo+"\",\n\"fecha_prestamo\": \""+fecha_prestamo+"\",\n\"primera_cuota\": \""+primera_cuota+"\",\n\"total_pagar\": \""+total_pagar+"\",\n\"tipo\": \""+tipo_prestamo+"\",\n\"desembolso\": "+desembolso+",\n\"prestamo_anterior\": \""+prestamo_anterior+"\",\n\"fecha_final\": \""+fecha_final+"\"\n}"
}

$.ajax(settings).done(function (response) {
  console.log(response);
});
}