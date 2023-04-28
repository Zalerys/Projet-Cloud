import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Input from '../components/Input';
import Button from '../components/Button';
import Title from '../components/Title';
import PopUp from '../components/PopUp';
import { postFetch } from '../controller/postFetch';

export default function AuthenticationContent() {
  const navigate = useNavigate();
  const [err, setErr] = useState<string | null>('');
  const [showPopUp, setShowPopUp] = useState(false);

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

  useEffect(() => {
    if (showPopUp) {
      const timeout = setTimeout(() => {
        setShowPopUp(false);
        setErr(null);
      }, 3000);
      return () => clearTimeout(timeout);
    }
  }, [showPopUp]);

  async function register() {
    const reponse = await postFetch('/api/register', state);
    if (reponse === false) {
      setErr('Registration failed');
      setShowPopUp(true);
      // console.log(reponse);
    } else {
      sessionStorage.setItem('pseudo', state.username)
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
          type="password"
          required={true}
          key="password"
          onChange={(event) => handleChange(event, 'password')}
        />

        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'}
          name="Register"
          onClick={register}
        />
      </div>
      {showPopUp && <PopUp message={err} delay={3000} />}
    </div>
  );
}
