import React, { useState } from 'react';
import Input from '../components/Input';
import Button from '../components/Button';
import { putFetch } from '../controller/putFetch';
import { useNavigate } from 'react-router-dom';

const CardListBackup = () => {
  const navigate = useNavigate();

  const [state, setState] = useState({
    new_password: '',
    old_password: '',
  });
  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function update() {
    const reponse = await putFetch(
      `/api/users/pwd`,
      state,
      sessionStorage.getItem('user'),
    );
    if (
      reponse === false ||
      reponse.message === 'Password confirmation failed'
    ) {
      console.log('password failed');
    } else {
      navigate('/homepage');
    }
  }
  return (
    <div className="flex-col p-4 m-10 text-center border-2 rounded-sm felx bg-whiteViolet border-violet">
      <div className="mb-4">Password :</div>
      <div className="flex flex-col items-center gap-7">
        <Input
          placeholder="OldPassword"
          required={true}
          key="name"
          onChange={(event) => handleChange(event, 'old_password')}
        />
        <Input
          placeholder="NewPassword"
          required={true}
          key="password"
          onChange={(event) => handleChange(event, 'new_password')}
        />
        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'}
          name="Update"
          onClick={update}
        />
      </div>
    </div>
  );
};

export default CardListBackup;
