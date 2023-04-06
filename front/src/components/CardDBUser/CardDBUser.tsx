import React from 'react';

const CardDBUser = () => {
  return (
    <div className="flex-col text-center m-10">
      <div>Identifiant DB :</div>
      <div>
        <div className="flex row">
          <p>Name :</p>
          <input disabled></input>
          <div>
            {/* <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div> */}
          </div>
        </div>
        <div></div>
      </div>
    </div>
  );
};

export default CardDBUser;
