import React, { useState } from 'react';
import Input from '../components/Input';
import Button from '../components/Button';
import { postFetch } from '../controller/postFetch';

const CardListBackup = () => {
  const [state, setState] = useState({
    oldPassword: '',
    newPassword: '',
    user: sessionStorage.getItem('user'),
  });
  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement>,
    key: keyof typeof state,
  ) => {
    setState({ ...state, [key]: event.target.value });
  };

  async function connect() {
    if ((await postFetch('/modifypassword', state)) === false) {
      console.log('WrongPassword');
    } else {
      console.log('GoodPassword');
    }
  }
  return (
    <div className="felx flex-col text-center m-10 bg-whiteViolet rounded-sm border-2 border-violet p-4">
      <div className="mb-4">Password :</div>
      <form className="flex flex-col items-center gap-7" action="post">
        <Input
          placeholder="OldPassword"
          required={true}
          key="name"
          onChange={(event) => handleChange(event, 'oldPassword')}
        />
        <Input
          placeholder="NewPassword"
          required={true}
          key="password"
          onChange={(event) => handleChange(event, 'newPassword')}
        />
        <Button name="Login" onClick={connect} />
      </form>
    </div>
  );
};

export default CardListBackup;
