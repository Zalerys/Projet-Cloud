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
  });

  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function connect() {
    if ((await postFetch('/authentication', state)) === false) {
      setErr('Wrong email or password');
    } else {
      sessionStorage.setItem('user', state.password);
      navigate('/homepage');
    }
  }

  return (
    <div className="relative m-auto text-center ">
      <Title name={'Login!'} />

      <form className="flex flex-col items-center gap-7" action="post">
        <Input placeholder="Name" required={true} key="name" onChange={(event) => handleChange(event, "name")}/>
        <Input placeholder="Password" required={true} key="password" onChange={(event) => handleChange(event, "password")}/>
        <Button className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'} name="Login" onClick={connect}/>
      </form>
    </div>
  );
}
