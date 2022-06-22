package models

import "time"

type ListarActivosCliente struct {
	Id                  int64     `json:"id"`
	Date_due            time.Time `json:”date_due”`
	Status              string    `json:"status"`
	Id_profile          int64     `json:"id_profile"`
	Id_contractor       int64     `json:"id_contractor"`
	Id_servicessupplier int64     `json:"id_servicessupplier"`
	Notes               string    `json:"notes"`
	Amount_charged      float32   `json:"amount_charged"`
}

/*
{
	"date_due": "2022-06-01",
	"id_profile": "99",
	"id_contractor": "500"
	"id_servicesSupplier": "25"
	"notes": ""
	"amount_charged": "5000.00"
}
*/
