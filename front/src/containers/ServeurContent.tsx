import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import CardDBUser from '../components/CardDBUser';
import CardStorage from '../components/CardStorage';
import CardListBackup from '../components/CardListBackup';
import Title from '../components/Title';
import ButtonWhite from '../components/ButtonWhite';
import { postFetch } from '../controller/postFetch';
import Button from '../components/Button';

export default function ServeurContent() {
  const navigate = useNavigate();
  const [state, setState] = useState({
    server: '',
    user: sessionStorage.getItem('user'),
  });

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/homepage');
  };

  async function deleteServer() {
    if ((await postFetch('/deleteserver', state)) === false) {
      console.log('failed to connect');
    } else {
      console.log('server delete');
      navigate('/homepage');
    }
  }

  // async function getData() {
  //   var user = sessionStorage.getItem('user');
  //   const data = await getFetch(`/users/serveur/db/${user}`);
  //   setState({ ...state, user_id: data.id });
  // }

  return (
    <div className="flex-col">
      <div className="flex justify-between">
        <div className="m-4">
          <ButtonWhite onClick={toHomePage} name="Retour" />
        </div>
        <div className="m-4">
          <ButtonWhite onClick={toLogout} name="Déconnexion" />
        </div>
      </div>
      <div className="text-center">
        <Title name="Serveur" />
      </div>
      <div className="flex flex-col gap-4 lg:flex-row">
        <div className="flex-1 w-90">
          <CardListBackup />
        </div>
        <div>
          <CardDBUser name="testname" password="testpassword" />
          <CardStorage />
        </div>
      </div>
      <div className="flex-1 text-end mt-20 mr-10">
        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-red'}
          name="Delete Server"
          onClick={deleteServer}
        />
      </div>
    </div>
  );
}
