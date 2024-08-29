import React from "react"
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom"
import Login from "./pages/Login"
import Register from "./pages/Register"
import Home from "./pages/Home"
import CreateUser from "./pages/CreateUser"
import NotFound from "./pages/NotFound"
import ProtectedRoute from "./components/ProtectedRoute"
import UsuarioDesactivados from "./pages/UsuariosDesactivados"

function Logout() {
  localStorage.clear()
  return <Navigate to="/login" />
}

function RegisterAndLogout() {
  localStorage.clear()
  return <Register />
}

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route
          path="/"
          element={
            <ProtectedRoute>
              <Home />
            </ProtectedRoute>
          }
        />
        <Route path="/login" element={<Login />} />
        <Route path="/logout" element={<Logout />} />
        <Route path="/register" element={<RegisterAndLogout />} />
        <Route path="/home" element={<Home />} />
        <Route path="*" element={<NotFound />}></Route>
        <Route path="/create-user" element={<CreateUser />} />
        <Route path="/usuarios-desactivados" element={<UsuarioDesactivados />} />
      </Routes>
    </BrowserRouter>
  )
}

export default App