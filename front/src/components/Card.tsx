import React from 'react';
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Button from './Button';

export default function Card() {
  const navigate = useNavigate();  
  const [servers, setServers] = useState([]);

  const toServer = (event: React.MouseEvent<HTMLButtonElement>) => {
    navigate('/server');
  };

  const fetchUserData = () => {
    fetch('api/users/servers')
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        setServers(data);
      });
  };

  useEffect(() => {
    fetchUserData();
  }, []);

  return (
    <>
      <div className="px-6 py-2 border-2 rounded shadow-md bg-whiteViolet border-violet focus:ring-opacity-75">
        <div>
          {servers.length > 0 && (
            <div>
              {/* {servers.map((server) => (
                <div className="text-sm" key={server.id}>
                  <div className="text-xl">{server.name}</div>
                  <div className="bg-violet "></div>
                  <div className="text-sm">{server.auto_backups_time}</div>
                  <div className="text-sm">{server.storage_size}</div>
                </div>
              ))} */}
            </div>
          )}
          <div className="text-center">
            <Button name="Access to Database" onClick={toServer} />
          </div>
        </div>
      </div>
    </>
  );
}
