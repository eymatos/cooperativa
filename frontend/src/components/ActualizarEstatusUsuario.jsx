import React, { useState } from 'react';

const ActualizarEstatusUsuario = ({ id_user }) => {
  const [estatus, setEstatus] = useState(null);
  const [error, setError] = useState(null);

  const actualizarEstatus = async () => {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/actualizar-estatus/${id_user}/`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error('Error al actualizar el estatus');
      }

      const data = await response.json();
      setEstatus(data.estatus);
    } catch (error) {
      setError(error.message);
    }
  };

  return (
    <div>
      <button onClick={actualizarEstatus}>
        Actualizar Estatus
      </button>
      {estatus !== null && <p>Estatus actualizado a: {estatus}</p>}
      {error && <p>Error: {error}</p>}
    </div>
  );
};

export default ActualizarEstatusUsuario;
