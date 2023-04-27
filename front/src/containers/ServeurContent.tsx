import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import CardDBUser from '../components/CardDBUser';
import CardStorage from '../components/CardStorage';
import CardListBackup from '../components/CardListBackup';
import Title from '../components/Title';
import ButtonWhite from '../components/ButtonWhite';

export default function ServeurContent() {
  const navigate = useNavigate();

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/homepage');
  };

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
    </div>
  );
}
