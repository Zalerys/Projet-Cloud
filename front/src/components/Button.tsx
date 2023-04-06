import React from 'react';

export default function Button(props: any) {
  return <button className='h-10 rounded text-whiteViolet w-28 bg-violet'>{props.name}</button>;
}
