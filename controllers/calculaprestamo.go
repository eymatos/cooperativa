package controllers

import (
	"encoding/json"
	_ "encoding/json"
	"fmt"
	"io"
	"io/ioutil"
	"log"
	"math"
	"net/http"
	"strconv"
	_ "test-app-v1/configuraciones"
	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	_ "github.com/jmoiron/sqlx"
)

//Funcion que redondea un float a los numeros de decimales que se le manden, ver linea 46 para ejemplo
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

	//calculando el interes mensual.
	var interes_mensual = float64(calculaprestamo.Interes) / 100.00 / 12
	calculopow := math.Pow((1 + interes_mensual), (float64(calculaprestamo.Meses)))
	cuotaMensual := (calculaprestamo.Importe * interes_mensual * calculopow) / (calculopow - 1)

	fmt.Println(strconv.FormatFloat(roundFloat(cuotaMensual, 2), 'f', -1, 64))

	// Retorna respuesta en Json corrigiendo el error que tira postmant
	w.Header().Set("Content-Type", "application/json")
	resp := make(map[string]string)
	resp["message"] = "Status Created"
	jsonResp, err := json.Marshal(resp)
	if err != nil {
		log.Fatalf("Error happened in JSON marshal. Err: %s", err)
	}
	w.Write(jsonResp)
	return

}
