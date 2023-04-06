import { useNavigate } from 'react-router-dom';
import Button from '../components/ButtonWhite/ButtonWhite';
export default function ServeurContent() {
  const navigate = useNavigate();

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/login');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/homepage');
  };
  return (
    <div className="flex justify-between">
      <div className="m-4">
        <Button onClick={toHomePage} name="Retour" />
      </div>
      <div className="m-4">
        <Button onClick={toLogout} name="Déconnexion" />
      </div>
    </div>
  );
}
