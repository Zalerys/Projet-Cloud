import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { getFetch } from '../controller/getFetch';
import Title from '../components/Title';
import ButtonWhite from '../components/ButtonWhite';
import CardCreateSite from '../components/CardCreateSite';

export default function CreateServeurContent() {
  const navigate = useNavigate();

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    navigate('/authentication');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/homepage');
  };

  return (
    <div>
      <div className="flex justify-between">
        <div className="m-4">
          <ButtonWhite onClick={toHomePage} name="Retour" />
        </div>
        <div className="m-4">
          <ButtonWhite onClick={toLogout} name="Déconnexion" />
        </div>
      </div>
      <div className="text-center">
        <Title name="Create Serveur" />
      </div>
      <div className="flex gap-4">
        <CardCreateSite />
      </div>
    </div>
  );
}
