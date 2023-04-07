import { useNavigate } from 'react-router-dom';
import ButtonWhite from '../components/ButtonWhite';
export default function ProfilContent() {
  const navigate = useNavigate();

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/homepage');
  };
  return (
    <div className="flex justify-between">
      <div className="m-4">
        <ButtonWhite onClick={toHomePage} name="Retour" />
      </div>
      <div className="m-4">
        <ButtonWhite onClick={toLogout} name="Déconnexion" />
      </div>
    </div>
  );
}
