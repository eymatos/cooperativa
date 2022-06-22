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

func GetServContratistas(w http.ResponseWriter, r *http.Request) {

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `select id, date_due, status, id_profile, id_contractor, id_servicessupplier, notes, amount_charged from ServicesContracts;`

	q_ServContratistas := []models.ServicioContratistas{}
	db.Select(&q_ServContratistas, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(q_ServContratistas)
	db.Close()
}

func CreateServContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Crea ServContratistas")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var servcontratista models.ServicioContratistas

	err = json.Unmarshal(body, &servcontratista)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `insert into ServicesContracts (date_due, status, id_profile, id_contractor, id_servicessupplier, notes, amount_charged)
	values(:date_due, :status, :id_profile, :id_contractor, :id_servicessupplier, :notes, :amount_charged)
	;`
	result, err := db.NamedExec(query, servcontratista)
	_ = result

	db.Close()

}

func ActualizaServContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza Contratista")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var servcontratista models.ServicioContratistas

	err = json.Unmarshal(body, &servcontratista)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `update 
		ServicesContracts set 
				date_due =case when :date_due IS NULL or :date_due = '' then date_due else :date_due end,
				status =case when :status IS NULL or :status = '' then status else :status end,
				id_profile =case when :id_profile IS NULL or :id_profile = '' then id_profile else :id_profile end,
				id_contractor =case when :id_contractor IS NULL or :id_contractor = '' then id_contractor else :id_contractor end,
				id_servicessupplier =case when :id_servicessupplier IS NULL or :id_servicessupplier = '' then id_servicessupplier else :id_servicessupplier end,
				notes =case when :notes IS NULL or :notes = '' then notes else :notes end,     
				amount_charged =case when :amount_charged IS NULL or :amount_charged = '' then amount_charged else :amount_charged end     
			  where id=:id;`
	result, err := db.NamedExec(query, servcontratista)
	_ = result

	db.Close()

}
