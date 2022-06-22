/*
Aqui se definen las funciones  de capa de negocio, estas funciones son asignadas en routes para que sean ejecutdas cuando se llame una ruta

Notas: A JSON object is a key-value data format that is typically rendered in curly braces.
ejemplo: {Resultado:valor}, el hecho de enviar un objeto a la funcion marshal o encode no lo hace un json
debe tener el formato debido.

*/

package main

import (
	_ "context"
	"encoding/json"
	"fmt"
	"net/http"

	_ "github.com/go-sql-driver/mysql"
)

func homePage(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "HomePage Endpoint testing")
}

func getqueryUsuarios(w http.ResponseWriter, r *http.Request) {

	db, err := createConnection()
	query := `select * from Users;`
	q_usuarios := []Usuarios{}
	db.Select(&q_usuarios, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(q_usuarios)
	db.Close()
}
