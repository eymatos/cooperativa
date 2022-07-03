package controllers

import (
	"encoding/json"
	_ "encoding/json"
	"fmt"
	"io"
	"io/ioutil"
	"math"
	"net/http"
	"strconv"
	_ "test-app-v1/configuraciones"
	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	_ "github.com/jmoiron/sqlx"
)

func roundFloat(val float64, precision uint) float64 {
	ratio := math.Pow(10, float64(precision))
	return math.Round(val*ratio) / ratio
}

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

	var interes_mensual = float64(calculaprestamo.Interes) / 100.00 / 12
	calculopow := math.Pow((1 + interes_mensual), (float64(calculaprestamo.Meses)))
	cuotaMensual := (calculaprestamo.Importe * interes_mensual * calculopow) / (calculopow - 1)

	fmt.Println(strconv.FormatFloat(roundFloat(cuotaMensual, 2), 'f', -1, 64))
}
