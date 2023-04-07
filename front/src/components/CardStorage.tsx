import React, { useState } from 'react';
import Button from '../components/Button';
import { postFetch } from '../controller/postFetch';

interface Props {
  storageDB?: string;
  storageFolder?: string;
  serveur?: string;
}

const CardStorage = ({ storageDB = '', storageFolder = '', serveur = '' }) => {
  async function loadBackup() {
    if ((await postFetch('/serveur/backup', serveur)) === false) {
    } else {
      console.log('Erreur Backup');
    }
  }
  return (
    <div className="flex-col p-4 m-10 text-center border-2 rounded-sm felx bg-whiteViolet border-violet">
      <div className="mb-6">Stocakge :</div>

      <div className="flex mb-4 space-x-3 row">
        <p className="basis-2/4">Stockage Serveur :</p>
      </div>
      <div className="flex mb-4 space-x-3 row">
        <p className="basis-2/4">Stockage DB :</p>
      </div>
      <div className="flex justify-end">
        <Button className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'} name="Login" onClick={loadBackup} />
      </div>
    </div>
  );
};

export default CardStorage;
