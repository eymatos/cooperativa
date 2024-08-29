import { useState } from "react";
import api from "../api";
import "../styles/CreateUser.css";

function CreateUser() {
    const [formData, setFormData] = useState({
        cedula: "",
        lastname: "",
        password: "",
        email: "",
        telefono: "",
        monto_ahorro: "",
        direccion: "",
        lugar_trabajo: "",
        salario: "",
        fecha_ingreso_trabajo: "",
        direccion_trabajo: "",
        telefono_trabajo: "",
        fecha_ingreso: "",
        fecha_salida: "",
        estatus: "",
        referido_por: "",
        ultima_conexion: "",
        tipo_usuario: "",
    });

    const createUsuario = (e) => {
        e.preventDefault();
        api
            .post("/api/usuarios/", formData)
            .then((res) => {
                if (res.status === 201) {
                    alert("Usuario creado");
                } else {
                    alert("Error al crear");
                }
            })
            .catch((err) => console.log(err));
    };

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    return (
        <div>
            <h2>Crear Usuario</h2>
            <form onSubmit={createUsuario}>
                {Object.keys(formData).map((key) => (
                    <input
                        key={key}
                        type={key.includes("fecha") ? "date" : "text"}
                        name={key}
                        placeholder={key.replace("_", " ")}
                        onChange={handleInputChange}
                    />
                ))}
                <button type="submit">Crear</button>
            </form>
        </div>
    );
}

export default CreateUser;
