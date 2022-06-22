package models

type ListarPaisesCliente struct {
	Id              int64  `json:"id"`
	Name            string `json:"name"`
	Iso3            string `json:"iso3"`
	Numeric_code    string `json:"numeric_code"`
	Iso2            string `json:"Iso2"`
	Phonecode       string `json:"Phonecode"`
	Capital         string `json:"Capital"`
	Currency        string `json:"Currency"`
	Currency_name   string `json:"Currency_name"`
	Currency_symbol string `json:"Currency_symbol"`
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
