import ButtonWhite from '../components/ButtonWhite';
import Button from '../components/Button';
import CardCreateSite from '../components/CardCreateSite';
import { useNavigate } from 'react-router-dom';
import { useState } from 'react';
import '../index.css';

export default function HomepageContent() {
  const navigate = useNavigate();
  const [afficherComposant, setAfficherComposant] = useState(false);

  function handleClick() {
    setAfficherComposant(true);
  }

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toProfil = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/profil');
  };

  return (
    <div className={afficherComposant ? 'backdrop-blur' : ''}>
      <div className="flex justify-between">
        <div className="m-4">
          <ButtonWhite onClick={toProfil} name="Profil" />
        </div>
        <div className="m-4">
          <ButtonWhite onClick={toLogout} name="Déconnexion" />
        </div>
      </div>
      <div className="mt-10 text-center">
        <Button
          name="Create your server"
          onClick={handleClick}
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet mb-16'}
        />
        {afficherComposant && <CardCreateSite />}
      </div>
    </div>
  );
}
