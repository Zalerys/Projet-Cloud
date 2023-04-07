import React from 'react';
import { useNavigate } from 'react-router-dom';
import { useState } from 'react';
import Input from '../components/Input';
import Button from '../components/Button';
import Title from '../components/Title';
import { postFetch } from '../controller/postFetch';

export default function AuthenticationContent() {
  const navigate = useNavigate();
  const [err, setErr] = useState<string | null>('');

  const [state, setState] = useState({
    name: '',
    password: '',
    key_ssh: '',
  });

  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function register() {
    if ((await postFetch('/auth/register', state)) === false) {
      setErr('Account already created or invalid');
    } else {
      sessionStorage.setItem('user', state.name);
      navigate('/homepage');
    }
  }

  return (
    <div className="relative m-auto text-center ">
      <Title name={'Create your account!'} />

      <form className="flex flex-col items-center gap-7" action="post">
        <Input
          placeholder="Name"
          required={true}
          key="name"
          onChange={(event) => handleChange(event, 'name')}
        />
        <Input
          placeholder="Password"
          required={true}
          key="password"
          onChange={(event) => handleChange(event, 'password')}
        />
        <Input
          placeholder="Key ssh"
          onChange={(event) => handleChange(event, 'key_ssh')}
        />
        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'}
          name="Register"
          onClick={register}
        />
      </form>
      <span className="absolute mb-3 text-sm italic left-5 bottom-24 text-violet">
        Optional
      </span>
    </div>
  );
}
