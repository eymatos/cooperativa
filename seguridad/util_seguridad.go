package seguridad

import (
	"encoding/json"
	"errors"
	"io/ioutil"
	"log"
	"net/http"
	"test-app-v1/configuraciones"
	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
)

var (
	ErrUserNotFound = errors.New("Usuario No Encontrado")
)

func GetUserByEmail(email string) models.Usuarios {
	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	defer db.Close()

	if err != nil {
		panic(err)
	}

	var user models.Usuarios
	query := `select * from Users where email = ?;`
	err = db.Get(&user, query, email)

	return user
}

func SignIn(email, password string) (string, error) {
	user := GetUserByEmail(email)
	if user.Id == 0 {
		return "", ErrUserNotFound
	}
	err := VerifyPasswordPlain(user.Password, password)
	if err != nil {
		return "", err
	}
	token, err := GenerateJWT(user)
	if err != nil {
		return "", err
	}
	return token, nil
}

func BodyParser(r *http.Request) []byte {
	body, _ := ioutil.ReadAll(r.Body)
	return body
}

func ToJson(w http.ResponseWriter, data interface{}, statusCode int) {
	w.Header().Set("Content-type", "application/json; charset=UTF8")
	w.WriteHeader(statusCode)
	err := json.NewEncoder(w).Encode(data)
	CheckErr(err)
}

func CheckErr(err error) {
	if err != nil {
		log.Fatal(err)
	}
}
