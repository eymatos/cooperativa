package seguridad

import (
	"encoding/json"
	"net/http"
	"test-app-v1/models"
)

func Login(w http.ResponseWriter, r *http.Request) {
	body := BodyParser(r)
	var user models.Usuarios
	err := json.Unmarshal(body, &user)
	if err != nil {
		ToJson(w, err.Error(), http.StatusUnauthorized)
		return
	}
	token, err := SignIn(user.Email, user.Password)
	if err != nil {
		ToJson(w, err.Error(), http.StatusUnauthorized)
		return
	}
	ToJson(w, token, http.StatusOK)
}
