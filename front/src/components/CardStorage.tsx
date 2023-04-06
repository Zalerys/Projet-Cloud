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
    <div className="felx flex-col text-center m-10 bg-whiteViolet rounded-sm border-2 border-violet p-4">
      <div className="mb-6">Stocakge :</div>

      <div className="flex row mb-4 space-x-3">
        <p className="basis-2/4">Stockage Serveur :</p>
      </div>
      <div className="flex row mb-4 space-x-3">
        <p className="basis-2/4">Stockage DB :</p>
      </div>
      <div className="flex justify-end">
        <Button name="Login" onClick={loadBackup} />
      </div>
    </div>
  );
};

export default CardStorage;
