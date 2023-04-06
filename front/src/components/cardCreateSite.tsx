import React from 'react';
import { useState } from 'react';
import Title from './Title';
import Input from '../components/Input';
import { postFetch } from '../controller/postFetch';
import { useNavigate } from 'react-router-dom';
import Button from '../components/Button';

const CardCreateSite = () => {
  const [err, setErr] = useState<string | null>('');
  const navigate = useNavigate();

  const [state, setState] = useState({
    name: '',
    key_ssh: '',
  });

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

  return (
    <div className="relative z-50 max-w-sm px-12 py-6 m-auto text-center bg-white border-2 rounded-sm border-violet">
      <Title name="Fill your information" />
      <form className='flex flex-col items-center gap-10' action="post">
        <Input
          placeholder="Name"
          required={true}
          key="name"
          onChange={(event) => handleChange(event, 'name')}
        />
        <Button type="file" name='+'className={'h-10 w-40 px-6 py-2 rounded bg-grey text-violet'}/>
        <Button name='To validate' className={'h-10 w-40 px-6 py-2 rounded bg-violet text-whiteViolet'}/>
      </form>
      <span className="absolute mb-3 text-sm italic top-32 left-28 text-violet">
          Drop your website
        </span>
    </div>
  );
};

export default CardCreateSite;
