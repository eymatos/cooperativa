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
	"test-app-v1/seguridad"

	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
	_ "github.com/jmoiron/sqlx"
)

/*

	query := `select * from Users;`
	q_usuarios := []Usuarios{}
	db.Select(&q_usuarios, query)

	if err != nil {
		panic(err)
	}

*/

func GetRoles(w http.ResponseWriter, r *http.Request) {

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `select * from Roles;`
	q_roles := []models.Roles{}
	db.Select(&q_roles, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(q_roles)
	db.Close()
}

func CreateRoles(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Crea Roles")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var rol models.Roles

	err = json.Unmarshal(body, &rol)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `insert into Roles(description,notes) values(:description,:notes);`
	result, err := db.NamedExec(query, rol)
	_ = result

	db.Close()

}

func ActualizaRoles(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza Roles")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var rol models.Roles

	err = json.Unmarshal(body, &rol)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `update 
	          Roles set 
			        description =case when :description IS NULL or :description = '' then description else :description end,
					notes =case when :notes IS NULL or :notes = '' then notes else :notes end 
			  where id=:id;`
	result, err := db.NamedExec(query, rol)
	_ = result

	db.Close()

}

func ActualizaRoles2(Roles string) http.Handler {
	fn := func(w http.ResponseWriter, r *http.Request) {
		//Inicio Metodo

		valida := seguridad.CheckUserRoles(Roles, r)

		_ = valida

		fmt.Fprintf(w, "hola desde Actualiza Roles2")
		body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

		if err != nil {
			panic("crap")
		}

		var rol models.Roles

		err = json.Unmarshal(body, &rol)
		if err != nil {
			panic("fuck")
		}

		/*
				db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
				query := `update
			          Roles set
					        description =case when :description IS NULL or :description = '' then description else :description end,
							notes =case when :notes IS NULL or :notes = '' then notes else :notes end
					  where id=:id;`
				result, err := db.NamedExec(query, rol)
				_ = result

				db.Close()
		*/
		//final Metodo
	}
	return http.HandlerFunc(fn)
}
