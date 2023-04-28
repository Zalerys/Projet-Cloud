import { useNavigate } from 'react-router-dom';
import { useState } from 'react';
import ButtonWhite from '../components/ButtonWhite';
import Title from '../components/Title';
import CardUpdatePassword from '../components/CardUpdatePassword';
import CardSsh from '../components/CardSsh';
import Button from '../components/Button';
import { deleteFetch } from '../controller/deleteFetch';

export default function ProfilContent() {
  const navigate = useNavigate();

  const [state, setState] = useState({
    user: sessionStorage.getItem('user'),
  });

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/homepage');
  };

  async function deleteUser() {
    const reponse = await deleteFetch(
      `/api/users/${sessionStorage.getItem('pseudo')}`,
      state,
      sessionStorage.getItem('user'),
    );
    if (reponse === false) {
      console.log(reponse);
    } else {
      sessionStorage.removeItem(reponse.token);
      navigate('/homepage');
    }
  }

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
      <div className="flex-1 mt-20 mr-10 text-end">
        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-red'}
          name="Delete User"
          onClick={deleteUser}
        />
      </div>
    </div>
  );
}
