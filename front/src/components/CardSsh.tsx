import React, { useState } from 'react';
import Input from '../components/Input';
import Button from '../components/Button';
import { putFetch } from '../controller/putFetch';

const CardSsh = () => {
  const [state, setState] = useState({
    public_ssh_key: '',
  });
  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function postSsh() {
    console.log(sessionStorage.getItem('user'));
    const reponse = await putFetch(
      `/api/users/ssh`,
      state,
      sessionStorage.getItem('user'),
    );
    console.log(reponse);
  }
  return (
    <div className="flex-col p-4 m-10 text-center border-2 rounded-sm felx bg-whiteViolet border-violet">
      <div className="mb-4">Ssh :</div>
      <Input
        placeholder="Ssh"
        required={true}
        key="Ssh"
        onChange={(event) => handleChange(event, 'public_ssh_key')}
      />
      <div className="mt-10">
        <Button
          className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'}
          name="Confirmed"
          onClick={postSsh}
        />
      </div>
    </div>
  );
};

export default CardSsh;
