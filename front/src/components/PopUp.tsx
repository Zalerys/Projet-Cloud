import '../index.css';
import React, { useState, useEffect } from 'react';

interface Props {
  name?: string;
  message?: any;
  delay?: number;
}

const PopUp: React.FC<Props> = ({ name, message = 'test', delay }) => {
  const [show, setShow] = useState<boolean>(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setShow(false);
    }, delay);

    return () => clearTimeout(timer);
  }, [delay]);

  return (
    <div className={`pop-up ${show ? 'show' : ''}`}>
      <p>{message}</p>
    </div>
  );
};

export default PopUp;
