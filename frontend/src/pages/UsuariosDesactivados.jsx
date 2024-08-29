import { useState, useEffect } from "react";
import api from "../api";
import Usuario from "../components/UsuariosDesactivados";
import "../styles/Home.css";

function UsuariosDesactivados() {
    const [usuario, setUsuario] = useState([]);

    useEffect(() => {
        getUsuario();
    }, []);

    const getUsuario = () => {
        api
            .get("/api/usuarios-desactivados/")
            .then((res) => {
                setUsuario(res.data);
                console.log(res.data);
            })
            .catch((err) => console.log(err));
    };
    const activateUsuario = (id) => {
        api
            .patch(`/api/usuarios/${id}/activate/`, { is_active: true })
            .then((res) => {
                if (res.status === 200) {
                    alert("Usuario activado");
                    getUsuario(); // Actualizar la lista de usuarios
                } else {
                    alert("Error al activar el usuario");
                }
            })
            .catch((err) => console.log(err));
    };
    return (
        <div>
            <h2>Usuarios Desactivados</h2>
            {usuario.map((usuario) => (
                <Usuario usuario={usuario} onActivate={activateUsuario} key={usuario.id_user} />
            ))}
        </div>
    );
}

export default UsuariosDesactivados;
