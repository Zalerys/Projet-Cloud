import React from 'react';
import '../index.css';
import { useState } from 'react';

interface Props {
  onChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
  placeholder?: string;
  type?: string;
  required?: boolean;
}

const Input: React.FC<Props> = ({
  onChange,
  placeholder,
  type = "text",
  required = false,
}) => {
  const [value, setValue] = useState("");

  return (
    <div className="Input">
      <input
        className="w-40 h-10 p-4 font-light border-current rounded bg-grey placeholder-violet"
        placeholder={placeholder}
        type={type}
        required={required}
        value={value}
        onChange={(event) => {
          setValue(event.target.value);
          onChange(event);
        }}
      ></input>
    </div>
  );
};

export default Input;