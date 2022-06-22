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

/*id, id_servicesContract, id_profile, id_contractor, Customer_review, Contractor_review, Customer_rating, Contractor_rating

 */

func GetFeedbackCalificacion(w http.ResponseWriter, r *http.Request) {

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `select id, id_servicescontract, id_profile, id_contractor, customer_review, contractor_review, customer_rating, contractor_rating
	from ServicesContractsReviews;`

	q_FeedbackCalificacion := []models.FeedbackCalificacion{}
	db.Select(&q_FeedbackCalificacion, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(q_FeedbackCalificacion)
	db.Close()
}

func CreateFeedbackCalificacionContratista(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Feedback y Clasificaion Contratista")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var FeedbackCalificacionContratista models.FeedbackCalificacionContratista

	err = json.Unmarshal(body, &FeedbackCalificacionContratista)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `insert into ServicesContractsReviews (id_servicescontract, id_profile, id_contractor, contractor_review, contractor_rating)
	values(:id_servicescontract, :id_profile, :id_contractor, :contractor_review, :contractor_rating)
	;`
	result, err := db.NamedExec(query, FeedbackCalificacionContratista)
	_ = result

	db.Close()

}

func CreateFeedbackCalificacionCliente(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Feedback y Clasificaion Contratista")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var FeedbackCalificacionCliente models.FeedbackCalificacionCliente

	err = json.Unmarshal(body, &FeedbackCalificacionCliente)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `insert into ServicesContractsReviews (id_servicescontract, id_profile, id_contractor, customer_review, customer_rating)
	values(:id_servicescontract, :id_profile, :id_contractor, :customer_review, :customer_rating)
	;`
	result, err := db.NamedExec(query, FeedbackCalificacionCliente)
	_ = result

	db.Close()

}

/*
func ActualizaUbicacionServContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza Contratista")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var UbicacionServContratistas models.UbicacionServContratistas

	err = json.Unmarshal(body, &UbicacionServContratistas)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `update
	ServicesSupplierLocations set
				id_servicessupplier =case when :id_servicessupplier IS NULL or :id_servicessupplier = '' then id_servicessupplier else :id_servicessupplier end,
				id_country =case when :id_country IS NULL or :id_country = '' then id_country else :id_country end,
				id_state =case when :id_state IS NULL or :id_state = '' then id_state else :id_state end,
				id_city =case when :id_city IS NULL or :id_city = '' then id_city else :id_city end,
				available =case when :available IS NULL or :available = '' then available else :available end
			  where id=:id;`
	result, err := db.NamedExec(query, UbicacionServContratistas)
	_ = result

	db.Close()

}*/
