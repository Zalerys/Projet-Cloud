import './index.css';
import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Register from './layouts/Register';
import Login from './layouts/Login';
import Home from './layouts/Homepage';
import Profil from './layouts/Profil';
import Serveur from './layouts/Serveur';

function App() {
  return (
    <div>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/register" element={<Register />} />
          <Route path="/login" element={<Login />} />
          <Route path="/serveur" element={<Serveur />} />
          <Route path="/profil" element={<Profil />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}
export default App;
