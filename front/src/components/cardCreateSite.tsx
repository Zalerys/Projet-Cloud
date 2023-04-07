import React from 'react';
import { useState } from 'react';
import Title from './Title';
import Input from './Input';
import { postFetch } from '../controller/postFetch';
import { useNavigate } from 'react-router-dom';
import Button from './Button';

const CardCreateSite = () => {
  const [err, setErr] = useState<string | null>('');
  const navigate = useNavigate();

  const [state, setState] = useState({
    name: '',
    key_ssh: '',
  });
  const [file, setFile] = useState<File | null>(null);

  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function register() {
    if ((await postFetch('/authentication', state)) === false) {
      setErr('Account already created or invalid');
    } else {
      sessionStorage.setItem('', state.name);
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
      <form className="flex flex-col items-center gap-10" action="post">
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
          name="To validate"
          className={'h-10 w-40 px-6 py-2 rounded bg-violet text-whiteViolet'}
        />
      </form>
    </div>
  );
};

export default CardCreateSite;
