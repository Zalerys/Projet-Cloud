import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import CardDBUser from '../components/CardDBUser';
import CardStorage from '../components/CardStorage';
import CardListBackup from '../components/CardListBackup';
import Title from '../components/Title';
import ButtonWhite from '../components/ButtonWhite';
import { postFetch } from '../controller/postFetch';
import { getFetch } from '../controller/getFetch';
import Button from '../components/Button';

interface Server {
  id: number;
  name: string;
  auto_backups_time: string | null;
  backups_folder_path: string | null;
  created_at: string | null;
  dbs: any;
  storage_size: any;
}

export default function ServeurContent() {
  const navigate = useNavigate();
  const [state, setState] = useState({
    server: sessionStorage.getItem('server'),
    user: sessionStorage.getItem('user'),
  });

  const [server, setServer] = useState<Server>();

  const toLogout = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('user');
    sessionStorage.removeItem('server');
    navigate('/authentication');
  };

  const toHomePage = (event: React.MouseEvent<HTMLButtonElement>) => {
    sessionStorage.removeItem('server');
    navigate('/homepage');
  };

  async function deleteServer() {
    if ((await postFetch('/deleteserver', state)) === false) {
      console.log('failed to connect');
    } else {
      console.log('server delete');
      sessionStorage.removeItem('server');
      navigate('/homepage');
    }
  }

  useEffect(() => {
    const fetchData = async () => {
      const reponse = await getFetch(
        `/api/servers/${state.server}`,
        sessionStorage.getItem('user'),
      );
      console.log(reponse);
      setServer(reponse);
    };

    fetchData();
  }, []);

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
        <Title name={'Server: ' + server?.name} />
      </div>
      <div className="flex flex-col gap-4 lg:flex-row">
        <div className="flex-1 w-90">
          <CardListBackup
            time={server?.created_at}
            auto={server?.auto_backups_time}
            path={server?.auto_backups_time}
            dbs={server?.dbs}
          />
        </div>
        <div>
          <CardDBUser name="testname" password="testpassword" />
          <CardStorage server={server?.storage_size} />
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
