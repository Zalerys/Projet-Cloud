import ReactDOM from 'react-dom/client';
import reportWebVitals from './utils/reportWebVitals';
import App from './App';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement,
);

root.render(<App />);

reportWebVitals();
