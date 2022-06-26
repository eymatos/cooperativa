package controllers

import (
	"encoding/json"
	_ "encoding/json"
	"fmt"
	"io"
	"io/ioutil"
	"net/http"
	"test-app-v1/configuraciones"
	_ "test-app-v1/configuraciones"

	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
	_ "github.com/jmoiron/sqlx"
)

func ActualizaPrestamo(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza prestamo")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var prestamo models.Prestamo

	err = json.Unmarshal(body, &prestamo)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `update 
	          prestamos_normales set 
			  monto     = case when :monto IS NULL or :monto ='' then monto else :monto end,
			  interes    = case when :interes IS NULL or :interes ='' then interes else :interes end,
			  plazo = case when :plazo IS NULL or :plazo ='' then plazo else :plazo end,
			  numero_prestamo = case when :numero_prestamo IS NULL or :numero_prestamo = '' then numero_prestamo else :numero_prestamo end,
			  fecha_final   = case when :fecha_final IS NULL or :fecha_final = '' then 1 else :fecha_final end,
			  primera_cuota   = case when :primera_cuota IS NULL or :primera_cuota = '' then 1 else :primera_cuota end,
			  total_pagar   = case when :total_pagar IS NULL or :total_pagar = '' then 1 else :total_pagar end,
			  tipo   = case when :tipo IS NULL or :tipo = '' then 1 else :tipo end,
			  desembolso   = case when :desembolso IS NULL or :desembolso = '' then 1 else :desembolso end,
			  prestamo_anterior   = case when :prestamo_anterior IS NULL or :prestamo_anterior = '' then 1 else :prestamo_anterior end,
			  fecha_final   = case when :fecha_final IS NULL or :fecha_final = '' then 1 else :fecha_final end         
			  where cedula=:cedula;`
	result, err := db.NamedExec(query, prestamo)
	_ = result

	db.Close()

}

func GetPrestamo(w http.ResponseWriter, r *http.Request) {

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `select * from prestamos_normales;`
	prestamos := []models.Prestamo{}
	db.Select(&prestamos, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(prestamos)
	db.Close()
}

func CreatePrestamo(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde create prestamo")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var prestamo models.Prestamo

	err = json.Unmarshal(body, &prestamo)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `INSERT INTO prestamos_normales (
		cedula, 
		monto, 
		interes, 
		plazo,
		numero_prestamo, 
		fecha_final, 
		primera_cuota, 
		total_pagar, 
		tipo, 
		desembolso, 
		prestamo_anterior, 
		fecha_final) values 
		(
			:cedula, 
			:monto, 
			:interes, 
			:plazo, 
			:numero_prestamo, 
			:fecha_final, 
			:primera_cuota, 
			:total_pagar, 
			:tipo, 
			:desembolso, 
			:prestamo_anterior, 
			:fecha_final);`
	result, err := db.NamedExec(query, prestamo)
	if err != nil {
		panic("Here we go")
	}
	_ = result
	db.Close()
}
