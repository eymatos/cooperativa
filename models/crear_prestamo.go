package models

type Prestamo struct {
	Cedula            string  `json:"cedula"`
	Monto             float64 `json:"monto"`
	Interes           int64   `json:"interes"`
	Plazo             int64   `json:"plazo"`
	Numero_prestamo   string  `json:"numero_prestamo"`
	Fecha_prestamo    string  `json:"fecha_prestamo"`
	Primera_cuota     string  `json:"primera_cuota"`
	Total_pagar       string  `json:"total_pagar"`
	Tipo              string  `json:"tipo"`
	Desembolso        float64 `json:"desembolso"`
	Prestamo_anterior string  `json:"prestamo_anterior"`
	Fecha_final       string  `json:"fecha_final"`
}
