import React from 'react';
import { useState } from 'react';
import Title from './Title';
import Input from './Input';
import { postFetchToken } from '../controller/postFetchToken';
import { useNavigate } from 'react-router-dom';
import Button from './Button';

const CardCreateSite = () => {
  const navigate = useNavigate();

  const [state, setState] = useState({
    name: '',
    // html: '',
  });
  const [file, setFile] = useState<File | null>(null);

  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function createserver() {
    const reponse = await postFetchToken(
      '/api/servers',
      state,
      sessionStorage.getItem('user'),
    );
    if (reponse === false) {
      console.log(reponse);
    } else {
      navigate('/homepage');
    }
  }
  const handleDrop = (event: React.DragEvent<HTMLDivElement>) => {
    event.preventDefault();
    const droppedFile = event.dataTransfer.files[0];
    setFile(droppedFile);
  };

  const handleDownload = () => {
    if (!file) {
      return;
    }
    const downloadLink = URL.createObjectURL(file);
    const a = document.createElement('a');
    a.href = downloadLink;
    a.download = 'downloaded.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };

  return (
    <div className="relative z-50 max-w-sm px-12 py-6 m-auto text-center bg-white border-2 rounded-sm border-violet">
      <Title name="Fill your information" />
      <div className="flex flex-col items-center gap-10">
        <Input
          placeholder="Nom du serveur"
          required={true}
          key="name"
          onChange={(event) => handleChange(event, 'name')}
        />
        <div onDrop={handleDrop} onDragOver={(event) => event.preventDefault()}>
          {file ? (
            <Button
              type="file"
              onClick={handleDownload}
              name="Download fini"
              className={'h-10 w-40 px-6 py-2 rounded bg-grey text-violet'}
            />
          ) : (
            <Button
              type="file"
              name="+"
              className={'h-10 w-40 px-6 py-2 rounded bg-grey text-violet'}
            />
          )}
        </div>
        <Button
          onClick={createserver}
          name="To validate"
          className={'h-10 w-40 px-6 py-2 rounded bg-violet text-whiteViolet'}
        />
      </div>
    </div>
  );
};

export default CardCreateSite;
