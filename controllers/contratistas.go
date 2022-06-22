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

func GetContratistas(w http.ResponseWriter, r *http.Request) {

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `select id, id_profile, comercialname, comercialidnumber from Contractors;`
	q_Contratistas := []models.Contratistas{}
	db.Select(&q_Contratistas, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(q_Contratistas)
	db.Close()
}

func CreateContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Crea Roles")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var contratista models.Contratistas

	err = json.Unmarshal(body, &contratista)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `insert into Contractors (id_profile,comercialname,comercialidnumber)
	values(:id_profile,:comercialname,:comercialidnumber)
	;`
	result, err := db.NamedExec(query, contratista)
	_ = result

	db.Close()

}

func ActualizaContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza Contratista")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var contratista models.Contratistas

	err = json.Unmarshal(body, &contratista)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `update 
	Contractors set 
					id_profile =case when :id_profile IS NULL or :id_profile = '' then id_profile else :id_profile end,
					comercialname =case when :comercialname IS NULL or :comercialname = '' then comercialname else :comercialname end,
					comercialidnumber =case when :comercialidnumber IS NULL or :comercialidnumber = '' then comercialidnumber else :comercialidnumber end  
			  where id=:id;`
	result, err := db.NamedExec(query, contratista)
	_ = result

	db.Close()

}
