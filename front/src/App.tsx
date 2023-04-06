import './index.css';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Authentication from './layouts/Authentication';
import Home from './layouts/Homepage';
import Profil from './layouts/Profil';
import Serveur from './layouts/Serveur';

function App() {
  return (
    <div>
      <BrowserRouter>
        <Routes>
          <Route path="/homepage" element={<Home />} />
          <Route path="/authentication" element={<Authentication />} />
          <Route path="/server" element={<Serveur />} />
          <Route path="/profil" element={<Profil />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}
export default App;
