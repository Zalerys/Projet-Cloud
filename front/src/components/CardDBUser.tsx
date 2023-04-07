import React, { useState } from 'react';

interface Props {
  name?: string;
  password?: string;
}

const CardDBUser = ({ name = '', password = '' }) => {
  const [showPassword, setShowPassword] = useState(false);
  const [showName, setShowName] = useState(false);

  return (
    <div className="flex-col text-center m-10 bg-whiteViolet rounded-sm border-2 border-violet p-4">
      <div className="mb-6">Identifiant DB :</div>
      <div className="flex row mb-4 space-x-3">
        <p className="basis-2/4">Name :</p>
        <input
          type={showName ? 'text' : 'password'}
          disabled
          className="basis-2/4 rounded-sm bg-white px-3"
          value={name}
        ></input>
        <label className="basis-1/4 relative inline-flex items-center cursor-pointer">
          <input
            type="checkbox"
            value=""
            className="sr-only peer"
            onChange={() => setShowName(!showName)}
          ></input>
          <div className="w-11 h-6 bg-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet dark:peer-focus:ring-violet rounded-full peer dark:bg-darkgrey peer-checked:after:translate-x-full peer-checked:after:border-violet after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-white peer-checked:bg-violet"></div>
        </label>
      </div>
      <div className="flex row  space-x-3 mb-4">
        <p className="basis-2/4">Password :</p>
        <input
          type={showPassword ? 'text' : 'password'}
          disabled
          className="basis-2/4 rounded-sm bg-white px-3"
          value={password}
        ></input>
        <label className="basis-1/4 relative inline-flex items-center cursor-pointer">
          <input
            type="checkbox"
            className="sr-only peer"
            onChange={() => setShowPassword(!showPassword)}
          ></input>
          <div className="w-11 h-6 bg-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet dark:peer-focus:ring-violet rounded-full peer dark:bg-darkgrey peer-checked:after:translate-x-full peer-checked:after:border-violet after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-white peer-checked:bg-violet"></div>
        </label>
      </div>
    </div>
  );
};

export default CardDBUser;
