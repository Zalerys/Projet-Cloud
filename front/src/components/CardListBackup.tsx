import React, { useState } from 'react';

interface Db {
  id: number;
  name: string;
}

interface Props {
  time?: string | null;
  auto?: string | null;
  path?: string | null;
  dbs?: Array<Db>;
}

const CardListBackup: React.FC<Props> = ({ time, dbs, auto, path }) => {
  return (
    <div className="felx flex-col text-center m-10 bg-whiteViolet rounded-sm border-2 border-violet p-6">
      <div className="text-start">{time}</div>
      <div className="flex row justify-evenly mt-4">
        <div className="mb-80">List Backup:</div>
        <div className="">
          <div>List Db:</div>
          <div>
            {dbs?.map((item) => (
              <div key={item.id}>Name : {item.name}</div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default CardListBackup;
