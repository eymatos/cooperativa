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
	query := `insert into prestamos_normales(cedula) 
	          values(:cedula);`
	result, err := db.NamedExec(query, prestamo)
	if err != nil {
		panic("Here we go")
	}
	_ = result
	db.Close()
}
