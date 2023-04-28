import ButtonWhite from '../components/ButtonWhite';
import Button from '../components/Button';
import { useNavigate } from 'react-router-dom';
import '../index.css';

export default function HomepageContent() {
  const navigate = useNavigate();

  const toCreateSite = () => {
    navigate('/createserver');
  };

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toProfil = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/profil');
  };

  return (
    <div>
      <div className="flex justify-between h-50">
        <div className="z-50 m-4">
          <ButtonWhite onClick={toProfil} name="Profil" />
        </div>
        <div className="z-50 m-4">
          <ButtonWhite onClick={toLogout} name="Déconnexion" />
        </div>
      </div>
      <div className="flex justify-center mt-10 ">
        <Button
          name="Create your server"
          onClick={toCreateSite}
          className={
            'z-50 h-10 px-6 py-2 rounded text-whiteViolet bg-violet mb-16'
          }
        />
      </div>
    </div>
  );
}
