package models

/*

Notas: Usando sqlx se puede enviar un array de struct directo a json, se debe tener en cuenta que si el campo en la tabla es null el struct debe estar
definido como sql.Null, ejemplo sql.NullString. La mejor practica es evitar enviar valores nulos a las tablas

*/

type Contratistas struct {
	Id                int64  `json:"Id"`
	Id_Profile        int64  `json:"id_profile"`
	ComercialName     string `json:"ComercialName"`
	ComercialIDNumber string `json:"comercialIDNumber"`
}
