import './index.css';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Authentication from './layouts/Authentication';
import Home from './layouts/Homepage';

function App() {
  return (
    <div>
      <BrowserRouter>
        <Routes>
          <Route path="/homepage" element={<Home />} />
          <Route path="/authentication" element={<Authentication />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}
export default App;
