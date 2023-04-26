import { useNavigate } from 'react-router-dom';
import ButtonWhite from '../components/ButtonWhite';
import Title from '../components/Title';
import CardUpdatePassword from '../components/CardUpdatePassword';
import CardSsh from '../components/CardSsh';

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
    <div className="flex-col justify-between">
      <div className="flex justify-between m-4">
        <ButtonWhite onClick={toHomePage} name="Retour" />
        <ButtonWhite onClick={toLogout} name="Déconnexion" />
      </div>
      <div className="text-center">
        <Title name="Profil" />
      </div>
      <div className="flex flex-col md:flex-row">
        <div className="flex-1">
          <CardSsh />
        </div>
        <div className="flex-1 ">
          <CardUpdatePassword />
        </div>
      </div>
    </div>
  );
}
