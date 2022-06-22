package seguridad

import (
	"fmt"
	"net/http"
	"strings"
	"test-app-v1/configuraciones"
	"test-app-v1/models"

	"github.com/dgrijalva/jwt-go"
	"github.com/jmoiron/sqlx"
)

func CheckUserRoles(Roles string, r *http.Request) bool {
	var validacion bool

	authorizationHeader := r.Header.Get("Authorization")
	if authorizationHeader != "" {
		bearerToken := strings.Split(authorizationHeader, " ")
		if len(bearerToken) == 2 {
			token, err := jwt.Parse(bearerToken[1], func(token *jwt.Token) (interface{}, error) {
				if _, ok := token.Method.(*jwt.SigningMethodHMAC); !ok {
					return nil, fmt.Errorf("Unauthorized")
				}
				return secretKey, nil

			})
			if err != nil {
				fmt.Println("Error Generando el Json Web Token " + err.Error())
			}
			if token.Valid {
				if claims, ok := token.Claims.(jwt.MapClaims); ok && token.Valid {
					//El token es valido, el usuario esta logeado de forma correcto y esta identificado.
					correo := claims["user_email"]

					db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
					query := `
					select u.username,u.email,
						   GROUP_CONCAT(distinct r.description order by r.description asc) roles,
                           GROUP_CONCAT(distinct p.name order by p.name asc) permissions,
                           max(r.level)level
                    from Users u 
					left join UserRoles ur on ur.user_id=u.id
					left join Roles r on r.id =ur.role_id
					left join RolePermissions rp on r.id=rp.role_id
					left join Permissions p on rp.permission_id =p.id
					where 1=1
					and u.name is not null
					and u.email = ?					
				    group by u.username,u.email order by max(r.level) asc;`
					var q_roles models.UserRolPerm
					err = db.Get(&q_roles, query, correo)

					if err != nil {
						panic(err)
					}

					roles_requeridos := strings.Split(Roles, ",")
					//busqueda de roles
					// Contains tells whether a contains x.

					for _, rol_a_buscar := range roles_requeridos {
						if strings.Contains(q_roles.Roles, rol_a_buscar) {
							validacion = true
						}
					}

					//fin de busqueda de roles

					fmt.Println(claims["email"])
				} else {
					fmt.Println(err)
				}
			}
		}
	}

	return validacion

}
