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

/*

	query := `select * from Users;`
	q_usuarios := []Usuarios{}
	db.Select(&q_usuarios, query)

	if err != nil {
		panic(err)
	}

*/

func CrearPerfiles(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "Inicio funcion Crea Perfiles backend")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("Error al leer request desde cliente React frontend")
	}

	var perfil models.Perfiles

	err = json.Unmarshal(body, &perfil)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `InsertServicesContracts()`
	result, err := db.NamedExec(query, perfil)
	_ = result

	db.Close()

}
