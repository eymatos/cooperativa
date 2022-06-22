package models

/*

Notas: Usando sqlx se puede enviar un array de struct directo a json, se debe tener en cuenta que si el campo en la tabla es null el struct debe estar
definido como sql.Null, ejemplo sql.NullString. La mejor practica es evitar enviar valores nulos a las tablas

*/

type Roles struct {
	Id          int64  `json:"id"`
	Description string `json:"description"`
	Notes       string `json:"notes"`
	Level       int64  `json:"level"`
}

type UserRolPerm struct {
	Username    string
	Email       string
	Roles       string
	Permissions string
	Level       string
}
