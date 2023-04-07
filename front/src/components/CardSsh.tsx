import React, { useState } from 'react';
import Input from '../components/Input';
import Button from '../components/Button';
import { postFetch } from '../controller/postFetch';

const CardSsh = () => {
  const [state, setState] = useState({
    ssh: '',
    user: sessionStorage.getItem('user'),
  });
  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function connect() {
    if (state.ssh) {
      if ((await postFetch('/addssh', state)) === false) {
        console.log('error in add ssh');
      } else {
        console.log('Add ssh');
      }
    }
  }
  return (
    <div className="flex-col p-4 m-10 text-center border-2 rounded-sm felx bg-whiteViolet border-violet">
      <div className="mb-4">Password :</div>
      <form className="flex flex-col items-center gap-7" action="post">
        <Input
          placeholder="Ssh"
          required={true}
          key="Ssh"
          onChange={(event) => handleChange(event, 'ssh')}
        />

        <Button className={'h-10 px-6 py-2 rounded text-whiteViolet bg-violet'} name="Login" onClick={connect} />
      </form>
    </div>
  );
};

export default CardSsh;
