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
    username: '',
    email: '',
    password: '',
    // key_ssh: '',
  });

  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function register() {
    const reponse = await postFetch('/api/register', state);
    if (reponse === false) {
      console.log(reponse);
      // setErr('Account already created or invalid');
    } else {
      sessionStorage.setItem('user', reponse.token);
      navigate('/homepage');
    }
  }

  return (
    <div className="relative m-auto text-center ">
      <Title name={'Create your account!'} />

      <div className="flex flex-col items-center gap-7">
        <Input
          placeholder="username"
          required={true}
          key="username"
          onChange={(event) => handleChange(event, 'username')}
        />
        <Input
          placeholder="email"
          required={true}
          key="email"
          onChange={(event) => handleChange(event, 'email')}
        />
        <Input
          placeholder="password"
          required={true}
          key="password"
          onChange={(event) => handleChange(event, 'password')}
        />
        {/* <Input
          placeholder="Key ssh"
          onChange={(event) => handleChange(event, 'key_ssh')}
        /> */}
        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'}
          name="Register"
          onClick={register}
        />
      </div>
      {/* <span className="absolute mb-3 text-sm italic left-5 bottom-24 text-violet">
        Optional
      </span> */}
    </div>
  );
}
