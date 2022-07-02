package controllers

import (
	"encoding/json"
	_ "encoding/json"
	"fmt"
	"io"
	"io/ioutil"
	"math"
	"net/http"
	_ "test-app-v1/configuraciones"
	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	_ "github.com/jmoiron/sqlx"
)

func CalculaPrestamo(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde calcula prestamos")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var calculaprestamo models.Calculo

	err = json.Unmarshal(body, &calculaprestamo)

	if err != nil {
		panic("fuck")
	}

	var interes_mensual = float64((calculaprestamo.Interes / 100) / 12)
	calculopow := math.Pow((1 + interes_mensual), (calculaprestamo.Meses))
	cuotaMensual := (calculaprestamo.Importe * interes_mensual * calculopow) / (calculopow - 1)
	println(math.Round(calculopow*100) / 100)
	println(math.Round(cuotaMensual*100) / 100)
}
