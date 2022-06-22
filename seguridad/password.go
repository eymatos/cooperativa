package seguridad

import "golang.org/x/crypto/bcrypt"

func Hash(password string) ([]byte, error) {
	return bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
}

func VerifyPassword(hashedPassword, password string) error {
	return bcrypt.CompareHashAndPassword([]byte(hashedPassword), []byte(password))
}

//funcion temporal para manejar password en texto plano
func VerifyPasswordPlain(hashedPassword, password string) error {
	password2, err := bcrypt.GenerateFromPassword([]byte(hashedPassword), 1)
	_ = err
	return bcrypt.CompareHashAndPassword(password2, []byte(password))

}
